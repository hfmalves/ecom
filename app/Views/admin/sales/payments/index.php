<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title">Default Datatable</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formCustomer', 'md')"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Documento</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Método</th>
                                <th>Transação</th>
                                <th>Referência</th>
                                <th>Câmbio</th>
                                <th>Estado</th>
                                <th>Data Pagamento</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($payments)): ?>
                                <?php foreach ($payments as $p): ?>
                                    <?php $doc      = $p['invoice'] ?? []; // financial_document ligado ?>
                                    <?php $customer = $p['customer'] ?? []; ?>
                                    <tr>
                                        <td><?= esc($p['id']) ?></td>

                                        <!-- Documento (tipo + nº + série) -->
                                        <td>
                                            <strong><?= ucfirst($doc['type'] ?? '-') ?></strong><br>
                                            <?= esc($doc['invoice_number'] ?? 'N/A') ?>
                                            <small>(Série <?= esc($doc['series'] ?? '-') ?>)</small>
                                        </td>

                                        <!-- Cliente -->
                                        <td>
                                            <?= esc($customer['name'] ?? 'Sem cliente') ?><br>
                                            <small><?= esc($customer['email'] ?? '') ?></small>
                                        </td>

                                        <!-- Valor -->
                                        <td>
                                            <?= number_format($p['amount'] ?? 0, 2, ',', ' ') ?>
                                            <?= esc($p['currency'] ?? 'EUR') ?>
                                        </td>

                                        <!-- Método -->
                                        <td><?= esc($p['method'] ?? '-') ?></td>

                                        <!-- Transaction ID -->
                                        <td><?= esc($p['transaction_id'] ?? '-') ?></td>

                                        <!-- Referência -->
                                        <td><?= esc($p['reference'] ?? '-') ?></td>

                                        <!-- Câmbio -->
                                        <td><?= esc($p['exchange_rate'] ?? '1.0000') ?></td>

                                        <!-- Estado -->
                                        <td>
                                            <?php
                                            $statusLabels = [
                                                'pending'  => '<span class="badge bg-warning">Pendente</span>',
                                                'paid'     => '<span class="badge bg-success">Pago</span>',
                                                'failed'   => '<span class="badge bg-danger">Falhou</span>',
                                                'refunded' => '<span class="badge bg-info">Reembolsado</span>',
                                                'partial'  => '<span class="badge bg-secondary">Parcial</span>',
                                            ];
                                            echo $statusLabels[$p['status']] ?? '<span class="badge bg-light text-dark">N/A</span>';
                                            ?>
                                        </td>

                                        <!-- Data pagamento -->
                                        <td>
                                            <?= !empty($p['paid_at']) ? date('d/m/Y H:i', strtotime($p['paid_at'])) : '-' ?>
                                        </td>

                                        <!-- Ações -->
                                        <td>
                                            <a href="<?= base_url('admin/sales/payments/view/'.$p['id']) ?>"
                                               class="btn btn-sm btn-primary">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
