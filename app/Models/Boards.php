<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boards extends Model
{
    use HasFactory;

    protected $table = 'boards';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }

    public function tasks(): BelongsTo
    {
        return $this->belongsTo(Tasks::class, 'id', 'board_id');
    }
}
