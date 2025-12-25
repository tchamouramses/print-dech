<?php

namespace App\Models;

use App\Models\Enums\ExternalMoveTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ExternalMove extends Model
{
    protected $guarded = [];
    protected function casts(): array
    {
        return [
            'type' => ExternalMoveTypeEnum::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ExternalMove $move) {
            $move->user_id = Auth::id();
            if ($move->type === ExternalMoveTypeEnum::OUT && $move->amount > 0){
                $move->amount = -1 * $move->amount;
            }
            if ($move->type === ExternalMoveTypeEnum::INCOME && $move->amount < 0){
                $move->amount = -1 * $move->amount;
            }
        });

        static::updating(function (ExternalMove $move) {
            if ($move->type === ExternalMoveTypeEnum::OUT && $move->amount > 0){
                $move->amount = -1 * $move->amount;
            }
            if ($move->type === ExternalMoveTypeEnum::INCOME && $move->amount < 0){
                $move->amount = -1 * $move->amount;
            }
        });
    }

    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ExternalMove::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
