<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bilan extends Model
{
    protected $guarded = [];

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function internalMoves(): HasMany
    {
        return $this->hasMany(InternalMove::class);
    }

    public function externalMoves(): HasMany
    {
        return $this->hasMany(ExternalMove::class);
    }

    public function generateGap(): void
    {
        $lastBilan = self::whereNot('id', $this->id)->latest()->first();
        if (isset($lastBilan)) {
            $this->daily_gap_amount = $this->daily_report_amount - ($lastBilan->daily_report_amount + $this->total_external_move_amount + $lastBilan->total_internal_move_amount);
            $this->save();
        }
    }

    public function regenerateAllMetrics(): void
    {
        $this->daily_report_amount = $this->dailyReports()->sum('amount');
        $this->daily_commission_amount = $this->dailyReports()->sum('commission_amount');
        $this->daily_tip_amount = $this->dailyReports()->sum('tip_amount');
        $this->total_external_move_amount = $this->externalMoves()->sum('amount');
        $internalMoves = $this->internalMoves()->get();
        $this->total_internal_move_amount = 0;
        foreach ($internalMoves as $move) {
            $this->total_internal_move_amount += ($move->moveType->is_positive ? 1 : -1) * $move->amount;
        }

        $this->save();
        $this->refresh();
        $this->generateGap();
    }
}
