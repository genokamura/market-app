<?php

namespace App\Models;

use App\Notifications\EmailAddressChangedNotification;
use App\Notifications\FullRegistrationNotification;
use App\Notifications\PasswordResetNotification;
use App\Notifications\PasswordUpdatedNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    public function sendPasswordUpdatedNotification()
    {
        $this->notify(new PasswordUpdatedNotification());
    }

    public function sendEmailAddressChangedNotification()
    {
        $this->notify(new EmailAddressChangedNotification());
    }

    public function isFullRegistered(): bool
    {
        return $this->name !== null
            && $this->nickname !== null
            && $this->zip_code !== null
            && $this->state !== null
            && $this->city !== null
            && $this->address !== null
            && $this->tel !== null;
    }
}
