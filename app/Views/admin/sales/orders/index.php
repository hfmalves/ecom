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
                                    <th>Cliente</th>
                                    <th>Morada Env.</th>
                                    <th>Morada Fac.</th>
                                    <th>Status</th>
                                    <th>Artigos</th>
                                    <th>Total</th>
                                    <th>Desconto</th>
                                    <th>Imposto</th>
                                    <th>Método de Pagamento</th>
                                    <th>Método de Envio</th>
                                    <th>Criada em</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $o): ?>
                                    <tr>
                                        <td><?= esc($o['user']['name'] ?? 'Sem cliente') ?></td>
                                        <td>
                                            <?= esc($o['billing_address']['city'] ?? '-') ?><br>
                                            <?= esc($o['billing_address']['postcode'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <?= esc($o['shipping_address']['city'] ?? '-') ?><br>
                                            <?= esc($o['shipping_address']['postcode'] ?? '-') ?>
                                        </td>
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
                                        <td><?= esc($o['total_items']) ?></td>
                                        <td><?= number_format($o['grand_total'], 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($o['total_discount'], 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($o['total_tax'], 2, ',', ' ') ?> €</td>
                                        <td><?= esc($o['payment_method']['name'] ?? '-') ?></td>
                                        <td><?= esc($o['shipping_method']['name'] ?? '-') ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/sales/orders/view/'.$o['id']) ?>" class="btn btn-sm btn-primary">Ver</a>
                                            <a href="<?= base_url('admin/sales/orders/edit/'.$o['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
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
