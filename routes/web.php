<?php

use Illuminate\Support\Facades\Route;

 Route::get('/in', function () {

        $enterprise = \App\Models\Profil::first();
        $transaction = \App\Models\Transaction::first();
    return view('pdf.invoice', compact('transaction', 'enterprise'));
 });
