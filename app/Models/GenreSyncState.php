<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreSyncState extends Model
{
    protected $fillable = [
        'genre_id',
        'name',
        'current_index',
        'max_limit',
        'is_paused',
        'is_exhausted',
        'last_fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'last_fetched_at' => 'datetime',
        ];
    }
}
