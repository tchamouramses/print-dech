<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            color: #44403c;
            background: #fafaf9;
            padding: 24px;
            min-height: 100vh;
        }

        /* Container principal */
        .invoice-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e7e5e4;
        }

        /* En-tête minimal */
        .invoice-header {
            background: #78716c;
            color: white;
            padding: 24px 32px;
            border-bottom: 2px solid #57534e;
        }

        .header-content h1 {
            font-size: 1.8em;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .invoice-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9em;
            opacity: 0.9;
        }

        .invoice-number {
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 500;
        }

        .invoice-date {
            font-weight: 400;
        }

        /* Sections */
        section {
            padding: 20px 32px;
            border-bottom: 1px solid #e7e5e4;
        }

        section:last-of-type {
            border-bottom: none;
        }

        section h2 {
            font-size: 1em;
            font-weight: 600;
            color: #57534e;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Grille d'informations */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .info-item .label {
            font-size: 0.8em;
            font-weight: 500;
            color: #78716c;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-item .value {
            font-size: 0.9em;
            font-weight: 500;
            color: #44403c;
        }

        /* Transaction */
        .transaction-card {
            background: #fafaf9;
            border-radius: 6px;
            padding: 16px;
            border: 1px solid #e7e5e4;
        }

        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #d6d3d1;
        }

        .transaction-id {
            font-family: 'Courier New', monospace;
            font-size: 0.85em;
            font-weight: 500;
            color: #57534e;
            background: #e7e5e4;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .transaction-time {
            font-size: 0.85em;
            color: #78716c;
            font-weight: 400;
        }

        .transaction-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            align-items: end;
        }

        .employee {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .employee .label {
            font-size: 0.8em;
            font-weight: 500;
            color: #78716c;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .employee .value {
            font-size: 0.9em;
            font-weight: 500;
            color: #44403c;
        }

        .amount {
            text-align: right;
        }

        .amount-label {
            display: block;
            font-size: 0.8em;
            font-weight: 500;
            color: #78716c;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }

        .amount-value {
            font-size: 1.5em;
            font-weight: 700;
            color: #44403c;
        }

        /* Pied de page minimal */
        .invoice-footer {
            padding: 20px 32px;
            background: #fafaf9;
        }

        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 16px;
        }

        .signature {
            text-align: center;
        }

        .signature-line {
            width: 100px;
            height: 1px;
            background: #a8a29e;
            margin: 0 auto 6px;
        }

        .signature span {
            font-size: 0.8em;
            font-weight: 500;
            color: #78716c;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .footer-text {
            text-align: center;
            font-size: 0.9em;
            color: #a8a29e;
            font-style: italic;
            font-weight: 400;
        }

        /* Styles d'impression optimisés */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
                max-width: none;
                margin: 0;
                border: none;
            }

            .invoice-header {
                background: #78716c !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            section {
                page-break-inside: avoid;
            }
        }

        /* Responsive pour mobile */
        @media (max-width: 640px) {
            body {
                padding: 16px;
            }

            .invoice-container {
                border-radius: 6px;
            }

            .invoice-header {
                padding: 20px;
            }

            .header-content h1 {
                font-size: 1.6em;
            }

            .invoice-meta {
                flex-direction: column;
                gap: 6px;
                align-items: flex-start;
            }

            section {
                padding: 16px 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .transaction-details {
                grid-template-columns: 1fr;
                gap: 10px;
                text-align: left;
            }

            .amount {
                text-align: left;
            }

            .signatures {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- En-tête moderne -->
        <header class="invoice-header">
            <div class="header-content">
                <h1>FACTURE</h1>
                <div class="invoice-meta">
                    <span class="invoice-number">FAC-2025-001</span>
                    <span class="invoice-date">15 Janvier 2025</span>
                </div>
            </div>
        </header>

        <!-- Informations entreprise -->
        <section class="company-section">
            <h2>Entreprise</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nom</span>
                    <span class="value">ENTREPRISE SARL</span>
                </div>
                <div class="info-item">
                    <span class="label">Téléphone</span>
                    <span class="value">+221 33 123 45 67</span>
                </div>
                <div class="info-item">
                    <span class="label">Siège social</span>
                    <span class="value">123 Avenue Bourguiba, Dakar, Sénégal</span>
                </div>
                <div class="info-item">
                    <span class="label">NIU</span>
                    <span class="value">123456789012345</span>
                </div>
            </div>
        </section>

        <!-- Informations client -->
        <section class="client-section">
            <h2>Client</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nom</span>
                    <span class="value">AMADOU DIALLO</span>
                </div>
                <div class="info-item">
                    <span class="label">Téléphone</span>
                    <span class="value">+221 77 987 65 43</span>
                </div>
                <div class="info-item">
                    <span class="label">Commissionnaire</span>
                    <span class="value">MARIE NDIAYE</span>
                </div>
            </div>
        </section>

        <!-- Transaction -->
        <section class="transaction-section">
            <h2>Transaction</h2>
            <div class="transaction-card">
                <div class="transaction-header">
                    <div class="transaction-id">TXN-240115-001456</div>
                    <div class="transaction-time">14:30:25</div>
                </div>
                <div class="transaction-details">
                    <div class="employee">
                        <span class="label">Employé</span>
                        <span class="value">OUSMANE FALL</span>
                    </div>
                    <div class="amount">
                        <span class="amount-label">Montant</span>
                        <span class="amount-value">75 000 FCFA</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Signatures -->
        <footer class="invoice-footer">
            <div class="signatures">
                <div class="signature">
                    <div class="signature-line"></div>
                    <span>Signature Client</span>
                </div>
                <div class="signature">
                    <div class="signature-line"></div>
                    <span>Signature Entreprise</span>
                </div>
            </div>
            <div class="footer-text">Merci pour votre confiance</div>
        </footer>
    </div>
</body>

</html>
