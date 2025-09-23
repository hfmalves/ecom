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
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Slug</th>
                                    <th>Ativo</th>
                                    <th>Posição</th>
                                    <th>Atualizado em</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?= esc($category['id']) ?></td>
                                            <td><?= esc($category['name']) ?></td>
                                            <td><?= esc($category['slug']) ?></td>
                                            <td>
                                                <?php if ($category['is_active']): ?>
                                                    <span class="badge bg-success">Ativo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inativo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($category['position']) ?></td>
                                            <td><?= esc($category['updated_at']) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/catalog/categories/edit/'.$category['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                                                <a href="<?= base_url('admin/catalog/categories/delete/'.$category['id']) ?>" class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Tem certeza que deseja remover?')">Remover</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Nenhuma categoria encontrada</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<?= $this->endSection() ?>
