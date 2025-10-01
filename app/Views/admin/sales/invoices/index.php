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
                            <?php if (!empty($payments)): ?>
                                <?php foreach ($payments as $p): ?>
                                    <?php $invoice = $p['invoice'] ?? []; ?>
                                    <?php $order   = $p['order'] ?? []; ?>
                                    <?php $customer= $p['customer'] ?? []; ?>
                                    <tr>
                                        <!-- Nº Fatura -->
                                        <td>
                                            <?= esc($invoice['invoice_number'] ?? 'N/A') ?><br>
                                            <small>#<?= esc($invoice['id'] ?? '-') ?></small>
                                        </td>

                                        <!-- Tipo -->
                                        <td>
                                            <?php
                                            $typeLabels = [
                                                'invoice'     => 'Fatura',
                                                'receipt'     => 'Recibo',
                                                'credit_note' => 'Nota de Crédito',
                                                'debit_note'  => 'Nota de Débito'
                                            ];
                                            echo $typeLabels[$invoice['type']] ?? ($invoice['type'] ?? 'N/A');
                                            ?>
                                        </td>

                                        <!-- Estado -->
                                        <td>
                                            <?php
                                            $statusLabels = [
                                                'draft'     => 'Rascunho',
                                                'issued'    => 'Emitida',
                                                'paid'      => 'Paga',
                                                'canceled'  => 'Cancelada',
                                                'refunded'  => 'Reembolsada'
                                            ];
                                            echo $statusLabels[$invoice['status']] ?? ($invoice['status'] ?? 'N/A');
                                            ?>
                                        </td>

                                        <!-- Cliente -->
                                        <td>
                                            <?= esc($customer['name'] ?? 'Sem cliente') ?><br>
                                            <small><?= esc($customer['email'] ?? '') ?></small>
                                        </td>

                                        <!-- Totais -->
                                        <td><?= number_format($invoice['total'] ?? 0, 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($invoice['discount_total'] ?? 0, 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($p['amount'] ?? 0, 2, ',', ' ') ?> €</td>

                                        <!-- Método -->
                                        <td><?= esc($p['method'] ?? '-') ?></td>

                                        <!-- Data de pagamento -->
                                        <td><?= !empty($p['paid_at']) ? date('d/m/Y H:i', strtotime($p['paid_at'])) : '-' ?></td>

                                        <!-- Série -->
                                        <td><?= esc($invoice['series'] ?? '-') ?></td>

                                        <!-- Data criação -->
                                        <td><?= !empty($invoice['created_at']) ? date('d/m/Y', strtotime($invoice['created_at'])) : '-' ?></td>

                                        <!-- Ações -->
                                        <td>
                                            <a href="<?= base_url('admin/sales/invoices/view/'.($invoice['id'] ?? 0)) ?>"
                                               class="btn btn-sm btn-primary w-100">Ver Fatura</a>
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
