<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'account_id',
        'role_id',
        'password',
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

    /**
     * This is a PHP function that retrieves a user by their ID.
     * 
     * @param query The query parameter is an instance of the Eloquent query builder, which allows you
     * to build and execute database queries in your Laravel application.
     * @param userId The parameter `` is a variable that represents the ID of a user. It is used
     * in the `scopeGetUserById` function to retrieve a user from the database based on their ID.
     * 
     * @return The function `scopeGetUserById` is returning a query result for the user with the
     * specified ``. The `first()` method is used to retrieve the first result of the query.
     */
    public function scopeGetUserById($query, $userId)
    {
        return $query->join('user_info', 'users.id', 'user_info.user_id')
            ->where('users.id', $userId)
            ->first();
    }

}
