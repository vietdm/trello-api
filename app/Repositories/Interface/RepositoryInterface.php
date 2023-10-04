<?php

namespace App\Repositories\Interface;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Get all
     * @return EloquentCollection|SupportCollection
     */
    public function getAll(): EloquentCollection|SupportCollection;

    /**
     * Search with condition
     * @param array|int|string $column
     * @param int|string|null $value
     * @return EloquentCollection|SupportCollection
     */
    public function find(array|int|string $column, int|string|null $value = null): EloquentCollection|SupportCollection;

    /**
     * Get one with condition
     * @param array|int|string $column
     * @param int|string|null $value
     * @return Model|null
     */
    public function first(array|int|string $column, int|string|null $value = null): Model|null;

    /**
     * Create
     * @param array $attributes
     * @return Model|bool
     */
    public function create(array $attributes = []): Model|bool;

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function update($id, array $attributes = []): bool;

    /**
     * Delete
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
