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

    public function getImageAttribute() {
        return $this->operateur === ContactOperatorEnum::Orange ? public_path('images/orange.jpg') : public_path('images/mtn.jpg');
    }
}
