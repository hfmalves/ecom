<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title">Lista de Categorias</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 offset-sm-6">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formCategory', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive"
                         x-data="{
        open: {},
        toggle(id) {
            this.open[id] = !this.open[id];
        }
     }">

                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">Estado</th>
                                <th>Nome</th>
                                <th>Slug</th>
                                <th style="width: 100px;">Produtos</th>
                                <th style="width: 120px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody x-data="{ open: {} }">
                            <?php
                            function renderCategoryRows($categories, $level = 0, $parentId = null)
                            {
                                foreach ($categories as $category): ?>
                                    <tr
                                            x-show="<?= $parentId ? "open[$parentId]" : 'true' ?>"
                                            x-cloak>
                                        <td>
                                            <?= $category['is_active']
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-secondary w-100">Inativo</span>' ?>
                                        </td>

                                        <td>
                                            <?php if (!empty($category['children'])): ?>
                                                <button class="btn btn-sm btn-light me-1"
                                                        @click="open[<?= $category['id'] ?>] = !open[<?= $category['id'] ?>]">
                                                    <i :class="open[<?= $category['id'] ?>] ? 'mdi mdi-chevron-down' : 'mdi mdi-chevron-right'"></i>
                                                </button>
                                            <?php else: ?>
                                                <span class="ms-4"></span>
                                            <?php endif; ?>

                                            <span style="padding-left: <?= $level * 20 ?>px">
                    <?= esc($category['name']) ?>
                </span>
                                        </td>

                                        <td><?= esc($category['slug']) ?></td>
                                        <td><span class="badge bg-dark"><?= esc($category['products_count'] ?? 0) ?></span></td>
                                        <td>
                                            <a href="<?= base_url('admin/catalog/categories/edit/' . $category['id']) ?>"
                                               class="btn btn-sm btn-primary w-100">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <?php
                                    if (!empty($category['children'])) {
                                        renderCategoryRows($category['children'], $level + 1, $category['id']);
                                    }
                                endforeach;
                            }
                            renderCategoryRows($tree);
                            ?>
                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formCategory" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
            ...formHandler('/admin/catalog/categories/store',
              {
                id: '',
                name: '',
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
              },
              { resetOnSuccess: true })
         }"
             x-init="
            $el.addEventListener('fill-form', e => {
              Object.entries(e.detail).forEach(([k,v]) => { if (k in form) form[k] = v })
            });
            $el.addEventListener('reset-form', () => {
              Object.keys(form).forEach(k => {
                if (k !== '<?= csrf_token() ?>') {
                  form[k] = ''
                }
              })
            });
            document.addEventListener('csrf-update', e => {
              form[e.detail.token] = e.detail.hash
            });
         ">

            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>
                <div class="modal-footer mt-3">
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
