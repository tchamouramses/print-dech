<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Bilan extends Model
{
    protected $guarded = [];

    protected  function casts(): array
    {
        return ['date' => 'date'];
    }
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

    public function regenerateAllMetrics($generateOtherMetrics = true): void
    {
        $this->daily_report_amount = $this->dailyReports()->sum('amount');
        $this->daily_commission_amount = $this->dailyReports()->sum('commission_amount');
        $this->daily_tip_amount = $this->dailyReports()->sum('tip_amount');
        $this->total_external_move_amount = $this->externalMoves()->sum('amount');
        $internalMoves = InternalMove::whereBetween('send_date', [Carbon::parse($this->date)->startOfDay(), Carbon::parse($this->date)->endOfDay()])->get();
        $this->total_internal_move_amount = 0;

        $lastBilan = self::where('date', '<=', $this->date)
            ->whereNot('id', $this->id)
            ->where('point_of_sale_id', $this->point_of_sale_id)
            ->latest('date')
            ->first();

        foreach ($internalMoves as $move) {
            $this->total_internal_move_amount += (($this->point_of_sale_id == $move->point_sender_id ? -1 : ($this->point_of_sale_id == $move->point_receiver_id ? 1 : 0)) * $move->amount);
        }

        $this->daily_gap_amount = isset($lastBilan) ?
            $this->daily_report_amount - $lastBilan->daily_report_amount - ($this->total_external_move_amount + $this->total_internal_move_amount)
            : 0;

        $this->save();
        $this->refresh();
        if($generateOtherMetrics) {
            $this->generateAllBilanOfDay();
        }
    }

    public function generateAllBilanOfDay(){
        Bilan::whereYear('date', $this->date->year)
            ->whereMonth('date', $this->date->month)
            ->whereDay('date', $this->date->day)
            ->whereNot('id', $this->id)
            ->get()
            ->each(function (Bilan $bilan) {
                $bilan->regenerateAllMetrics(false);
            });
    }

    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
    }
}
