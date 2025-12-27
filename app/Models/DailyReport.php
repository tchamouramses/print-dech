<?php

namespace App\Models;

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
            $report->user_id = Auth::id();
            $report->is_initial = !self::where('move_type_id', $report->move_type_id)->exists();
            $bilan = Bilan::where('date', Carbon::parse($report->day)->format('Y-m-d'))->firstOrCreate(['date' => Carbon::parse($report->day)->format('Y-m-d')]);
            $report->bilan_id = $bilan->id;
            $report->variation_amount = 0;
        });

        static::created(function (DailyReport $report) {
            $report->bilan->regenerateAllMetrics();
        });

        static::updated(function (DailyReport $report) {
            $report->bilan->regenerateAllMetrics();
        });

        static::deleted(function (DailyReport $report) {
            $bilan = Bilan::find($report->bilan_id);
            $bilan->regenerateAllMetrics();
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
