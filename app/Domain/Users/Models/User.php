<?php

declare(strict_types=1);

namespace App\Domain\Users\Models;

use App\Domain\Sessions\Models\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function savedSessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'user_sessions')
            ->withPivot('notify')
            ->withTimestamps();
    }
}
