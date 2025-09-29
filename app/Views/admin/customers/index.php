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
                                    @click="open('#formCustomer', 'md')"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Grupo</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Ativo</th>
                                <th>Verificado</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($costumers as $c): ?>
                                <tr>
                                    <td><?= esc($c['group_name']) ?></td>
                                    <td><?= esc($c['name']) ?></td>
                                    <td><?= esc($c['email']) ?></td>
                                    <td><?= esc($c['phone']) ?></td>
                                    <td>
                                        <?= $c['is_active'] ? '<span class="badge bg-success w-100">Sim</span>' : '<span class="badge bg-danger w-100">Não</span>' ?>
                                    </td>
                                    <td>
                                        <?= $c['is_verified'] ? '<span class="badge bg-success w-100">Sim</span>' : '<span class="badge bg-warning w-100">Não</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/customers/edit/' . $c['id']) ?>"
                                           class="btn btn-sm btn-primary w-100">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
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
<div id="formCustomer" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/customers/store',
                  {
                    id: '',
                    group_id: '',
                    name: '',
                    email: '',
                    password: '',
                    phone: '',
                    is_active: '',
                    is_verified: '',
                    login_2step: '',
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
                <!-- Nome -->
                <div class="row mb-3">
                    <div class="col-md-12" x-data="{ field: 'email' }">
                        <label class="form-label">Nome *</label>
                        <input type="text" class="form-control" name="name" x-model="form.name">
                        <div class="text-danger small" x-text="errors.name"></div>
                    </div>
                </div>
                <!-- Email e Telefone -->
                <div class="row mb-3">
                    <div class="col-md-6" x-data="{ field: 'email' }">
                        <label class="form-label" :for="field">Email *</label>
                        <input type="email" class="form-control" :id="field" :name="field" x-model="form[field]">
                        <div class="text-danger small" x-text="errors[field]"></div>
                    </div>
                    <div class="col-md-6" x-data="{ field: 'phone' }">
                        <label class="form-label" :for="field">Contato *</label>
                        <input type="text" class="form-control" :id="field" :name="field" x-model="form[field]">
                        <div class="text-danger small" x-text="errors[field]"></div>
                    </div>
                </div>
                <!-- Grupo, Ativo, Verificado, 2FA -->
                <div class="row mb-3">
                    <div class="col-md-6" x-data="{ field: 'group_id' }">
                        <label class="form-label" :for="field">Grupo do Cliente</label>
                        <select class="form-select" :id="field" :name="field"
                                x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <option value="">-- Selecionar --</option>
                            <?php foreach ($costumers_group ?? [] as $costumer_group): ?>
                                <option value="<?= $costumer_group['id'] ?>"><?= esc($costumer_group['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <template x-if="errors[field]">
                            <small class="text-danger" x-text="errors[field]"></small>
                        </template>
                    </div>

                    <div class="col-md-6" x-data="{ field: 'is_active' }">
                        <label class="form-label" :for="field">Ativo</label>
                        <select class="form-select" :id="field" :name="field"
                                x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <option value="">-- Selecionar --</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <template x-if="errors[field]">
                            <small class="text-danger" x-text="errors[field]"></small>
                        </template>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6" x-data="{ field: 'is_verified' }">
                        <label class="form-label" :for="field">Verificado</label>
                        <select class="form-select" :id="field" :name="field"
                                x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <option value="">-- Selecionar --</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <template x-if="errors[field]">
                            <small class="text-danger" x-text="errors[field]"></small>
                        </template>
                    </div>

                    <div class="col-md-6" x-data="{ field: 'login_2step' }">
                        <label class="form-label" :for="field">Login em 2 Passos</label>
                        <select class="form-select" :id="field" :name="field"
                                x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <option value="">-- Selecionar --</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <template x-if="errors[field]">
                            <small class="text-danger" x-text="errors[field]"></small>
                        </template>
                    </div>
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
