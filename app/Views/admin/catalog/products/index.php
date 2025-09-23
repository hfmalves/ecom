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
                                    @click="open('#formProduct', 'md')"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Promoção</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['sku'] ?></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['price'] ?></td>
                                <td><?= $product['promo'] ?></td>
                                <td><?= $product['stock'] ?></td>
                                <td><?= $product['status'] ?></td>
                                <td><?= $product['type'] ?></td>
                                <td><?= $product['updated'] ?></td>
                                <td><?= $product['actions'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">Nenhum produto encontrado</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formCategory" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
            ...formHandler('/admin/catalog/categories/update',
              {
                id: '',
                name: '',
                slug: '',
                position: '',
                is_active: 1,
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

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug" x-model="form.slug">
                    <div class="text-danger small" x-text="errors.slug"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Posição</label>
                    <input type="number" class="form-control" name="position" x-model="form.position">
                    <div class="text-danger small" x-text="errors.position"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ativo</label>
                    <select class="form-select" name="is_active" x-model="form.is_active">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer mt-3">
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

<?= $this->endSection() ?>
