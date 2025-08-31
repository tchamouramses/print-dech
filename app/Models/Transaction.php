<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'contact_id',
        'amount',
        'sender',
    ];

    // deficnir l'utilisateur comme l'utilisateur connecté a la création de la transaction
    protected static function booted()
    {
        static::creating(function ($transaction) {
                $transaction->user_id = Auth::id();
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
