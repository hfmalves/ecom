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
                                <th>Itens</th>
                                <th>Total</th>
                                <th>Encomenda</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($carts)): ?>
                                <?php foreach ($carts as $c): ?>
                                    <tr>
                                        <!-- Status -->
                                        <td>
                                            <?php
                                            $statusLabels = [
                                                'active'    => '<span class="badge bg-warning">Ativo</span>',
                                                'abandoned' => '<span class="badge bg-danger">Abandonado</span>',
                                                'converted' => '<span class="badge bg-success">Convertido</span>',
                                            ];
                                            echo $statusLabels[$c['status']] ?? $c['status'];
                                            ?>
                                        </td>

                                        <!-- Cliente -->
                                        <td>
                                            <?php if (!empty($c['customer'])): ?>
                                                <?= esc($c['customer']['name']) ?><br>
                                                <small><?= esc($c['customer']['email']) ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">Guest</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Totais -->
                                        <td><?= esc($c['total_items'] ?? 0) ?></td>
                                        <td><?= number_format($c['total_value'] ?? 0, 2, ',', ' ') ?> €</td>

                                        <!-- Encomenda ligada -->
                                        <td>
                                            <?php if (!empty($c['converted_order_id'])): ?>
                                                <a href="<?= base_url('admin/sales/orders/edit/'.$c['converted_order_id']) ?>">
                                                    #<?= esc($c['converted_order_id']) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Data -->
                                        <td><?= !empty($c['created_at']) ? date('d/m/Y H:i', strtotime($c['created_at'])) : '-' ?></td>

                                        <!-- Ações -->
                                        <td>
                                            <a href="<?= base_url('admin/sales/cart/view/'.$c['id']) ?>"
                                               class="btn btn-sm btn-primary w-100">Ver</a>
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
