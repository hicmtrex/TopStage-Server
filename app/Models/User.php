<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;
use Illuminate\Auth\Passwords\CanResetPassword;




class User extends EloquentModel
{
    use HasApiTokens, Notifiable, HasFactory, CanResetPassword;

    protected $connection = 'mongodb';
    protected $collection  = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'cin',
        'domaine',
        'coordinator',
        'service_rh',
        'encadrant',
        'status',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
