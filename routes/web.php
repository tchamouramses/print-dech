<?php

use Illuminate\Support\Facades\Route;

Route::get('/in', function () {
    return view('pdf.invoice');
})->name('in');
