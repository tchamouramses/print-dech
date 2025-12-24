<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PointOfSale extends Model
{
    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'point_of_sale_user');
    }

    public function externalMoves(): HasMany
    {
        return $this->hasMany(ExternalMove::class);
    }

    public function receivedInternalMove(): HasMany
    {
        return $this->hasMany(InternalMove::class, 'point_receiver_id');
    }

    public function sendInternalMove(): HasMany
    {
        return $this->hasMany(InternalMove::class, 'point_sender_id');
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }
}
