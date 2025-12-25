<?php

namespace App\Models;

use App\Models\Enums\InternalMoveStatusEnum;
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
        });

        static::updating(function (InternalMove $move) {
            if($move->status === InternalMoveStatusEnum::RECEIVE){
                $move->receiver_id = Auth::id();
                $move->received_date = now();
            }
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
}
