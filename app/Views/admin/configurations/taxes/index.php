<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Impostos<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Impostos</h4>
                        <p class="text-muted">Gestão das classes de imposto do sistema</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createTax', 'md')"
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
                            <th>Taxa (%)</th>
                            <th>País</th>
                            <th>Ativo</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($taxes)): ?>
                            <?php foreach ($taxes as $tax): ?>
                                <tr>
                                    <td><?= esc($tax['id']) ?></td>
                                    <td><?= esc($tax['name']) ?></td>
                                    <td><?= esc($tax['rate']) ?></td>
                                    <td><?= esc($tax['country']) ?></td>
                                    <td>
                                        <?php if ($tax['is_active']): ?>
                                            <span class="badge bg-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($tax['created_at'] ?? '—') ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editTax', 'md', {
                                                                id: '<?= $tax['id'] ?>',
                                                                name: '<?= $tax['name'] ?>',
                                                                rate: '<?= $tax['rate'] ?>',
                                                                country: '<?= $tax['country'] ?>',
                                                                is_active: '<?= $tax['is_active'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteTax', 'md', {
                                                                id: '<?= $tax['id'] ?>',
                                                                name: '<?= $tax['name'] ?>'
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
                            <tr><td colspan="7" class="text-center">Nenhum imposto registado.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Create Tax -->
<div id="createTax" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/taxes/store', {
             name: '',
             rate: '',
             country: '',
             is_active: 1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Imposto</h5>
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
                    <label>Taxa (%) *</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.rate">
                    <div class="text-danger small" x-text="errors.rate"></div>
                </div>

                <div class="mb-3">
                    <label>País *</label>
                    <select class="form-select" x-model="form.country">
                        <option value="">Selecione</option>
                        <option value="PT">Portugal</option>
                        <option value="ES">Espanha</option>
                        <option value="FR">França</option>
                        <option value="DE">Alemanha</option>
                        <option value="IT">Itália</option>
                        <option value="BR">Brasil</option>
                    </select>
                    <div class="text-danger small" x-text="errors.country"></div>
                </div>

                <div class="mb-3">
                    <label>Ativo *</label>
                    <select class="form-select" x-model="form.is_active">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_active"></div>
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

<!-- Edit Tax -->
<div id="editTax" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/taxes/update', {
             id:'', name:'', rate:'', country:'', is_active:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Editar Imposto</h5>
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
                    <label>Taxa (%) *</label>
                    <input type="number" step="0.01" class="form-control" x-model="form.rate">
                    <div class="text-danger small" x-text="errors.rate"></div>
                </div>

                <div class="mb-3">
                    <label>País *</label>
                    <select class="form-select" x-model="form.country">
                        <option value="">Selecione</option>
                        <option value="PT">Portugal</option>
                        <option value="ES">Espanha</option>
                        <option value="FR">França</option>
                        <option value="DE">Alemanha</option>
                        <option value="IT">Itália</option>
                        <option value="BR">Brasil</option>
                    </select>
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

<!-- Delete Tax -->
<div id="deleteTax" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/configurations/taxes/delete', {
             id:'', name:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="
            csrfHandler(form);
            $el.addEventListener('fill-form', e => { Object.assign(form, e.detail) });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Imposto</h5>
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
<?= $this->endSection() ?>
