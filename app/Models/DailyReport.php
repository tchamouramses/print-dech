<?php

namespace App\Models;

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
            $report->gap_amount = 0;
            $report->recap_amount = 0;
            $report->is_initial = false;
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
}
