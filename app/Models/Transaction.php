<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($transaction) {
                $transaction->user_id = Auth::id();
                $transaction->reference = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
