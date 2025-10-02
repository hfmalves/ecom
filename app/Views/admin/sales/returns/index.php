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
                                <h4 class="card-title">Lista de Envios</h4>
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
                        <table id="datatable" class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>RMA</th>
                                <th>Encomenda</th>
                                <th>Cliente</th>
                                <th>Qtd. Devolvida</th>
                                <th>Reembolso (€)</th>
                                <th>Motivo</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($returns)): ?>
                                <?php foreach ($returns as $r): ?>
                                    <?php
                                    $totalQty = 0;
                                    $totalRefund = 0;
                                    if (!empty($r['items'])) {
                                        foreach ($r['items'] as $item) {
                                            $totalQty += $item['qty_returned'] ?? 0;
                                            $totalRefund += $item['refund_amount'] ?? 0;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <!-- RMA -->
                                        <td>
                                            <a href="<?= base_url('admin/sales/returns/view/'.$r['id']) ?>">
                                                <strong><?= esc($r['rma_number'] ?? 'RMA-'.$r['id']) ?></strong>
                                            </a>
                                        </td>

                                        <!-- Encomenda -->
                                        <td>
                                            #<?= esc($r['order']['id'] ?? '-') ?><br>
                                            <small class="text-muted">
                                                Total: <?= number_format($r['order']['grand_total'] ?? 0, 2, ',', ' ') ?> €
                                            </small>
                                        </td>

                                        <!-- Cliente -->
                                        <td>
                                            <?= esc($r['customer']['name'] ?? 'Sem cliente') ?><br>
                                            <small class="text-muted"><?= esc($r['customer']['email'] ?? '') ?></small>
                                        </td>

                                        <!-- Quantidade devolvida -->
                                        <td><?= $totalQty ?></td>

                                        <!-- Valor estimado -->
                                        <td><?= number_format($totalRefund, 2, ',', ' ') ?> €</td>

                                        <!-- Motivo -->
                                        <td><?= esc($r['reason'] ?? '-') ?></td>

                                        <!-- Status -->
                                        <td>
                                            <?php
                                            $labels = [
                                                'requested' => '<span class="badge bg-warning">Pedido</span>',
                                                'approved'  => '<span class="badge bg-success">Aprovado</span>',
                                                'rejected'  => '<span class="badge bg-danger">Rejeitado</span>',
                                                'refunded'  => '<span class="badge bg-info">Reembolsado</span>',
                                                'completed' => '<span class="badge bg-primary">Concluído</span>',
                                            ];
                                            echo $labels[$r['status']] ?? $r['status'];
                                            ?>
                                        </td>

                                        <!-- Data -->
                                        <td><?= !empty($r['created_at']) ? date('d/m/Y H:i', strtotime($r['created_at'])) : '-' ?></td>

                                        <!-- Ações -->
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/sales/returns/view/'.$r['id']) ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Ver
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
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
