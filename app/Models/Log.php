<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
    'source',
    'type_log',
    'log',
    'textobs',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
