<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Detalhes da Transação<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-1">Detalhes da Transação</h4>
            <p class="text-muted mb-0">Consulta e atualiza as informações desta transação.</p>
        </div>
        <a href="<?= base_url('admin/sales/transactions') ?>" class="btn btn-light">
            <i class="mdi mdi-arrow-left me-1"></i> Voltar à Lista
        </a>
    </div>
</div>

<div class="row">
    <div class="col-8">
        <!-- === Informação do Pagamento === -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação do Pagamento</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Método</label>
                        <input type="text" class="form-control" value="<?= esc($payment['method'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valor</label>
                        <input type="text" class="form-control"
                               value="<?= number_format($payment['amount'] ?? 0, 2, ',', ' ') ?> <?= esc($payment['currency'] ?? 'EUR') ?>"
                               readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Transação</label>
                        <input type="text" class="form-control" value="<?= esc($payment['transaction_id'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Referência</label>
                        <input type="text" class="form-control" value="<?= esc($payment['reference'] ?? '-') ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado Atual</label><br>
                        <?php
                        $colors = [
                            'pending'  => 'warning',
                            'paid'     => 'success',
                            'failed'   => 'danger',
                            'refunded' => 'info',
                            'partial'  => 'secondary',
                        ];
                        $labels = [
                            'pending'  => 'Pendente',
                            'paid'     => 'Pago',
                            'failed'   => 'Falhou',
                            'refunded' => 'Reembolsado',
                            'partial'  => 'Parcial',
                        ];
                        ?>
                        <span class="badge bg-<?= $colors[$payment['status']] ?? 'light' ?> w-100">
                            <?= $labels[$payment['status']] ?? ucfirst($payment['status']) ?>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pago em</label>
                        <input type="text" class="form-control"
                               value="<?= !empty($payment['paid_at']) ? date('d/m/Y H:i', strtotime($payment['paid_at'])) : '-' ?>"
                               readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentários</label>
                    <textarea class="form-control" rows="3" readonly><?= esc($payment['comment'] ?? '-') ?></textarea>
                </div>
            </div>
        </div>
        <!-- === Encomenda Associada === -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Encomenda Associada</h4>

                <?php if (!empty($payment['order'])): ?>
                    <?php $order = $payment['order']; ?>

                    <!-- Dados principais -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted mb-0">Código</label>
                            <p class="fw-semibold mb-0">#<?= esc($order['id']) ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted mb-0">Data</label>
                            <p class="fw-semibold mb-0">
                                <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted mb-0">Total</label>
                            <p class="fw-semibold mb-0">
                                <?= number_format($order['grand_total'] ?? 0, 2, ',', ' ') ?> €
                            </p>
                        </div>
                    </div>

                    <!-- Métodos -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-0">Método de Envio</label>
                            <p class="fw-semibold mb-0">
                                <?= esc($order['shipping_method_name'] ?? '-') ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-0">Método de Pagamento</label>
                            <p class="fw-semibold mb-0">
                                <?= esc($order['payment_method_name'] ?? '-') ?>
                            </p>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-0">Estado da Encomenda</label><br>
                            <?php
                            $statusColors = [
                                'pending'    => 'warning',
                                'processing' => 'info',
                                'completed'  => 'success',
                                'canceled'   => 'danger',
                                'refunded'   => 'secondary',
                            ];
                            $statusLabels = [
                                'pending'    => 'Pendente',
                                'processing' => 'Em processamento',
                                'completed'  => 'Concluída',
                                'canceled'   => 'Cancelada',
                                'refunded'   => 'Reembolsada',
                            ];
                            ?>
                            <span class="badge bg-<?= $statusColors[$order['status']] ?? 'light' ?> w-100">
                        <?= $statusLabels[$order['status']] ?? ucfirst($order['status']) ?>
                    </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted mb-0">Itens Totais</label>
                            <p class="fw-semibold mb-0">
                                <?= esc($order['total_items'] ?? 0) ?>
                            </p>
                        </div>
                    </div>

                    <!-- Itens -->
                    <?php if (!empty($order['items'])): ?>
                        <h5 class="mb-3">Artigos da Encomenda</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Variante</th>
                                    <th class="text-end">Qtd</th>
                                    <th class="text-end">Preço Unit.</th>
                                    <th class="text-end">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($order['items'] as $i => $item): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($item['product_name']) ?></td>
                                        <td><?= esc($item['variant_name']) ?></td>
                                        <td class="text-end"><?= esc($item['qty']) ?></td>
                                        <td class="text-end"><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                                        <td class="text-end"><?= number_format($item['qty'] * $item['price'], 2, ',', ' ') ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                <tr>
                                    <th colspan="5" class="text-end">Subtotal</th>
                                    <th class="text-end"><?= number_format($order['grand_total'] - ($order['total_tax'] ?? 0), 2, ',', ' ') ?> €</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-end">Imposto</th>
                                    <th class="text-end"><?= number_format($order['total_tax'] ?? 0, 2, ',', ' ') ?> €</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-end">Total</th>
                                    <th class="text-end"><?= number_format($order['grand_total'] ?? 0, 2, ',', ' ') ?> €</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <p class="text-muted mb-0">Sem encomenda associada.</p>
                <?php endif; ?>
            </div>
        </div>


    </div>

    <!-- === Painel lateral: Editar === -->
    <div class="col-4">
        <div class="card border-0 shadow-sm h-100"
             x-data="{ editable: !['paid','refunded','failed'].includes('<?= strtolower($payment['status']) ?>') }">

            <div class="card-body">
                <h4 class="card-title mb-3">Atualizar Transação</h4>
                <p class="text-muted mb-3">Permite editar apenas método, referência e estado (caso ainda não esteja concluída).</p>

                <template x-if="editable">
                    <form
                        x-data="formHandler('<?= base_url('admin/sales/payments/update') ?>', {
                            id: '<?= $payment['id'] ?>',
                            method: '<?= esc($payment['method']) ?>',
                            reference: '<?= esc($payment['reference']) ?>',
                            status: '<?= esc($payment['status']) ?>',
                            comment: '<?= esc($payment['comment'] ?? '') ?>',
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                        })"
                        @submit.prevent="submit">

                        <div class="mb-3">
                            <label class="form-label">Método</label>
                            <select class="form-select" x-model="form.method">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($methods as $m): ?>
                                    <option value="<?= esc($m['name']) ?>"><?= esc($m['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Referência</label>
                            <input type="text" class="form-control" x-model="form.reference">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" x-model="form.status">
                                <option value="pending">Pendente</option>
                                <option value="paid">Pago</option>
                                <option value="partial">Parcial</option>
                                <option value="failed">Falhou</option>
                                <option value="refunded">Reembolsado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comentários</label>
                            <textarea class="form-control" x-model="form.comment"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                                <span x-show="!loading">Guardar Alterações</span>
                                <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                            </button>
                        </div>
                    </form>
                </template>

                <template x-if="!editable">
                    <div class="alert alert-secondary text-center py-3">
                        <i class="mdi mdi-lock-outline me-1"></i>
                        Esta transação já foi concluída e não pode ser editada.
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
