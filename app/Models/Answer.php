<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Answer extends EloquentModel
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'answers';



    protected $fillable = [
        'user_id',
        'user_name',
        'categories',
        'difficulty',
        "score",
        "result"

    ];
}
