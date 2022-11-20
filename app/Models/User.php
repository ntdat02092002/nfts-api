<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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

    public function accounts_balance()
    {
        return $this->hasMany('App\Models\AccountBalance');
    }

    public function nfts_onwed()
    {
        return $this->hasMany('App\Models\Nft', 'owner_id');
    }

    public function nfts_created()
    {
        return $this->hasMany('App\Models\Nft', 'creator_id');
    }

    public function collections_onwed()
    {
        return $this->hasMany('App\Models\Collection', 'owner_id');
    }

    public function collections_created()
    {
        return $this->hasMany('App\Models\Collection', 'creator_id');
    }
}
