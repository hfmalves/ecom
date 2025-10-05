<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Métodos de Envio<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Métodos de Envio</h4>
                        <p class="text-muted">Gestão dos métodos e configurações de envio do sistema</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createShipping', 'md')"
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
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Provider</th>
                            <th>Envio Grátis (€)</th>
                            <th>Ativo</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($shipping)): ?>
                            <?php foreach ($shipping as $ship): ?>
                                <tr>
                                    <td><?= esc($ship['id']) ?></td>
                                    <td><code><?= esc($ship['code']) ?></code></td>
                                    <td><?= esc($ship['name']) ?></td>
                                    <td><?= esc($ship['provider']) ?></td>
                                    <td>
                                        <?= esc(number_format($ship['free_shipping_min'], 2)) ?>
                                    </td>
                                    <td>
                                        <?php if ($ship['is_active']): ?>
                                            <span class="badge bg-success w-100">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary w-100">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($ship['updated_at'] ?? '—') ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editShipping', 'md', {
                                                                id: '<?= $ship['id'] ?>',
                                                                code: '<?= $ship['code'] ?>',
                                                                name: '<?= $ship['name'] ?>',
                                                                description: `<?= esc($ship['description']) ?>`,
                                                                provider: '<?= $ship['provider'] ?>',
                                                                config_json: `<?= esc($ship['config_json']) ?>`,
                                                                free_shipping_min: '<?= $ship['free_shipping_min'] ?>',
                                                                is_active: '<?= $ship['is_active'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteShipping', 'md', {
                                                                id: '<?= $ship['id'] ?>',
                                                                name: '<?= $ship['name'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center">Nenhum método de envio registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create Shipping -->
<div id="createShipping" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/shipping/store', {
            code: '',
            name: '',
            description: '',
            provider: '',
            config_json: '{}',
            free_shipping_min: 0,
            is_active: 1,
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Método de Envio</h5>
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
                    <label>Descrição</label>
                    <textarea class="form-control" rows="2" x-model="form.description"></textarea>
                </div>

                <div class="mb-3">
                    <label>Provider *</label>
                    <input type="text" class="form-control" x-model="form.provider">
                </div>

                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control font-monospace small" rows="4" x-model="form.config_json" placeholder='{"api_key": "", "sandbox": false}'></textarea>
                </div>

                <div class="mb-3">
                    <label>Envio Grátis a partir de (€)</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.free_shipping_min">
                </div>

                <div class="mb-3">
                    <label>Ativo *</label>
                    <select class="form-select" x-model="form.is_active">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
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

<!-- Edit Shipping -->
<div id="editShipping" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/shipping/update', {
             id: '', code: '', name: '', description: '', provider: '',
             config_json: '{}', free_shipping_min: 0, is_active: 1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });">
        <div class="modal-header">
            <h5 class="modal-title">Editar Método de Envio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">

                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code">
                </div>

                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                </div>

                <div class="mb-3">
                    <label>Descrição</label>
                    <textarea class="form-control" rows="2" x-model="form.description"></textarea>
                </div>

                <div class="mb-3">
                    <label>Provider *</label>
                    <input type="text" class="form-control" x-model="form.provider">
                </div>

                <div class="mb-3">
                    <label>Configuração (JSON)</label>
                    <textarea class="form-control font-monospace small" rows="4" x-model="form.config_json"></textarea>
                </div>

                <div class="mb-3">
                    <label>Envio Grátis a partir de (€)</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.free_shipping_min">
                </div>

                <div class="mb-3">
                    <label>Ativo *</label>
                    <select class="form-select" x-model="form.is_active">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
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

<!-- Delete Shipping -->
<div id="deleteShipping" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/shipping/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Método de Envio</h5>
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

<?= $this->section('content-script') ?>
<script>
    document.addEventListener('shown.bs.modal', e => {
        const modal = $(e.target);
        modal.find('select.select2').each(function () {
            $(this).select2({
                dropdownParent: modal,
                width: '100%'
            });
        });
    });
</script>
<?= $this->endSection() ?>
