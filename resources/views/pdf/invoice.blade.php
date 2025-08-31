<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
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
