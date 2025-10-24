<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Documento Fiscal<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Documento -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Detalhes do Documento Fiscal</h4>

                <?php if (!empty($invoice)): ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted">Número</label>
                            <p class="fw-semibold mb-0"><?= esc($invoice['invoice_number']) ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Série</label>
                            <p class="fw-semibold mb-0"><?= esc($invoice['series'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Tipo</label>
                            <p class="fw-semibold mb-0"><?= ucfirst($invoice['type'] ?? '-') ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Estado</label>
                            <span class="badge bg-<?= $invoice['status'] === 'paid' ? 'success' : 'secondary' ?> w-100">
                                <?= ucfirst($invoice['status']) ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Criado em</label>
                            <p class="fw-semibold mb-0"><?= date('d/m/Y H:i', strtotime($invoice['created_at'])) ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted">Subtotal</label>
                            <p class="fw-semibold mb-0"><?= number_format($invoice['subtotal'], 2, ',', ' ') ?> €</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">IVA</label>
                            <p class="fw-semibold mb-0"><?= number_format($invoice['tax_total'], 2, ',', ' ') ?> €</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Total</label>
                            <p class="fw-semibold mb-0"><?= number_format($invoice['total'], 2, ',', ' ') ?> €</p>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Documento não encontrado.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Encomenda Associada -->
        <?php if (!empty($invoice['order'])): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-3">Encomenda Associada</h4>
                    <?php $order = $invoice['order']; ?>
                    <p><strong>Código:</strong> #<?= esc($order['id']) ?></p>
                    <p><strong>Total:</strong> <?= number_format($order['grand_total'], 2, ',', ' ') ?> €</p>
                    <p><strong>Estado:</strong>
                        <span class="badge bg-primary"><?= ucfirst($order['status']) ?></span>
                    </p>

                    <?php if (!empty($order['items'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Variante</th>
                                    <th>Qtd</th>
                                    <th class="text-end">Preço</th>
                                    <th class="text-end">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($order['items'] as $i => $item): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($item['product_name']) ?></td>
                                        <td><?= esc($item['variant_name']) ?></td>
                                        <td><?= esc($item['qty']) ?></td>
                                        <td class="text-end"><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                                        <td class="text-end"><?= number_format($item['qty'] * $item['price'], 2, ',', ' ') ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Coluna lateral -->
    <div class="col-lg-4">
        <?php if (!empty($invoice['customer'])): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Cliente</h5>
                    <p class="fw-semibold mb-0"><?= esc($invoice['customer']['name']) ?></p>
                    <small class="text-muted"><?= esc($invoice['customer']['email']) ?></small>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($invoice['payment'])): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pagamento</h5>
                    <p><strong>Método:</strong> <?= esc($invoice['payment']['method']) ?></p>
                    <p><strong>Valor Pago:</strong> <?= number_format($invoice['payment']['amount'], 2, ',', ' ') ?> €</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
