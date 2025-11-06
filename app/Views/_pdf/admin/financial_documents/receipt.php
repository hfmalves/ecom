<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .company, .client { width: 48%; display: inline-block; vertical-align: top; }
        .company { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f4f4f4; }
        .right { text-align: right; }
    </style>
</head>
<body>
<div class="header">
    <h2>RECIBO</h2>
    <p>Série: <?= esc($document['series']) ?> | Nº <?= esc($document['number']) ?> | Data: <?= esc($document['date']) ?></p>
</div>

<div>
    <div class="company">
        <strong><?= esc($company['name']) ?></strong><br>
        <?= esc($company['address']) ?><br>
        NIF: <?= esc($company['vat']) ?><br>
        Email: <?= esc($company['email']) ?>
    </div>

    <div class="client">
        <strong>Cliente:</strong><br>
        <?= esc($customer['name']) ?><br>
        NIF: <?= esc($customer['vat']) ?><br>
        <?= esc($customer['address']) ?><br>
        <?= esc($customer['email']) ?>
    </div>
</div>

<p><strong>Referência da Fatura:</strong> <?= esc($document['reference'] ?? '—') ?></p>

<table>
    <thead>
    <tr><th>Método</th><th>Data</th><th>Referência</th><th class="right">Valor Pago</th></tr>
    </thead>
    <tbody>
    <tr>
        <td><?= esc($payment['method'] ?? '—') ?></td>
        <td><?= esc($payment['date'] ?? $document['date']) ?></td>
        <td><?= esc($payment['reference'] ?? '—') ?></td>
        <td class="right"><?= number_format($payment['amount'], 2, ',', ' ') ?> €</td>
    </tr>
    </tbody>
</table>

<p><strong>Total Recebido:</strong> <?= number_format($payment['amount'], 2, ',', ' ') ?> €</p>

<p><em><?= esc($document['notes'] ?? 'Comprovativo de pagamento da fatura acima indicada.') ?></em></p>
</body>
</html>
