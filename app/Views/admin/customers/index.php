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
                    <h6 class="text-muted">Total de Clientes</h6>
                    <i class="mdi mdi-account-multiple text-primary fs-4"></i>
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
                <small class="text-muted">contas em atividade</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Verificados</h6>
                    <i class="mdi mdi-email-check-outline text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['verified'] ?? 0 ?></h3>
                <small class="text-muted">emails confirmados</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Autenticação 2FA</h6>
                    <i class="mdi mdi-shield-lock text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['two_factor'] ?? 0 ?></h3>
                <small class="text-muted">utilizadores com 2FA ativo</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Newsletter</h6>
                    <i class="mdi mdi-email-newsletter text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['newsletter'] ?? 0 ?></h3>
                <small class="text-muted">subscritores ativos</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Fidelizados</h6>
                    <i class="mdi mdi-star-outline text-purple fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['loyalty'] ?? 0 ?></h3>
                <small class="text-muted">clientes com pontos ativos</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Novos (30 dias)</h6>
                    <i class="mdi mdi-calendar-plus text-dark fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['new_30_days'] ?? 0 ?></h3>
                <small class="text-muted">novos registos recentes</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Login Recente</h6>
                    <i class="mdi mdi-clock-outline text-teal fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active_30_days'] ?? 0 ?></h3>
                <small class="text-muted">clientes ativos no último mês</small>
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
                            <div class="position-relative">
                                <h4 class="card-title">Lista de Clientes</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formCustomer', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-hover align-middle dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Grupo</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th class="text-center">Ativo</th>
                                <th class="text-center">Verificado</th>
                                <th class="text-center">Newsletter</th>
                                <th class="text-center">Fidelização</th>
                                <th class="text-center">Último Login</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($costumers as $c): ?>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <?= esc($c['group_name']) ?>
                                    </td>
                                    <td><?= esc($c['name']) ?></td>
                                    <td><?= esc($c['email']) ?></td>
                                    <td><?= esc($c['phone'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <?= $c['is_active']
                                                ? '<span class="badge bg-success w-100">Sim</span>'
                                                : '<span class="badge bg-danger w-100">Não</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $c['is_verified']
                                                ? '<span class="badge bg-success w-100">Sim</span>'
                                                : '<span class="badge bg-warning text-dark w-100">Não</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($c['newsletter_optin']) && $c['newsletter_optin'] == 1): ?>
                                            <i class="mdi mdi-email-check text-success fs-5" title="Subscrito"></i>
                                        <?php else: ?>
                                            <i class="mdi mdi-email-off-outline text-muted fs-5" title="Não subscrito"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($c['loyalty_points']) && $c['loyalty_points'] > 0): ?>
                                            <span class="badge bg-info"><?= esc($c['loyalty_points']) ?> pts</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($c['last_login_at'])): ?>
                                            <span class="text-muted small"><?= date('d/m/Y H:i', strtotime($c['last_login_at'])) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                            <li>
                                                <a href="<?= base_url('admin/customers/edit/' . $c['id']) ?>"
                                                   class="btn btn-sm btn-light text-info" title="Editar Cliente">
                                                    <i class="mdi mdi-pencil-outline"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="btn btn-sm btn-light text-warning"
                                                        @click="
                                                            window.dispatchEvent(new CustomEvent('customer-deactivate', {
                                                                detail: { id: <?= $c['id'] ?>, name: '<?= addslashes($c['name']) ?>' }
                                                            }));
                                                            new bootstrap.Modal(document.getElementById('modalDeactivateCustomer')).show();
                                                        "
                                                        title="Desativar Cliente">
                                                    <i class="mdi mdi-cancel"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="btn btn-sm btn-light text-danger"
                                                        @click="
                                                            window.dispatchEvent(new CustomEvent('customer-delete', {
                                                                detail: { id: <?= $c['id'] ?>, name: '<?= addslashes($c['name']) ?>' }
                                                            }));
                                                            new bootstrap.Modal(document.getElementById('modalDeleteCustomer')).show();
                                                        "
                                                        title="Eliminar Cliente">
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
<div id="formCustomer" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
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
                    gender: '',
                    notes: '',
                    is_active: '',
                    is_verified: '',
                    login_2step: '',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                { resetOnSuccess: true })
             }">

            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" x-model="form.email">
                    <div class="text-danger small" x-text="errors.email"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contacto *</label>
                    <input type="text" class="form-control" name="phone" x-model="form.phone">
                    <div class="text-danger small" x-text="errors.phone"></div>
                </div>
                <div class="col-md-12"
                     x-data="{ field: 'gender' }"
                     x-init="$nextTick(() => {
                         const el = $refs.select;
                         $(el).select2({
                             width: '100%',
                             placeholder: '-- Selecionar --',
                             dropdownParent: $(el).closest('.modal-content'),
                             language: 'pt'
                         });
                         $(el).val(form[field]).trigger('change.select2');
                         $(el).on('change', () => form[field] = $(el).val());
                         $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                     })">
                    <label class="form-label" :for="field">Género</label>
                    <select class="form-select select2" x-ref="select" :id="field" name="gender">
                        <option value="">-- Selecionar --</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                    </select>
                    <template x-if="errors[field]">
                        <small class="text-danger" x-text="errors[field]"></small>
                    </template>
                </div>
                <div class="col-md-12 mt-3"
                     x-data="{ field: 'group_id' }"
                     x-init="$nextTick(() => {
                         const el = $refs.select;
                         $(el).select2({
                             width: '100%',
                             placeholder: '-- Selecionar --',
                             dropdownParent: $(el).closest('.modal-content'),
                             language: 'pt'
                         });
                         $(el).val(form[field]).trigger('change.select2');
                         $(el).on('change', () => form[field] = $(el).val());
                         $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                     })">
                    <label class="form-label" :for="field">Grupo do Cliente</label>
                    <select class="form-select select2" x-ref="select" :id="field" name="group_id">
                        <option value="">-- Selecionar --</option>
                        <?php foreach ($costumers_group ?? [] as $costumer_group): ?>
                            <option value="<?= $costumer_group['id'] ?>"><?= esc($costumer_group['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <template x-if="errors[field]">
                        <small class="text-danger" x-text="errors[field]"></small>
                    </template>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" name="notes" x-model="form.notes" rows="2"></textarea>
                    <div class="text-danger small" x-text="errors.notes"></div>
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
<div class="modal fade" id="modalDeactivateCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/customers/deactivate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeactivateCustomer'));
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
                window.addEventListener('customer-deactivate', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Desativar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer desativar este cliente?</p>
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
<div class="modal fade" id="modalDeleteCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/customers/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteCustomer'));
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
                window.addEventListener('customer-delete', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar definitivamente este cliente?</p>
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
