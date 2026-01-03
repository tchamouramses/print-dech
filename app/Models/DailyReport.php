<?php

namespace App\Models;

use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class DailyReport extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (DailyReport $report) {
            $report->is_initial = !self::where('move_type_id', $report->move_type_id)->exists();
            $user = Auth::user();
            $report->user_id = $user->id;
            $pointOfSaleId = $report->point_of_sale_id;
            if($user->role === UserRoleEnum::USER){
                $pointOfSaleId = $user->pointOfSales()->first()?->id;
            }
            $bilan = Utils::getCurrentBilan($report->day, $pointOfSaleId);
            $report->bilan_id = $bilan->id;
            $report->variation_amount = 0;
        });

        static::created(function (DailyReport $report) {
            $report->bilan->regenerateAllMetrics(false);
        });

        static::updated(function (DailyReport $report) {
            $report->bilan->regenerateAllMetrics(false);
        });

        static::deleted(function (DailyReport $report) {
            $bilan = Bilan::find($report->bilan_id);
            $bilan->regenerateAllMetrics(false);
        });
    }

    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function moveType(): BelongsTo
    {
        return $this->belongsTo(MoveType::class);
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
