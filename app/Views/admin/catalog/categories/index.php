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
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Slug</th>
                                    <th>Posição</th>
                                    <th>Ativo</th>
                                    <th>Produtos</th>
                                    <th>Atualizado em</th>
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                function renderCategories($categories)
                                {
                                    foreach ($categories as $category): ?>
                                        <tr>
                                            <td><input type="checkbox" name="selected[]" value="<?= $category['id'] ?>"></td>
                                            <td><?= esc($category['id']) ?></td>
                                            <td>
                                                <?= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['level']) ?>
                                                <?php if ($category['level'] > 0): ?>
                                                    ↳
                                                <?php endif; ?>
                                                <?= esc($category['name']) ?>
                                            </td>
                                            <td><?= esc($category['slug']) ?></td>
                                            <td><?= esc($category['position']) ?></td>
                                            <td>
                                                <?= $category['is_active']
                                                        ? '<span class="badge bg-success">Ativo</span>'
                                                        : '<span class="badge bg-secondary">Inativo</span>' ?>
                                            </td>
                                            <td><span class="badge bg-dark"><?= esc($category['products_count'] ?? 0) ?></span></td>
                                            <td><?= esc($category['updated_at']) ?></td>

                                            <td>
                                                <!-- Botão Editar -->
                                                <a href="<?= base_url('admin/catalog/categories/edit/' . $category['id']) ?>"
                                                   class="btn btn-sm btn-primary w-100">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <?php if (!empty($category['children'])): ?>
                                            <?php renderCategories($category['children']); ?>
                                        <?php endif; ?>
                                    <?php endforeach;
                                }
                                ?>

                                <?php if (!empty($categories)): ?>
                                    <?php renderCategories($categories); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Nenhuma categoria encontrada</td>
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
