<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'in_group',
        'users_voted',
        'chat_id'
    ];

    protected function casts()
    {
        return [
            'users_voted' => 'array'
        ];
    }
}
