<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Transações<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row mb-1">
    <!-- KPIs -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted mb-0">Total de Transações</h6>
                    <i class="mdi mdi-cash-multiple text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= esc($kpi['total']) ?></h3>
                <small class="text-muted">registadas no sistema</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted mb-0">Pagas</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= esc($kpi['paid']) ?></h3>
                <small class="text-muted">transações concluídas</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted mb-0">Falhadas</h6>
                    <i class="mdi mdi-alert-octagram text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= esc($kpi['failed']) ?></h3>
                <small class="text-muted">não processadas com sucesso</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted mb-0">Valor Médio</h6>
                    <i class="mdi mdi-finance text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= esc($kpi['avg_value']) ?> €</h3>
                <small class="text-muted">por transação</small>
            </div>
        </div>
    </div>
</div>
<!-- === LISTA DE TRANSAÇÕES === -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Lista de Transações</h4>
            <button type="button" class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#modalCreatePayment">
                <i class="mdi mdi-plus me-1"></i> Nova Transação
            </button>
        </div>
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap w-100 align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th class="text-end">Valor</th>
                    <th>Método</th>
                    <th>Transação</th>
                    <th>Referência</th>
                    <th class="text-center">Câmbio</th>
                    <th>Estado</th>
                    <th>Pago em</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($payments)): ?>
                    <?php foreach ($payments as $p): ?>
                        <?php $customer = $p['customer'] ?? []; ?>
                        <tr>
                            <td><?= esc($p['id']) ?></td>

                            <!-- Cliente -->
                            <td>
                                <?= esc($customer['name'] ?? '—') ?><br>
                                <small class="text-muted"><?= esc($customer['email'] ?? '') ?></small>
                            </td>

                            <!-- Valor -->
                            <td class="text-end">
                                <?= number_format($p['amount'] ?? 0, 2, ',', ' ') ?>
                                <?= esc($p['currency'] ?? 'EUR') ?>
                            </td>

                            <!-- Método -->
                            <td><?= esc($p['method'] ?? '-') ?></td>

                            <!-- Transação -->
                            <td><?= esc($p['transaction_id'] ?? '-') ?></td>

                            <!-- Referência -->
                            <td><?= esc($p['reference'] ?? '-') ?></td>

                            <!-- Câmbio -->
                            <td class="text-center"><?= esc($p['exchange_rate'] ?? '1.0000') ?></td>

                            <!-- Estado -->
                            <td>
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
                                <span class="badge bg-<?= $colors[$p['status']] ?? 'light' ?> w-100">
                                    <?= esc($labels[$p['status']] ?? ucfirst($p['status'])) ?>
                                </span>
                            </td>

                            <!-- Pago em -->
                            <td><?= !empty($p['paid_at']) ? date('d/m/Y H:i', strtotime($p['paid_at'])) : '-' ?></td>

                            <!-- Ações -->
                            <td class="text-center">
                                <a href="<?= base_url('admin/sales/transactions/edit/'.$p['id']) ?>"
                                   class="btn btn-sm btn-light text-primary" title="Ver detalhes">
                                    <i class="mdi mdi-eye-outline"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="modalCreatePayment" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"
             x-data="formHandler('<?= base_url('admin/sales/payments/create') ?>', {
                 order_id: '',
                 amount: '',
                 method: '',
                 reference: '',
                 currency: 'EUR',
                 status: 'paid',
                 comment: '',
                 <?= csrf_token() ?>: '<?= csrf_hash() ?>'
             })">

            <div class="modal-header">
                <h5 class="modal-title">Nova Transação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Encomenda</label>
                            <input type="number" class="form-control" x-model="form.order_id"
                                   placeholder="ID da encomenda">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Valor (€)</label>
                            <input type="number" step="0.01" class="form-control" x-model="form.amount">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Método</label>
                            <select class="form-select" x-model="form.method">
                                <option value="">-- Selecionar --</option>
                                <option>Multibanco</option>
                                <option>MBWay</option>
                                <option>Visa</option>
                                <option>Transferência</option>
                                <option>Loja</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Referência</label>
                            <input type="text" class="form-control" x-model="form.reference"
                                   placeholder="Referência ou código da operação">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Moeda</label>
                            <input type="text" class="form-control" x-model="form.currency" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" x-model="form.status">
                                <option value="paid">Pago</option>
                                <option value="pending">Pendente</option>
                                <option value="failed">Falhou</option>
                                <option value="refunded">Reembolsado</option>
                                <option value="partial">Parcial</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comentário</label>
                        <textarea class="form-control" x-model="form.comment"
                                  placeholder="Notas internas (opcional)"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" :disabled="loading">
                        <span x-show="!loading">Guardar Transação</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
