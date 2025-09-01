<?php

namespace App\Models;

use App\Models\Enums\ContactOperatorEnum;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected function casts()
    {
        return [
            'operateur' => ContactOperatorEnum::class
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
