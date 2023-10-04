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
}
