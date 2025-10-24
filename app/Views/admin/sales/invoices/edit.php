<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Documento Fiscal<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Detalhes do Documento Fiscal</h4>
                <?php if (!empty($invoice)): ?>
                    <?php
                    // Traduções de estados
                    $statusLabels = [
                            'draft'     => ['label' => 'Rascunho',   'color' => 'secondary'],
                            'issued'    => ['label' => 'Emitida',    'color' => 'info'],
                            'paid'      => ['label' => 'Paga',       'color' => 'success'],
                            'canceled'  => ['label' => 'Cancelada',  'color' => 'danger'],
                            'refunded'  => ['label' => 'Reembolsada','color' => 'warning'],
                            'pending'   => ['label' => 'Pendente',   'color' => 'secondary'],
                    ];
                    $invStatus = strtolower($invoice['status'] ?? 'draft');
                    $invStatusData = $statusLabels[$invStatus] ?? ['label' => ucfirst($invStatus), 'color' => 'light'];
                    ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Número</label>
                            <input type="text" class="form-control" value="<?= esc($invoice['invoice_number']) ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Série</label>
                            <input type="text" class="form-control" value="<?= esc($invoice['series'] ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo</label>
                            <input type="text" class="form-control" value="<?= ucfirst($invoice['type'] ?? '-') ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado</label><br>
                            <span class="badge bg-<?= $invStatusData['color'] ?> w-100">
                            <?= $invStatusData['label'] ?>
                        </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Criado em</label>
                            <input type="text" class="form-control"
                                   value="<?= date('d/m/Y H:i', strtotime($invoice['created_at'])) ?>" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control"
                                   value="<?= number_format($invoice['subtotal'], 2, ',', ' ') ?> €" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">IVA</label>
                            <input type="text" class="form-control"
                                   value="<?= number_format($invoice['tax_total'], 2, ',', ' ') ?> €" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total</label>
                            <input type="text" class="form-control"
                                   value="<?= number_format($invoice['total'], 2, ',', ' ') ?> €" readonly>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Documento não encontrado.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Encomenda Associada -->
        <?php if (!empty($invoice['order'])): ?>
            <?php
            $order = $invoice['order'];
            $ordStatus = strtolower($order['status'] ?? 'pending');
            $ordStatusData = $statusLabels[$ordStatus] ?? ['label' => ucfirst($ordStatus), 'color' => 'light'];
            ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Encomenda Associada</h4>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Código</label>
                            <input type="text" class="form-control" value="#<?= esc($order['id']) ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label><br>
                            <span class="badge bg-<?= $ordStatusData['color'] ?> w-100">
                            <?= $ordStatusData['label'] ?>
                        </span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total Encomenda</label>
                            <input type="text" class="form-control"
                                   value="<?= number_format($order['grand_total'], 2, ',', ' ') ?> €" readonly>
                        </div>
                    </div>

                    <?php if (!empty($order['items'])): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>SKU</th>
                                    <th class="text-center">Qtd</th>
                                    <th class="text-end">Preço</th>
                                    <th class="text-end">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($order['items'] as $i => $item): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($item['product_name']) ?></td>
                                        <td><?= esc($item['sku']) ?></td>
                                        <td class="text-center"><?= esc($item['qty']) ?></td>
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
    <!-- Painel lateral -->
    <div class="col-lg-4">
        <!-- Cliente -->
        <?php if (!empty($invoice['customer'])): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Cliente</h5>
                    <div class="mb-2">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" value="<?= esc($invoice['customer']['name']) ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="<?= esc($invoice['customer']['email']) ?>" readonly>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Pagamento -->
        <?php if (!empty($invoice['payment'])): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pagamento</h5>
                    <div class="mb-2">
                        <label class="form-label">Método</label>
                        <input type="text" class="form-control" value="<?= esc($invoice['payment']['method']) ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Valor Pago</label>
                        <input type="text" class="form-control" value="<?= number_format($invoice['payment']['amount'], 2, ',', ' ') ?> €" readonly>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Atualizar estado -->
            <div class="card border-0 shadow-sm h-100"
                 x-data="{ editable: '<?= strtolower($invoice['status']) ?>' !== 'canceled' }">
                <div class="card-body">
                    <h4 class="card-title mb-3">Atualizar Estado</h4>
                    <p class="text-muted mb-3">
                        Pode alterar o estado apenas enquanto o documento não estiver concluído ou cancelado.
                    </p>

                    <!-- Form editável -->
                    <template x-if="editable">
                        <form
                                x-data="formHandler('<?= base_url('admin/sales/invoices/updateStatus') ?>', {
                        id: '<?= $invoice['id'] ?>',
                        status: '<?= esc($invoice['status']) ?>',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    })"
                                @submit.prevent="submit">

                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" x-model="form.status">
                                    <option value="draft">Rascunho</option>
                                    <option value="issued">Emitida</option>
                                    <option value="paid">Paga</option>
                                    <option value="canceled">Cancelada</option>
                                    <option value="refunded">Reembolsada</option>
                                </select>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                                    <span x-show="!loading"><i class="mdi mdi-check me-1"></i> Guardar Alterações</span>
                                    <span x-show="loading"><i class="fa fa-spinner fa-spin me-1"></i> A atualizar...</span>
                                </button>
                            </div>
                        </form>
                    </template>

                    <!-- Caso não seja editável -->
                    <template x-if="!editable">
                        <div class="alert alert-secondary text-center py-3">
                            <i class="mdi mdi-lock-outline me-1"></i>
                            Este documento já se encontra concluído e não pode ser alterado.
                        </div>
                    </template>
                </div>
            </div>

    </div>
</div>

<?= $this->endSection() ?>

