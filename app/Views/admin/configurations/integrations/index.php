<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Integrações<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Integrações</h4>
                        <p class="text-muted">Gestão das integrações ERP, Marketplace, Logística e Pagamentos</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createIntegration', 'md')"
                                class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($integrations)): ?>
                            <?php foreach ($integrations as $i): ?>
                                <tr>
                                    <td><?= esc($i['id']) ?></td>
                                    <td><?= esc($i['name']) ?></td>
                                    <td><?= esc($i['type']) ?></td>
                                    <td>
                                        <?= $i['status']
                                            ? '<span class="badge bg-success">Ativo</span>'
                                            : '<span class="badge bg-secondary">Inativo</span>' ?>
                                    </td>
                                    <td><?= esc($i['updated_at'] ?? '—') ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editIntegration', 'md', {
                                                                id: '<?= $i['id'] ?>',
                                                                name: '<?= $i['name'] ?>',
                                                                type: '<?= $i['type'] ?>',
                                                                config_json: `<?= esc($i['config_json']) ?>`,
                                                                status: '<?= $i['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteIntegration', 'md', {
                                                                id: '<?= $i['id'] ?>',
                                                                name: '<?= $i['name'] ?>'
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
                            <tr><td colspan="6" class="text-center">Nenhuma integração registada.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create -->
<div id="createIntegration" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/integrations/store', {
            name: '', type: '', config_json: '{}', status: 1,
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Integração</h5>
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
                    <label>Tipo *</label>
                    <select class="form-select" x-model="form.type">
                        <option value="">Selecione...</option>
                        <option value="ERP">ERP</option>
                        <option value="Marketplace">Marketplace</option>
                        <option value="Logistics">Logística</option>
                        <option value="Payment">Pagamento</option>
                        <option value="Other">Outro</option>
                    </select>
                    <div class="text-danger small" x-text="errors.type"></div>
                </div>
                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control font-monospace small" rows="4" x-model="form.config_json" placeholder='{"api_key": "", "token": ""}'></textarea>
                </div>
                <div class="mb-3">
                    <label>Status *</label>
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

<!-- Edit -->
<div id="editIntegration" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/integrations/update', {
             id:'', name:'', type:'', config_json:'{}', status:1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });">
        <div class="modal-header">
            <h5 class="modal-title">Editar Integração</h5>
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
                    <label>Tipo *</label>
                    <select class="form-select" x-model="form.type">
                        <option value="ERP">ERP</option>
                        <option value="Marketplace">Marketplace</option>
                        <option value="Logistics">Logística</option>
                        <option value="Payment">Pagamento</option>
                        <option value="Other">Outro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control font-monospace small" rows="4" x-model="form.config_json"></textarea>
                </div>
                <div class="mb-3">
                    <label>Status *</label>
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

<!-- Delete -->
<div id="deleteIntegration" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/integrations/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Integração</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar a integração <strong x-text="form.name"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
