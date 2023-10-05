<?php

namespace App\Repositories;

use App\Repositories\Interface\RepositoryInterface;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\DB;
use PDOException;

abstract class Repository implements RepositoryInterface
{
    protected Model $model;
    protected array $select = [];
    private ?Closure $_as = null;

    protected string $idColumnName = 'id';

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make(
            $this->getModel()
        );
        $this->init();
        $this->makeAs();
    }

    protected function init(): void {}

    abstract public function getModel(): string;

    public function as(callable $callback): void
    {
        $this->_as = $callback;
    }

    private function useAs(Builder $query): Builder
    {
        return is_callable($this->_as) ? call_user_func($this->_as, $query) : $query;
    }
    protected function clearAs(): static
    {
        $this->_as = null;
        return $this;
    }

    protected function makeAs(): void {}

    private function cloneModel(): Model
    {
        return clone $this->model;
    }

    public function getAll(): EloquentCollection|SupportCollection
    {
        $query = $this->cloneModel()->newQuery();
        $query = $this->useAs($query);
        return $query->get();
    }

    public function find(array|int|string $column, mixed $value = null): EloquentCollection|SupportCollection
    {
        if (gettype($column) === 'array') {
            $condition = $column;
        } else if ($value) {
            $condition = [$column => $value];
        } else {
            $condition = [$this->idColumnName => $column];
        }

        $query = $this->model->where($condition);
        $query = $this->useAs($query);
        return $query->get();
    }

    public function first(array|int|string $column, int|string|null $value = null): Model|null
    {
        $data = $this->find($column, $value);
        return $data->count() === 0 ? null : $data->first();
    }

    public function create(array $attributes = []): Model|bool
    {
        $model = $this->cloneModel();
        foreach ($attributes as $column => $value) {
            $model->{$column} = $value;
        }
        DB::beginTransaction();
        try {
            $model->save();
            DB::commit();
            return $model;
        } catch (Exception|PDOException $e) {
            DB::rollBack();
            logger($e);
            return false;
        }
    }

    public function update($id, $attributes = []): bool
    {
        $model = clone $this->model;
        $data = $model->where($this->idColumnName, $id)->first();
        if (!$data) return false;
        DB::beginTransaction();
        try {
            foreach ($attributes as $column => $value) {
                $data->{$column} = $value;
            }
            $data->save();
            DB::commit();
            return true;
        } catch (Exception|PDOException $e) {
            DB::rollBack();
            logger($e);
            return false;
        }
    }

    public function delete($id): bool
    {
        $model = clone $this->model;
        $data = $model->where($this->idColumnName, $id)->first();
        if (!$data) return false;
        DB::beginTransaction();
        try {
            $data->delete();
            DB::commit();
            return true;
        } catch (Exception|PDOException $e) {
            DB::rollBack();
            logger($e);
            return false;
        }
    }
}
