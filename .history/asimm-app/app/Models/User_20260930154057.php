<?php

namespace App\Models;
  protected $fillable = ['name', 'label'];
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'first_name', 'last_name','email', 'password'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
            'password' => 'hashed',
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
