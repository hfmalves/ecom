<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Métodos de Pagamento<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Métodos de Pagamento</h4>
                        <p class="text-muted">Gestão dos gateways e métodos de pagamento disponíveis no sistema</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createPayment', 'md')"
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
                            <th>Code</th>
                            <th>Nome</th>
                            <th>Provider</th>
                            <th>Descrição</th>
                            <th>Ativo</th>
                            <th>Padrão</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($payments)): ?>
                            <?php foreach ($payments as $pay): ?>
                                <tr>
                                    <td><?= esc($pay['id']) ?></td>
                                    <td><code><?= esc($pay['code']) ?></code></td>
                                    <td><?= esc($pay['name']) ?></td>
                                    <td><?= esc($pay['provider']) ?></td>
                                    <td><?= esc($pay['description'] ?? '—') ?></td>
                                    <td>
                                        <?php if ($pay['is_active']): ?>
                                            <span class="badge bg-success w-100">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary w-100">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($pay['is_default']): ?>
                                            <span class="badge bg-primary w-100">Sim</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark w-100">Não</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($pay['updated_at'] ?? '—') ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editPayment', 'md', {
                                                                id: '<?= $pay['id'] ?>',
                                                                code: '<?= $pay['code'] ?>',
                                                                name: '<?= $pay['name'] ?>',
                                                                description: '<?= esc($pay['description']) ?>',
                                                                provider: '<?= $pay['provider'] ?>',
                                                                is_active: '<?= $pay['is_active'] ?>',
                                                                is_default: '<?= $pay['is_default'] ?>',
                                                                config_json: `<?= esc($pay['config_json']) ?>`
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deletePayment', 'md', {
                                                                id: '<?= $pay['id'] ?>',
                                                                name: '<?= $pay['name'] ?>'
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
                            <tr><td colspan="9" class="text-center">Nenhum método registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create Payment -->
<div id="createPayment" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/payments/store', {
            code: '',
            name: '',
            description: '',
            provider: '',
            is_active: 1,
            is_default: 0,
            config_json: '{}',
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Método de Pagamento</h5>
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
                    <label>Ativo *</label>
                    <select class="form-select" x-model="form.is_active">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Padrão *</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
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

<!-- Edit Payment -->
<div id="editPayment" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/payments/update', {
             id: '', code: '', name: '', description: '', provider: '', config_json: '{}',
             is_active: 1, is_default: 0,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Editar Método de Pagamento</h5>
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
                    <label>Ativo *</label>
                    <select class="form-select" x-model="form.is_active">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Padrão *</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
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

<!-- Delete Payment -->
<div id="deletePayment" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/payments/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Método</h5>
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
