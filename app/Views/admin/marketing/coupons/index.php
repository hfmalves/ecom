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
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Usos</th>
                                <th>Limite Global</th>
                                <th>Limite por Cliente</th>
                                <th>Produtos</th>
                                <th>Categorias</th>
                                <th>Grupos</th>
                                <th>Dias Restantes</th>
                                <th>Estado</th>
                                <th>Criado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($coupons as $c): ?>
                                <tr>
                                    <td><strong><?= esc($c['code']) ?></strong></td>
                                    <td><?= esc($c['type']) ?></td>
                                    <td><?= esc($c['value']) ?></td>
                                    <td><?= esc($c['usages']) ?></td>
                                    <td><?= $c['max_uses'] ?: '∞' ?></td>
                                    <td><?= $c['max_uses_per_customer'] ?: '∞' ?></td>
                                    <td>
                                        <?php foreach ($c['products'] as $p): ?>
                                            <span class="badge bg-info"><?= esc($p['product_id']) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($c['categories'] as $cat): ?>
                                            <span class="badge bg-secondary"><?= esc($cat['category_id']) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($c['groups'] as $g): ?>
                                            <span class="badge bg-dark"><?= esc($g['customer_group_id']) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php if ($c['days_left'] === null): ?>
                                            <span class="badge bg-info">Sem expiração</span>
                                        <?php elseif ($c['days_left'] == 0): ?>
                                            <span class="badge bg-danger">Expirado</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning"><?= $c['days_left'] ?> dias</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $c['status_class'] ?>"><?= $c['status_label'] ?></span>
                                    </td>
                                    <td><?= esc($c['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
