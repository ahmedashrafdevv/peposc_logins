<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'status',
        "password"
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:m:s',
    ];

    /**
     * Get the user logins.
     */
    public function logins()
    {
        return $this->hasMany(Login::class);
    }
}

