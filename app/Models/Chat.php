<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'uuid',
        'data',
        'in_task'
    ];

    protected function casts()
    {
        return [
            'data' => 'array'
        ];
    }
}
