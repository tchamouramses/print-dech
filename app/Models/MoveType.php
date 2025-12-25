<?php

namespace App\Models;

use App\Models\Enums\MoveRangeEnum;
use Illuminate\Database\Eloquent\Model;

class MoveType extends Model
{
    protected $guarded = [];

    public function casts() : array
    {
        return [
            'range' => MoveRangeEnum::class,
        ];
    }
}
