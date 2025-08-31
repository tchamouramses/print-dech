<?php

namespace App\Services;

use App\Models\Transaction;

class InvoiceService
{
    // print transaction invoice
    public function printInvoice(Transaction $transaction)
    {
        $enterprise = \App\Models\Profil::first();

    }
}
