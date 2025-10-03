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
                            <thead>
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
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (! empty($rules)): ?>
                                <?php foreach ($rules as $rule): ?>
                                    <tr>
                                        <td><?= esc($rule['id']) ?></td>
                                        <td><?= esc($rule['name']) ?></td>
                                        <td><?= esc($rule['discount_type']) ?></td>
                                        <td><?= esc($rule['discount_value']) ?></td>
                                        <td>
                                            <?= esc($rule['start_date']) ?> <br>
                                            <?= esc($rule['end_date']) ?>
                                        </td>
                                        <td><?= $rule['status'] ? 'Ativo' : 'Inativo' ?></td>
                                        <td>
                                            <?php foreach ($rule['categories'] as $cat): ?>
                                                <span class="badge bg-primary">Cat ID: <?= esc($cat['category_id']) ?></span><br>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php foreach ($rule['products'] as $prod): ?>
                                                <span class="badge bg-success">Prod ID: <?= esc($prod['product_id']) ?></span><br>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php foreach ($rule['groups'] as $grp): ?>
                                                <span class="badge bg-info">Group ID: <?= esc($grp['customer_group_id']) ?></span><br>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('admin/marketing/catalog-rules/edit/' . $rule['id']) ?>"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fa-solid fa-pen"></i> Editar
                                                </a>
                                                <a href="<?= site_url('admin/marketing/catalog-rules/delete/' . $rule['id']) ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Tem a certeza que deseja eliminar esta regra?')">
                                                    <i class="fa-solid fa-trash"></i> Apagar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="9" class="text-center">Nenhuma regra encontrada.</td></tr>
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
