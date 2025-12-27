<?php

namespace App\Models;

use App\Models\Enums\InternalMoveStatusEnum;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class InternalMove extends Model
{
    protected $guarded = [];
    public function casts() : array
    {
        return [
            'status' => InternalMoveStatusEnum::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (InternalMove $move) {
            $move->sender_id = Auth::id();
            $bilan = Utils::getCurrentBilan($move->send_date, $move->point_of_sale_id);
            $move->bilan_id = $bilan->id;
        });

        static::updating(function (InternalMove $move) {
            if($move->status === InternalMoveStatusEnum::RECEIVE){
                $move->receiver_id = Auth::id();
                $move->received_date = now();
            }
        });

        static::created(function (InternalMove $move) {
            $move->bilan->regenerateAllMetrics();
        });

        static::updated(function (InternalMove $move) {
            $move->bilan->regenerateAllMetrics();
        });

        static::deleted(function (InternalMove $move) {
            $bilan = Bilan::find($move->bilan_id);
            $bilan->regenerateAllMetrics();
        });
    }

    public function senderPoint(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class, 'point_sender_id');
    }

    public function receiverPoint(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class, 'point_receiver_id');
    }

    public function moveType(): BelongsTo
    {
        return $this->belongsTo(MoveType::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function bilan(): BelongsTo
    {
        return $this->belongsTo(Bilan::class);
    }
}
