<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Properties that can be mass assigned.
     */
    protected $fillable = [
        'name',
        'username',
        'is_active',
        'password',
        'roles',
        'email',
        'phone',
        'id_card',
        'address',
        'avatar',
        'background',
        'jobs',
        'school',
        'company',
    ];

    /**
     * Properties that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Properties should be cast to native types.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }
    /**
     * Each User belongs to a Role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'roles', 'id');
    }
    /**
     * Each User can have many Orders.  
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}


class CustomResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)

    {
        return (new MailMessage)
            ->subject('Recover Password')
            ->line('You just requested ' . config('app.name') . ' to recover your password.')
            ->line('This password reset link will expire in 60 minutes.')
            ->line('Please click the "Recover Password" button below to proceed with obtaining a new password.')
            ->action('Recover Password', url(config('app.url') . route('password.reset', $this->token, false)))
            ->line('If you did not request a password reset, please do nothing further and report this issue to the system administrator.');
    }
}
