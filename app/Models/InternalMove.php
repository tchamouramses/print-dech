<?php

namespace App\Models;

use App\Models\Enums\InternalMoveStatusEnum;
use Illuminate\Database\Eloquent\Model;

class InternalMove extends Model
{
    public function casts() : array
    {
        return [
            'status' => InternalMoveStatusEnum::class,
        ];
    }
}
