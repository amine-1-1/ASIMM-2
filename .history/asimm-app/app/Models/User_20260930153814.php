<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Champs que l'utilisateur peut remplir lui-même.
    // role_id et membership_status n'y sont PAS : seul l'admin les change.
    protected $fillable = [
        'name', 'first_name', 'last_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
        ];
    }

    // Chaque nouvel inscrit reçoit automatiquement le rôle "membre".
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (! $user->role_id) {
                $user->role_id = Role::where('name', 'membre')->value('id');
            }
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }
}
