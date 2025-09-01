<?php

namespace App\Services;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    // print transaction invoice
    public function printInvoice(Transaction $transaction)
    {
        $enterprise = \App\Models\Profil::first();
        $pdf = Pdf::loadView('pdf.invoice', compact('transaction', 'enterprise'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'facture-' . $transaction->reference . '.pdf');
    }
}
