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
                                                ? '<span class="badge bg-primary">Sim</span>'
                                                : '<span class="badge bg-secondary">Não</span>' ?>
                                    </td>

                                    <!-- Status -->
                                    <td class="text-center">
                                        <?= $g['status'] === 'active'
                                                ? '<span class="badge bg-success">Ativo</span>'
                                                : '<span class="badge bg-danger">Inativo</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                            <li>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-sm btn-light text-primary"
                                                   title="Ver Grupo">
                                                    <i class="mdi mdi-eye-outline"></i>
                                                </a>
                                            </li>
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
                                                <button type="button"
                                                        class="btn btn-sm btn-light text-warning"
                                                        title="Alterar Estado"
                                                        @click="
                                                        window.dispatchEvent(new CustomEvent('group-toggle', {
                                                            detail: { id: <?= $g['id'] ?>, name: '<?= addslashes($g['name']) ?>' }
                                                        }));
                                                        new bootstrap.Modal(document.getElementById('toggleGroupStatus')).show();
                                                    ">
                                                    <i class="mdi mdi-cancel"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button"
                                                        class="btn btn-sm btn-light text-danger"
                                                        title="Eliminar Grupo"
                                                        x-data="systemModal()"
                                                        @click="open('#deleteCustomerGroup', 'md', {
                                                        id: '<?= $g['id'] ?>',
                                                        name: '<?= esc($g['name']) ?>'
                                                    })">
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
<!-- Create -->
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
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
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
                    <div class="col-md-6 mb-3">
                        <label>Padrão</label>
                        <select class="form-select" x-model="form.is_default">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select class="form-select" x-model="form.status">
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

<!-- Edit -->
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

                <div class="mb-3">
                    <label>Mínimo Encomenda</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.min_order_value">
                </div>

                <div class="mb-3">
                    <label>Máximo Encomenda</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.max_order_value">
                </div>

                <div class="mb-3">
                    <label>Padrão</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select class="form-select" x-model="form.status">
                        <option value="active">Ativo</option>
                        <option value="inactive">Inativo</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete -->
<div id="deleteCustomerGroup" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/customers/groups/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Grupo de Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar <strong x-text="form.name"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger" :disabled="loading">
                        <span x-show="!loading">Eliminar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A eliminar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
