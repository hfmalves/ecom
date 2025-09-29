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
                                    @click="open('#createCustomerGroup', 'md')"
                                    class="btn btn-primary">
                                <i class="mdi mdi-plus me-1"></i> Adicionar Grupo
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <h1>Grupos de Clientes</h1>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Desconto (%)</th>
                                <th>Min. Encomenda</th>
                                <th>Max. Encomenda</th>
                                <th>Padrão</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($costumers_groups as $g): ?>
                                <tr>
                                    <td><?= esc($g['name']) ?></td>
                                    <td><?= esc($g['description']) ?></td>
                                    <td><?= esc($g['discount_percent']) ?>%</td>
                                    <td><?= $g['min_order_value'] ? number_format($g['min_order_value'], 2, ',', '.') : '-' ?></td>
                                    <td><?= $g['max_order_value'] ? number_format($g['max_order_value'], 2, ',', '.') : '-' ?></td>
                                    <td>
                                        <?= $g['is_default'] ? '<span class="badge bg-primary w-100">Sim</span>' : '<span class="badge bg-secondary w-100">Não</span>' ?>
                                    </td>
                                    <td>
                                        <?= $g['status'] === 'active'
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-danger w-100">Inativo</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editCustomerGroup', 'md', {
                                                                id: '<?= $g['id'] ?>',
                                                                name: '<?= esc($g['name']) ?>',
                                                                description: '<?= esc($g['description']) ?>',
                                                                discount_percent: '<?= $g['discount_percent'] ?>',
                                                                min_order_value: '<?= $g['min_order_value'] ?>',
                                                                max_order_value: '<?= $g['max_order_value'] ?>',
                                                                is_default: '<?= $g['is_default'] ?>',
                                                                status: '<?= $g['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteCustomerGroup', 'md', {
                                                                id: '<?= $g['id'] ?>',
                                                                name: '<?= esc($g['name']) ?>'
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
