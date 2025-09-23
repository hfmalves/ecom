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
                                                <button type="button"
                                                        class="btn btn-sm btn-warning"
                                                        x-data
                                                        @click="
          open('#formCategory', 'md');
          $dispatch('fill-form', {
              id: '<?= $category['id'] ?>',
              name: '<?= esc($category['name']) ?>',
              slug: '<?= esc($category['slug']) ?>',
              position: '<?= esc($category['position']) ?>',
              is_active: '<?= $category['is_active'] ?>'
          })
        ">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <button type="button"
                                                        class="btn btn-sm btn-danger"
                                                        x-data
                                                        @click="
          open('#deleteCategory', 'sm');
          $dispatch('fill-form', {
              id: '<?= $category['id'] ?>',
              name: '<?= esc($category['name']) ?>'
          })
        ">
                                                    <i class="bi bi-trash"></i>
                                                </button>

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
<div id="formCategory" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/categories/update', {
                    id: '',
                    name: '',
                    slug: '',
                    position: '',
                    is_active: 1,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                })
             }"
             x-init="
                $el.addEventListener('fill-form', e => {
                    Object.entries(e.detail).forEach(([k,v]) => { if (k in form) form[k] = v })
                });
                document.addEventListener('csrf-update', e => {
                    form[e.detail.token] = e.detail.hash
                });
             ">

            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" x-model="form.slug">
                    <div class="text-danger small" x-text="errors.slug"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Posição</label>
                    <input type="number" class="form-control" x-model="form.position">
                    <div class="text-danger small" x-text="errors.position"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ativo</label>
                    <select class="form-select" x-model="form.is_active">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar Alterações</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteCategory" class="d-none">
    <div class="modal-content"
         x-data="{
            ...formHandler('/admin/catalog/categories/delete', {
                id: '',
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            })
         }"
         x-init="
            $el.addEventListener('fill-form', e => {
                form.id = e.detail.id
                form.name = e.detail.name
            });
         ">

        <div class="modal-header">
            <h5 class="modal-title">Remover Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <p>Tem certeza que deseja remover a categoria <strong x-text="form.name"></strong>?</p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" @click="submit()" :disabled="loading">
                <span x-show="!loading">Remover</span>
                <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A remover...</span>
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
