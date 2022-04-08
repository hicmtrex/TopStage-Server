<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;


class Question extends EloquentModel
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'questions';

    protected $casts = [
        'answers' => 'array',
    ];

    protected $fillable = [
        'title',
        'content',
        'answers',
        'categories',
        'difficulty'

    ];
}
