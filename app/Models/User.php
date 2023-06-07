<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use App\Notifications\FullRegistrationNotification;
use App\Notifications\VerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'zip_code',
        'state',
        'city',
        'address',
        'tel',
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
        'password' => 'hashed',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function sendFullRegistrationNotification()
    {
        $this->notify(new FullRegistrationNotification());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function isFullRegistered(): bool
    {
        return $this->email_verified_at !== null
            && $this->name !== null
            && $this->nickname !== null
            && $this->zip_code !== null
            && $this->state !== null
            && $this->city !== null
            && $this->address !== null
            && $this->tel !== null;
    }
}
