<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Configurações do Catálogo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Configurações do Catálogo</h4>
                        <p class="text-muted">Gerir parâmetros do catálogo de produtos</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createCatalog', 'md')"
                                class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Chave</th>
                            <th>Valor</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($catalog)): ?>
                            <?php foreach ($catalog as $c): ?>
                                <tr>
                                    <td><?= esc($c['id']) ?></td>
                                    <td><?= esc($c['name']) ?></td>
                                    <td><?= esc($c['key']) ?></td>
                                    <td><?= esc($c['value']) ?></td>
                                    <td><?= esc($c['type']) ?></td>
                                    <td>
                                        <?= $c['status']
                                            ? '<span class="badge bg-success">Ativo</span>'
                                            : '<span class="badge bg-secondary">Inativo</span>' ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editCatalog', 'md', {
                                                                id: '<?= $c['id'] ?>',
                                                                name: '<?= $c['name'] ?>',
                                                                key: '<?= $c['key'] ?>',
                                                                value: '<?= $c['value'] ?>',
                                                                type: '<?= $c['type'] ?>',
                                                                options: '<?= esc($c['options']) ?>',
                                                                status: '<?= $c['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteCatalog', 'md', {
                                                                id: '<?= $c['id'] ?>',
                                                                name: '<?= $c['name'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-trash-can text-danger me-1"></i> Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">Nenhuma configuração registada.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Create Catalog -->
<div id="createCatalog" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/catalog/store', {
            name: '', key: '', value: '', type: 'text', options: '{}', status: 1,
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Configuração</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <div class="mb-3">
                    <label>Chave *</label>
                    <input type="text" class="form-control" x-model="form.key">
                    <div class="text-danger small" x-text="errors.key"></div>
                </div>

                <div class="mb-3">
                    <label>Valor</label>
                    <input type="text" class="form-control" x-model="form.value">
                </div>

                <div class="mb-3">
                    <label>Tipo *</label>
                    <select class="form-select" x-model="form.type">
                        <option value="text">Texto</option>
                        <option value="number">Número</option>
                        <option value="boolean">Boolean</option>
                        <option value="select">Select</option>
                        <option value="json">JSON</option>
                    </select>
                    <div class="text-danger small" x-text="errors.type"></div>
                </div>

                <div class="mb-3">
                    <label>Opções (JSON para select)</label>
                    <textarea class="form-control font-monospace small" rows="3" x-model="form.options" placeholder='{"key1":"Label1","key2":"Label2"}'></textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Catalog -->
<div id="editCatalog" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/catalog/update', {
             id:'', name:'', key:'', value:'', type:'text', options:'{}', status:1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });">
        <div class="modal-header">
            <h5 class="modal-title">Editar Configuração</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                </div>

                <div class="mb-3">
                    <label>Chave *</label>
                    <input type="text" class="form-control" x-model="form.key">
                </div>

                <div class="mb-3">
                    <label>Valor</label>
                    <input type="text" class="form-control" x-model="form.value">
                </div>

                <div class="mb-3">
                    <label>Tipo *</label>
                    <select class="form-select" x-model="form.type">
                        <option value="text">Texto</option>
                        <option value="number">Número</option>
                        <option value="boolean">Boolean</option>
                        <option value="select">Select</option>
                        <option value="json">JSON</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Opções (JSON para select)</label>
                    <textarea class="form-control font-monospace small" rows="3" x-model="form.options"></textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Catalog -->
<div id="deleteCatalog" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/catalog/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="$el.addEventListener('fill-form', e => { Object.assign(form, e.detail); csrfHandler(form); });">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Configuração</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar <strong x-text="form.name"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger w-100">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
