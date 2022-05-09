<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
        'balance'
    ];

    /**
     * Add `avatar` attribute.
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?d='.url('/images/avatar.png').'&s=40';
    }

    /**
     * Setup relation with transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Setup relation with CSV imports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function csvs()
    {
        return $this->hasMany(CSV::class);
    }

    /**
     * Add `balance` attribute.
     *
     * @return float
     */
    public function getBalanceAttribute()
    {
        return $this->transactions()->sum('amount');
    }
}
