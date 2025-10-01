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
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Status</th>
                                <th>Cliente</th>
                                <th>Morada</th>
                                <th>Pais</th>
                                <th>Artigos</th>
                                <th>Total</th>
                                <th>Desconto</th>
                                <th>Terminal </th>
                                <th>Envio</th>
                                <th>Criada em</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $o): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $statusLabels = [
                                                'pending'    => 'Pendente',
                                                'processing' => 'Em processamento',
                                                'completed'  => 'Concluída',
                                                'canceled'   => 'Cancelada',
                                                'refunded'   => 'Reembolsada'
                                            ];
                                            echo $statusLabels[$o['status']] ?? $o['status'];
                                            ?>
                                        </td>
                                        <td>
                                            <?= esc($o['user']['name'] ?? 'Sem cliente') ?><br>
                                            <?= esc($o['user']['email'] ?? 'Sem cliente') ?>
                                        </td>
                                        <td>
                                            <?= esc($o['billing_address']['street'] ?? '-') ?>
                                            <br   <?= esc($o['billing_address']['postcode'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <?= esc($o['billing_address']['country'] ?? '-') ?>
                                            <?= esc($o['billing_address']['city'] ?? '-') ?>
                                        </td>
                                        <td><?= esc($o['total_items']) ?></td>
                                        <td><?= number_format($o['grand_total'], 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($o['total_discount'], 2, ',', ' ') ?> €</td>
                                        <td><?= esc($o['payment_method']['name'] ?? '-') ?></td>
                                        <td>
                                            <?= esc($o['shipping_method']['name'] ?? '-') ?><br>
                                            <?php if (!empty($o['shipments'])): ?>
                                                <?php foreach ($o['shipments'] as $s): ?>
                                                    <?= esc($s['tracking_number'] ?? '-') ?><br>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                -
                                            <?php endif ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/sales/orders/edit/'.$o['id']) ?>" class="btn btn-sm btn-primary w-100">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
