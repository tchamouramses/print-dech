<?php

namespace App\Models;

use App\Models\Enums\ExternalMoveTypeEnum;
use App\Models\Enums\UserRoleEnum;
use App\Utils\Utils;
use Carbon\Carbon;
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
            if ($move->type === ExternalMoveTypeEnum::OUT && $move->amount > 0){
                $move->amount = -1 * $move->amount;
            }
            if ($move->type === ExternalMoveTypeEnum::INCOME && $move->amount < 0){
                $move->amount = -1 * $move->amount;
            }

            $user = Auth::user();
            $move->user_id = $user->id;
            if($user->role === UserRoleEnum::USER){
                $move->point_of_sale_id = $user->pointOfSales()->first()?->id;
            }
            $bilan = Utils::getCurrentBilan($move->date, $move->point_of_sale_id);
            $move->bilan_id = $bilan->id;
        });

        static::updating(function (ExternalMove $move) {
            if ($move->type === ExternalMoveTypeEnum::OUT && $move->amount > 0){
                $move->amount = -1 * $move->amount;
            }
            if ($move->type === ExternalMoveTypeEnum::INCOME && $move->amount < 0){
                $move->amount = -1 * $move->amount;
            }
        });

        static::created(function (ExternalMove $move) {
            $move->bilan->regenerateAllMetrics(false);
        });

        static::updated(function (ExternalMove $move) {
            $move->bilan->regenerateAllMetrics(false);
        });

        static::deleted(function (ExternalMove $move) {
            $bilan = Bilan::find($move->bilan_id);
            $bilan->regenerateAllMetrics(false);
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

    public function bilan(): BelongsTo
    {
        return $this->belongsTo(Bilan::class);
    }

}
