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
    <h2>NOTA DE DÉBITO</h2>
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

<p><strong>Documento associado:</strong> Fatura <?= esc($document['reference'] ?? '—') ?></p>

<table>
    <thead>
    <tr>
        <th>Descrição</th><th>Qtd</th><th>Preço Unit.</th><th>IVA</th><th>Total</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= esc($item['name']) ?></td>
            <td><?= esc($item['qty']) ?></td>
            <td class="right"><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
            <td class="right"><?= number_format($item['vat_rate'], 0) ?>%</td>
            <td class="right"><?= number_format($item['total'], 2, ',', ' ') ?> €</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<table>
    <tr><td class="right">Subtotal:</td><td class="right"><?= number_format($document['subtotal'], 2, ',', ' ') ?> €</td></tr>
    <tr><td class="right">IVA:</td><td class="right"><?= number_format($document['vat_total'], 2, ',', ' ') ?> €</td></tr>
    <tr><th class="right">Total:</th><th class="right"><?= number_format($document['grand_total'], 2, ',', ' ') ?> €</th></tr>
</table>

<p><em><?= esc($document['notes'] ?? 'Documento emitido para correção ou acréscimo ao valor original.') ?></em></p>
</body>
</html>
