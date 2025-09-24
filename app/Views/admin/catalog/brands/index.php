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
                                    @click="open('#formBrand', 'md')"
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
                                <th>Nome</th>
                                <th>Slug</th>
                                <th>Descrição</th>
                                <th>Imagem</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td><?= esc($brand['name']) ?></td>
                                    <td><?= esc($brand['slug']) ?></td>
                                    <td><?= esc($brand['description']) ?></td>
                                    <td><?= esc($brand['logo']) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/catalog/brands/edit/' . $brand['id']) ?>"
                                           class="btn btn-sm btn-primary w-100">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </td>
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
<div id="formBrand" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Marca</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/brands/store',
                  {
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
                    if (k !== '<?= csrf_token() ?>') form[k] = ''
                  })
                });
                document.addEventListener('csrf-update', e => {
                  form[e.detail.token] = e.detail.hash
                });
             ">
            <form @submit.prevent="submit()">
                <!-- Nome -->
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
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
