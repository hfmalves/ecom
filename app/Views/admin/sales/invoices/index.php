<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Documentos Fiscais<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- === KPIs === -->
<div class="row g-3 mb-1">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Documentos</h6>
                    <i class="mdi mdi-file-document-outline text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registados no sistema</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Pagos</h6>
                    <i class="mdi mdi-check-circle-outline text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['paid'] ?? 0 ?></h3>
                <small class="text-muted">documentos liquidados</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Cancelados</h6>
                    <i class="mdi mdi-close-circle-outline text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['canceled'] ?? 0 ?></h3>
                <small class="text-muted">anulados no sistema</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Últimos 30 dias</h6>
                    <i class="mdi mdi-calendar-month-outline text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['last_30_days'] ?? 0 ?></h3>
                <small class="text-muted">emitidos recentemente</small>
            </div>
        </div>
    </div>
</div>
<!-- === Tabela === -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Lista de Documentos Fiscais</h4>
            <button type="button" class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCreateInvoice">
                <i class="mdi mdi-plus me-1"></i> Novo Documento
            </button>
        </div>

        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap w-100 align-middle">
                <thead class="table-light">
                <tr>
                    <th>Fatura</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Desconto</th>
                    <th>Pago</th>
                    <th>Método</th>
                    <th>Data Pagamento</th>
                    <th>Série</th>
                    <th>Criada em</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($invoices)): ?>
                    <?php foreach ($invoices as $inv): ?>
                        <?php $cust = $inv['customer'] ?? []; $pay = $inv['payment'] ?? []; ?>
                        <tr>
                            <td><?= esc($inv['invoice_number'] ?? '-') ?><br><small>#<?= esc($inv['id']) ?></small></td>
                            <td><?= ucfirst($inv['type'] ?? '-') ?></td>
                            <td>
                                <?php
                                $colors = [
                                        'draft'    => 'secondary',
                                        'issued'   => 'info',
                                        'paid'     => 'success',
                                        'canceled' => 'danger',
                                        'refunded' => 'warning',
                                ];
                                $labels = [
                                        'draft'    => 'Rascunho',
                                        'issued'   => 'Emitida',
                                        'paid'     => 'Paga',
                                        'canceled' => 'Cancelada',
                                        'refunded' => 'Reembolsada',
                                ];
                                ?>
                                <span class="badge bg-<?= $colors[$inv['status']] ?? 'light' ?> w-100">
                                    <?= $labels[$inv['status']] ?? ucfirst($inv['status']) ?>
                                </span>
                            </td>
                            <td><?= esc($cust['name'] ?? '-') ?><br><small><?= esc($cust['email'] ?? '') ?></small></td>
                            <td><?= number_format($inv['total'] ?? 0, 2, ',', ' ') ?> €</td>
                            <td><?= number_format($inv['discount_total'] ?? 0, 2, ',', ' ') ?> €</td>
                            <td><?= number_format($pay['amount'] ?? 0, 2, ',', ' ') ?> €</td>
                            <td><?= esc($pay['method'] ?? '-') ?></td>
                            <td><?= !empty($pay['paid_at']) ? date('d/m/Y H:i', strtotime($pay['paid_at'])) : '-' ?></td>
                            <td><?= esc($inv['series'] ?? '-') ?></td>
                            <td><?= !empty($inv['created_at']) ? date('d/m/Y', strtotime($inv['created_at'])) : '-' ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/sales/financial_documents/edit/'.$inv['id']) ?>"
                                   class="btn btn-sm btn-light text-primary">
                                    <i class="mdi mdi-eye-outline"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal: Criar Novo Documento Fiscal -->
<div id="modalCreateInvoice" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"
             x-data="formHandler('<?= base_url('admin/sales/invoices/create') ?>', {
                 type: 'invoice',
                 series: '',
                 order_id: '',
                 notes: '',
                 <?= csrf_token() ?>: '<?= csrf_hash() ?>'
             })"
             @submit.prevent="submit">

            <div class="modal-header">
                <h5 class="modal-title">Criar Novo Documento Fiscal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info small">
                    Utilize este formulário para emitir um novo documento (Fatura, Recibo, Nota de Crédito, etc.).
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tipo</label>
                        <select class="form-select" x-model="form.type">
                            <option value="invoice">Fatura</option>
                            <option value="receipt">Recibo</option>
                            <option value="credit_note">Nota de Crédito</option>
                            <option value="debit_note">Nota de Débito</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Série</label>
                        <input type="text" class="form-control" placeholder="Ex: A" x-model="form.series">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Encomenda Associada</label>
                        <input type="number" class="form-control" placeholder="ID da encomenda" x-model="form.order_id">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notas / Observações</label>
                        <textarea class="form-control" rows="3" x-model="form.notes"
                                  placeholder="Informações adicionais..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" :disabled="loading">
                    <span x-show="!loading"><i class="mdi mdi-content-save-outline me-1"></i> Guardar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin me-1"></i> A guardar...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
