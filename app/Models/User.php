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
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }


    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user1_id')->orWhere('user2_id', $this->id);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

}
