<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Cart Rules<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="card-title">Cart Price Rules</h4>
                    </div>
                    <div class="col-sm-8 text-sm-end">
                        <button type="button" x-data="systemModal()"
                                @click="open('#formCartRule', 'lg')"
                                class="btn btn-primary">
                            <i class="fa-solid fa-plus me-1"></i> Nova Regra
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Datas</th>
                            <th>Status</th>
                            <th>Categorias</th>
                            <th>Produtos</th>
                            <th>Grupos</th>
                            <th>Cupões</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($rules)): ?>
                            <?php foreach ($rules as $rule): ?>
                                <tr>
                                    <td><?= esc($rule['id']) ?></td>
                                    <td><?= esc($rule['name']) ?></td>
                                    <td><?= esc($rule['discount_type']) ?></td>
                                    <td><?= esc($rule['discount_value']) ?></td>
                                    <td>
                                        <?= esc($rule['start_date']) ?><br>
                                        <?= esc($rule['end_date']) ?>
                                    </td>
                                    <td><?= $rule['status'] ? 'Ativo' : 'Inativo' ?></td>

                                    <td>
                                        <?php foreach ($rule['categories'] as $cat): ?>
                                            <span class="badge bg-primary">Cat: <?= $cat['category_id'] ?></span><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($rule['products'] as $prod): ?>
                                            <span class="badge bg-success">Prod: <?= $prod['product_id'] ?></span><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($rule['groups'] as $grp): ?>
                                            <span class="badge bg-info">Group: <?= $grp['customer_group_id'] ?></span><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($rule['coupons'] as $coup): ?>
                                            <span class="badge bg-warning"><?= esc($coup['code']) ?></span><br>
                                        <?php endforeach; ?>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= site_url('admin/marketing/cart-rules/edit/'.$rule['id']) ?>"
                                               class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="<?= site_url('admin/marketing/cart-rules/delete/'.$rule['id']) ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Eliminar esta regra?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="11" class="text-center">Nenhuma regra encontrada.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
