<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    protected $table = 'forms';
    protected $fillable = ['name',
        'description',
        'file',
        'archive',
        'root',
        'code',
        'final',

    ];

    use HasFactory, SoftDeletes;
}
