<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    protected string $idColumnName = 'uuid';

    public function getModel(): string
    {
        return User::class;
    }

    // protected function makeAs(): void
    // {
    //     $this->as(function($query) {
    //         return $query->with(['user', 'board']);
    //     });
    // }
}
