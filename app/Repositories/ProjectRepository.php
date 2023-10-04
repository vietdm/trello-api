<?php

namespace App\Repositories;

use App\Models\Projects;

class ProjectRepository extends Repository
{
    protected string $idColumnName = 'uuid';

    public function getModel(): string
    {
        return Projects::class;
    }

    protected function makeAs(): void
    {
        $this->as(function($query) {
            return $query->with(['user']);
        });
    }
}
