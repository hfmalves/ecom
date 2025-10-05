<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Idiomas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Idiomas</h4>
                        <p class="text-muted">Gestão de idiomas do sistema</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createLanguage', 'md')"
                                class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Padrão</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($languages)): ?>
                            <?php foreach($languages as $lang): ?>
                                <tr>
                                    <td><?= esc($lang['id']) ?></td>
                                    <td><?= esc($lang['code']) ?></td>
                                    <td><?= esc($lang['name']) ?></td>
                                    <td><?= $lang['is_default'] ? '<span class="badge bg-primary">Sim</span>' : '<span class="badge bg-secondary">Não</span>' ?></td>
                                    <td><?= $lang['status'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>' ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <!-- Botão Editar -->
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editLanguage', 'md', {
                            id: '<?= $lang['id'] ?>',
                            code: '<?= $lang['code'] ?>',
                            name: '<?= $lang['name'] ?>',
                            is_default: '<?= $lang['is_default'] ?>',
                            status: '<?= $lang['status'] ?>'
                        })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <!-- Botão Apagar -->
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteLanguage', 'md', {
                            id: '<?= $lang['id'] ?>',
                            name: '<?= $lang['name'] ?>'
                        })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-trash-can text-danger me-1"></i> Apagar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Nenhum idioma registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create Language -->
<div id="createLanguage" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/languages/store', {
            code: '', name: '', is_default: 0, status: 1,
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">

        <div class="modal-header">
            <h5 class="modal-title">Criar Idioma</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code">
                    <div class="text-danger small" x-text="errors.code"></div>
                </div>

                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <div class="mb-3">
                    <label>Padrão *</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_default"></div>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <div class="text-danger small" x-text="errors.status"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Language -->
<div id="editLanguage" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/languages/update', {
            id:'', code:'', name:'', is_default:'', status:'',
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Editar Idioma</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code">
                    <div class="text-danger small" x-text="errors.code"></div>
                </div>

                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <div class="mb-3">
                    <label>Padrão *</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_default"></div>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <div class="text-danger small" x-text="errors.status"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Language -->
<div id="deleteLanguage" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/languages/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="$el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Idioma</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar <strong x-text="form.name"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
