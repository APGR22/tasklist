<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'users_id',
        'tasks_included'
    ];

    protected function casts()
    {
        return [
            'users_id' => 'array',
            'tasks_included' => 'array'
        ];
    }
}
