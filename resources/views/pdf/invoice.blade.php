<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        @page { margin: 20px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        .container {
            width: 100%;
        }

        /* HEADER */
        .header {
            background: #2d3748;
            color: white;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header table {
            width: 100%;
            margin-top: 5px;
            font-size: 12px;
        }
        .header td {
            padding: 2px 0;
        }

        /* SECTION */
        .section {
            margin-top: 20px;
        }
        .section h2 {
            font-size: 14px;
            color: #2d3748;
            margin-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 3px;
            text-transform: uppercase;
        }

        /* TABLES D’INFOS */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            width: 50%;
            padding: 5px 0;
            vertical-align: top;
        }
        .label {
            font-size: 11px;
            font-weight: bold;
            color: #4a5568;
            text-transform: uppercase;
        }
        .value {
            font-size: 12px;
            color: #1a202c;
        }

        /* TRANSACTION */
        .transaction-box {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 12px;
            margin-top: 10px;
        }
        .transaction-header {
            border-bottom: 1px solid #cbd5e0;
            margin-bottom: 8px;
            padding-bottom: 5px;
            font-size: 12px;
        }
        .transaction-id {
            font-family: Courier, monospace;
            font-weight: bold;
        }
        .transaction-time {
            float: right;
            color: #718096;
        }
        .amount {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            color: #2d3748;
        }

        /* SIGNATURES */
        .signatures {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }
        .signatures td {
            width: 50%;
            padding: 20px;
        }
        .signature-line {
            border-top: 1px solid #a0aec0;
            width: 150px;
            margin: 0 auto 5px auto;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #a0aec0;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h1>FACTURE</h1>
            <table>
                <tr>
                    <td>Ref: <strong>{{ $transaction->reference }}</strong></td>
                    <td align="right">Date : {{ $transaction->created_at->translatedFormat('d M Y') }}</td>
                </tr>
            </table>
        </div>

        <!-- ENTREPRISE -->
        <div class="section">
            <h2>Entreprise</h2>
            <table class="info-table">
                <tr>
                    <td><span class="label">Nom</span><br><span class="value">{{ $enterprise->name }}</span></td>
                    <td><span class="label">Téléphone</span><br><span class="value">{{ $enterprise->phone1 . (isset($enterprise->phone2) ? '/' . $enterprise->phone2 : '') }}</span></td>
                </tr>
                <tr>
                    <td><span class="label">Siège social</span><br><span class="value"> {{ $enterprise->head_office }} </span></td>
                    <td><span class="label">N° Cont</span><br><span class="value">{{ $enterprise->niu }}</span></td>
                </tr>
            </table>
        </div>

        <!-- CLIENT -->
        <div class="section">
            <h2>Client</h2>
            <table class="info-table">
                <tr>
                    <td><span class="label">Nom</span><br><span class="value">{{$transaction->client->name}} </span></td>
                    <td><span class="label">Téléphone</span><br><span class="value">{{$transaction->client->phone}}</span></td>
                </tr>
                <tr>
                    <td><span class="label">Commissionnaire</span><br><span class="value">{{$transaction->sender}}</span></td>
                </tr>
            </table>
        </div>

        <!-- TRANSACTION -->
        <div class="section">
            <h2>Transaction</h2>
            <div class="transaction-box">
                <div class="transaction-header">
                    <span class="transaction-id">{{ $transaction->reference }}</span>
                    <span class="transaction-time">{{ $transaction->created_at->format('h:i') }}</span>
                </div>
                <table width="100%">
                    <tr>
                        <td>
                            <span class="label">Employé</span><br>
                            <span class="value">{{ $transaction->user->name }}</span>
                        </td>
                        <td class="amount">{{ $transaction->amount }} FCFA</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- SIGNATURES -->
        <table class="signatures">
            <tr>
                <td>
                    <div class="signature-line"></div>
                    Signature Client
                </td>
                <td>
                    <div class="signature-line"></div>
                    Signature Entreprise
                </td>
            </tr>
        </table>

        <div class="footer">
            Merci pour votre confiance
        </div>

    </div>
</body>
</html>
