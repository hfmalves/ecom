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
                                    @click="open('#formAttribute', 'md')"
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
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Obrigatório</th>
                        <th>Filtrável</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($atributes)): ?>
                        <?php foreach ($atributes as $atribute): ?>
                            <tr>
                                <td><?= $atribute['id'] ?></td>
                                <td><?= $atribute['code'] ?></td>
                                <td><?= $atribute['name'] ?></td>
                                <td><?= $atribute['type'] ?></td>
                                <td><?= $atribute['is_required'] ?></td>
                                <td><?= $atribute['is_filterable'] ?></td>
                                <td><?= $atribute['created_at'] ?></td>
                                <td>
                                    <a href="<?= base_url('admin/catalog/attributes/edit/' . $atribute['id']) ?>"
                                       class="btn btn-sm btn-primary w-100">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </td>
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
<div id="formAttribute" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Atributo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/attributes/store',
                  {
                    code: '',
                    name: '',
                    type: 'text',
                    is_required: '0',
                    is_filterable: '0',
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

                <!-- code -->
                <div class="mb-3">
                    <label class="form-label">Código *</label>
                    <input type="text" class="form-control" name="code" x-model="form.code">
                    <div class="text-danger small" x-text="errors.code"></div>
                </div>

                <!-- name -->
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <!-- type -->
                <div class="mb-3">
                    <label class="form-label">Tipo *</label>
                    <select class="form-select" name="type" x-model="form.type">
                        <option value="">-- Selecionar --</option>
                        <option value="text">Texto</option>
                        <option value="number">Número</option>
                        <option value="select">Seleção</option>
                    </select>
                    <div class="text-danger small" x-text="errors.type"></div>
                </div>

                <!-- is_required -->
                <div class="mb-3">
                    <label class="form-label">Obrigatório *</label>
                    <select class="form-select" name="is_required" x-model="form.is_required">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_required"></div>
                </div>

                <!-- is_filterable -->
                <div class="mb-3">
                    <label class="form-label">Filtrável *</label>
                    <select class="form-select" name="is_filterable" x-model="form.is_filterable">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_filterable"></div>
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
