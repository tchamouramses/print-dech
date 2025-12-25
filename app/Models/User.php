<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Enums\UserRoleEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRoleEnum::class,
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, [UserRoleEnum::ADMIN, UserRoleEnum::USER, UserRoleEnum::POINT_OF_SALES]);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRoleEnum::ADMIN;
    }

    public function pointOfSales(): BelongsToMany
    {
        return $this->belongsToMany(PointOfSale::class, 'point_of_sale_user');
    }

    public function externalMoves(): HasMany
    {
        return $this->hasMany(ExternalMove::class);
    }

    public function internalMoves(): HasMany
    {
        return $this->hasMany(InternalMove::class);
    }
}
