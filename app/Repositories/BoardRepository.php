<?php

namespace App\Repositories;

use App\Models\Boards;

class BoardRepository extends Repository
{
    protected string $idColumnName = 'uuid';

    public function getModel(): string
    {
        return Boards::class;
    }

    protected function makeAs(): void
    {
        $this->as(function ($query) {
            return $query->with(['user', 'project', 'tasks']);
        });
    }
}
