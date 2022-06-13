<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Subject extends EloquentModel
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'subjects';

    protected $fillable = [
        'title',
        'image',
        'description',
    ];
}
