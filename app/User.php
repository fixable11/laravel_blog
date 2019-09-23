<?php

declare(strict_types=1);

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var array $fillable The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token'
    ];

    /**
     * @var array $hidden The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array $casts The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get user's articles.
     *
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * phpcs:disable
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
}
