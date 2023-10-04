<?php

namespace App\Repositories;

use App\Models\Tasks;

class TaskRepository extends Repository
{
    protected string $idColumnName = 'uuid';

    public function getModel(): string
    {
        return Tasks::class;
    }

    protected function makeAs(): void
    {
        $this->as(function($query) {
            return $query->with(['user', 'board']);
        });
    }
}
