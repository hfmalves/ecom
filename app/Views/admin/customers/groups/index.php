<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-1">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Grupos</h6>
                    <i class="mdi mdi-account-group-outline text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registados no sistema</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ativos</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active'] ?? 0 ?></h3>
                <small class="text-muted">grupos disponíveis</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Inativos</h6>
                    <i class="mdi mdi-close-octagon-outline text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['inactive'] ?? 0 ?></h3>
                <small class="text-muted">grupos desativados</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Grupo Padrão</h6>
                    <i class="mdi mdi-star-outline text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['defaultGroup'] ?? 0 ?></h3>
                <small class="text-muted">grupo predefinido ativo</small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div>
                                <h4 class="card-title mb-1">Grupos de Clientes</h4>
                                <p class="text-muted mb-0">Gerir regras e descontos por grupo</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#createCustomerGroup', 'md')"
                                    class="btn btn-primary">
                                <i class="mdi mdi-plus label-icon"></i>Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-striped align-middle mb-0 w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Desconto (%)</th>
                                <th>Min. Encomenda</th>
                                <th>Max. Encomenda</th>
                                <th class="text-center">Padrão</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($costumers_groups as $g): ?>
                                <tr>
                                    <td class="fw-semibold text-dark"><?= esc($g['name']) ?></td>
                                    <td class="text-muted"><?= esc($g['description']) ?></td>
                                    <td><?= number_format($g['discount_percent'], 2, ',', '.') ?>%</td>
                                    <td><?= $g['min_order_value'] ? number_format($g['min_order_value'], 2, ',', '.') : '-' ?></td>
                                    <td><?= $g['max_order_value'] ? number_format($g['max_order_value'], 2, ',', '.') : '-' ?></td>

                                    <!-- Padrão -->
                                    <td class="text-center">
                                        <?= $g['is_default']
                                                ? '<span class="badge bg-primary w-100">Sim</span>'
                                                : '<span class="badge bg-secondary w-100">Não</span>' ?>
                                    </td>

                                    <!-- Status -->
                                    <td class="text-center">
                                        <?= $g['status'] === 'active'
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-danger w-100">Inativo</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                            <li>
                                                <button type="button"
                                                        class="btn btn-sm btn-light text-info"
                                                        title="Editar Grupo"
                                                        x-data="systemModal()"
                                                        @click="open('#editCustomerGroup', 'md', {
                                                            id: '<?= $g['id'] ?>',
                                                            name: '<?= esc($g['name']) ?>',
                                                            description: '<?= esc($g['description']) ?>',
                                                            discount_percent: '<?= $g['discount_percent'] ?>',
                                                            min_order_value: '<?= $g['min_order_value'] ?>',
                                                            max_order_value: '<?= $g['max_order_value'] ?>',
                                                            is_default: '<?= $g['is_default'] ?>',
                                                            status: '<?= $g['status'] ?>'
                                                        })">
                                                    <i class="mdi mdi-pencil-outline"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="btn btn-sm btn-light text-warning"
                                                        @click="
                                                            window.dispatchEvent(new CustomEvent('customer-group-deactivate', {
                                                                detail: { id: <?= $g['id'] ?>, name: '<?= addslashes($g['name']) ?>' }
                                                            }));
                                                            new bootstrap.Modal(document.getElementById('modalDeactivateCustomerGroup')).show();
                                                        "
                                                        title="Desativar Grupo de Cliente">
                                                    <i class="mdi mdi-cancel"></i>
                                                </button>
                                            </li>

                                            <li>
                                                <button type="button" class="btn btn-sm btn-light text-danger"
                                                        @click="
                                                            window.dispatchEvent(new CustomEvent('customer-group-delete', {
                                                                detail: { id: <?= $g['id'] ?>, name: '<?= addslashes($g['name']) ?>' }
                                                            }));
                                                            new bootstrap.Modal(document.getElementById('modalDeleteCustomerGroup')).show();
                                                        "
                                                        title="Eliminar Grupo de Cliente">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </li>
                                        </ul>
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
<div id="createCustomerGroup" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/customers/groups/store', {
             name: '',
             description: '',
             discount_percent: '',
             min_order_value: '',
             max_order_value: '',
             is_default: '0',
             status: 'active',
             <?= csrf_token() ?>: '<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Grupo de Cliente</h5>
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
                    <label>Descrição</label>
                    <textarea class="form-control" x-model="form.description"></textarea>
                </div>

                <div class="mb-3">
                    <label>Desconto (%)</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.discount_percent">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Mínimo Encomenda</label>
                        <input type="number" step="0.01" class="form-control" x-model="form.min_order_value">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Máximo Encomenda</label>
                        <input type="number" step="0.01" class="form-control" x-model="form.max_order_value">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3"
                         x-data="{ field: 'is_default' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 placeholder: '-- Selecionar --',
                                 language: 'pt'
                             });
                             $(el).val(form[field]).trigger('change.select2');
                             $(el).on('change', () => form[field] = $(el).val());
                             $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                         })">
                        <label :for="field">Padrão</label>
                        <select class="form-select select2" x-ref="select" :id="field" name="is_default">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3"
                         x-data="{ field: 'status' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 placeholder: '-- Selecionar --',
                                 language: 'pt'
                             });
                             $(el).val(form[field]).trigger('change.select2');
                             $(el).on('change', () => form[field] = $(el).val());
                             $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                         })">
                        <label :for="field">Status</label>
                        <select class="form-select select2" x-ref="select" :id="field" name="status">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>
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
<div id="editCustomerGroup" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/customers/groups/update', {
           id:'',
           name:'',
           description:'',
           discount_percent:'',
           min_order_value:'',
           max_order_value:'',
           is_default:'0',
           status:'active',
           <?= csrf_token() ?>:'<?= csrf_hash() ?>'
       })"
         x-init="
           csrfHandler(form);
           $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
       ">
        <div class="modal-header">
            <h5 class="modal-title">Editar Grupo de Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">

                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <div class="mb-3">
                    <label>Descrição</label>
                    <textarea class="form-control" x-model="form.description"></textarea>
                </div>

                <div class="mb-3">
                    <label>Desconto (%)</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.discount_percent">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Mínimo Encomenda</label>
                        <input type="number" step="0.01" class="form-control" x-model="form.min_order_value">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Máximo Encomenda</label>
                        <input type="number" step="0.01" class="form-control" x-model="form.max_order_value">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3"
                         x-data="{ field: 'is_default' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 placeholder: '-- Selecionar --',
                                 language: 'pt'
                             });
                             $(el).val(form[field]).trigger('change.select2');
                             $(el).on('change', () => form[field] = $(el).val());
                             $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                         })">
                        <label :for="field">Padrão</label>
                        <select class="form-select select2" x-ref="select" :id="field" name="is_default">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3"
                         x-data="{ field: 'status' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 placeholder: '-- Selecionar --',
                                 language: 'pt'
                             });
                             $(el).val(form[field]).trigger('change.select2');
                             $(el).on('change', () => form[field] = $(el).val());
                             $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                         })">
                        <label :for="field">Status</label>
                        <select class="form-select select2" x-ref="select" :id="field" name="status">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>
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
<div class="modal fade" id="modalDeactivateCustomerGroup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/customers/groups/deactivate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeactivateCustomerGroup'));
                        if (modal) modal.hide();
                        if (data.message) {
                            const type = data.status === 'success' ? 'success' : 'error';
                            showToast(data.message, type);
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('customer-group-deactivate', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Desativar Grupo de Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer desativar este grupo de cliente?</p>

                <p><strong>ID:</strong> <span x-text="form.id"></span></p>
                <p><strong>Nome:</strong> <span x-text="form.name"></span></p>
            </div>

            <div class="modal-footer">
                <button @click="submit" type="button" class="btn btn-warning" :disabled="loading">
                    <span x-show="!loading">Confirmar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A processar...</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDeleteCustomerGroup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/customers/groups/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteCustomerGroup'));
                        if (modal) modal.hide();
                        if (data.message) {
                            const type = data.status === 'success' ? 'success' : 'error';
                            showToast(data.message, type);
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('customer-group-delete', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Grupo de Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar este grupo de cliente?</p>

                <p><strong>ID:</strong> <span x-text="form.id"></span></p>
                <p><strong>Nome:</strong> <span x-text="form.name"></span></p>
            </div>

            <div class="modal-footer">
                <button @click="submit" type="button" class="btn btn-danger" :disabled="loading">
                    <span x-show="!loading">Eliminar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A processar...</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>
