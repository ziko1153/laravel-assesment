<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'user_name',
        'registered_at',
        'user_role',
        'avatar',
        'email',
        'pin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin',
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // this is which i am following to other user

    public function user_following()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'user_id', 'follower_id');
    }
    // this is other people follow me 
    public function user_followers()
    {

        return $this->belongsToMany(User::class, 'user_followers', 'follower_id', 'user_id');
    }

    public function page_following()
    {

        return $this->belongsToMany(User::class, 'page_followers', 'follower_id', 'follower_id')->withPivot(['page_id']);
    }
}
