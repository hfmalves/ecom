<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Gestão de Campanhas<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-2">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Campanhas</h6>
                    <i class="mdi mdi-bullhorn-outline text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registadas no sistema</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ativas</h6>
                    <i class="mdi mdi-check-circle-outline text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active'] ?? 0 ?></h3>
                <small class="text-muted">em execução</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Expiradas</h6>
                    <i class="mdi mdi-clock-alert-outline text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['expired'] ?? 0 ?></h3>
                <small class="text-muted">fora de validade</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Agendadas</h6>
                    <i class="mdi mdi-calendar-clock text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['upcoming'] ?? 0 ?></h3>
                <small class="text-muted">a iniciar futuramente</small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 fw-bold">Gestão de Campanhas</h4>
                    <small class="text-muted">Visualize, edite ou remova campanhas promocionais</small>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateCampaign">
                    <i class="mdi mdi-plus me-1"></i> Nova Campanha
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover align-middle nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th>Atualizado em</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($campaigns as $c): ?>
                            <tr>
                                <td><?= esc($c['id']) ?></td>
                                <td class="fw-semibold"><?= esc($c['name']) ?></td>
                                <td><?= esc($c['description']) ?: '-' ?></td>
                                <td>
                                    <span class="badge w-100 bg-<?= $c['discount_type'] === 'percent' ? 'info' : 'secondary' ?>">
                                        <?= $c['discount_type'] === 'percent' ? 'Percentagem' : 'Valor Fixo' ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?= number_format($c['discount_value'], 2, ',', '.') ?>
                                        <?= $c['discount_type'] === 'percent' ? '%' : '€' ?></strong>
                                </td>
                                <td><?= date('d/m/Y', strtotime($c['start_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($c['end_date'])) ?></td>
                                <td>
                                    <span class="badge w-100 bg-<?= $c['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= $c['status'] === 'active' ? 'Ativa' : 'Inativa' ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                                <td><?= $c['updated_at'] ? date('d/m/Y H:i', strtotime($c['updated_at'])) : '-' ?></td>
                                <td class="text-center">
                                    <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                        <li>
                                            <a href="<?= base_url('admin/marketing/campaigns/edit/' . $c['id']) ?>"
                                               class="btn btn-sm btn-light text-info" title="Editar Campanha">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-light text-warning"
                                                    @click="
                                                        window.dispatchEvent(new CustomEvent('campaign-deactivate', {
                                                            detail: { id: <?= $c['id'] ?>, name: '<?= addslashes($c['name']) ?>' }
                                                        }));
                                                        new bootstrap.Modal(document.getElementById('modalDeactivateCampaign')).show();
                                                    "
                                                    title="Desativar Campanha">
                                                <i class="mdi mdi-cancel"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-light text-danger"
                                                    @click="
                                                        window.dispatchEvent(new CustomEvent('campaign-delete', {
                                                            detail: { id: <?= $c['id'] ?>, name: '<?= addslashes($c['name']) ?>' }
                                                        }));
                                                        new bootstrap.Modal(document.getElementById('modalDeleteCampaign')).show();
                                                    "
                                                    title="Eliminar Campanha">
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
</div>
<div id="modalCreateCampaign" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Campanha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body"
                 x-data="{
                    ...formHandler('/admin/marketing/campaigns/store', {
                        name: '',
                        description: '',
                        discount_type: 'percent',
                        discount_value: '',
                        start_date: '',
                        end_date: '',
                        status: 'inactive',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    }, { resetOnSuccess: true })
                 }">

                <form @submit.prevent="submit()">
                    <!-- Nome -->
                    <div class="mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" class="form-control" name="name" x-model="form.name">
                        <div class="text-danger small" x-text="errors.name"></div>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" name="description" x-model="form.description" rows="2"></textarea>
                        <div class="text-danger small" x-text="errors.description"></div>
                    </div>

                    <!-- Tipo de Desconto -->
                    <div class="mb-3"
                         x-data="{ field: 'discount_type' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 placeholder: '-- Selecionar tipo --',
                                 language: 'pt'
                             });
                             $(el).on('change', () => form[field] = $(el).val());
                         })">
                        <label class="form-label">Tipo de Desconto *</label>
                        <select class="form-select select2" x-ref="select" x-model="form.discount_type">
                            <option value="percent">Percentagem (%)</option>
                            <option value="fixed">Valor Fixo (€)</option>
                        </select>
                        <small class="text-danger" x-text="errors.discount_type"></small>
                    </div>

                    <!-- Valor do Desconto -->
                    <div class="mb-3">
                        <label class="form-label">Valor *</label>
                        <input type="number" step="0.01" class="form-control" name="discount_value" x-model="form.discount_value">
                        <div class="text-danger small" x-text="errors.discount_value"></div>
                    </div>

                    <!-- Datas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Início</label>
                            <input type="datetime-local" class="form-control" name="start_date" x-model="form.start_date">
                            <div class="text-danger small" x-text="errors.start_date"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fim</label>
                            <input type="datetime-local" class="form-control" name="end_date" x-model="form.end_date">
                            <div class="text-danger small" x-text="errors.end_date"></div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3"
                         x-data="{ field: 'status' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 placeholder: '-- Selecionar estado --',
                                 language: 'pt'
                             });
                             $(el).on('change', () => form[field] = $(el).val());
                         })">
                        <label class="form-label">Estado</label>
                        <select class="form-select select2" x-ref="select" x-model="form.status">
                            <option value="active">Ativa</option>
                            <option value="inactive">Inativa</option>
                        </select>
                        <small class="text-danger" x-text="errors.status"></small>
                    </div>

                    <!-- Botões -->
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
</div>
<!-- Modal Desativar -->
<div class="modal fade" id="modalDeactivateCampaign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/marketing/campaigns/deactivate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeactivateCampaign'));
                        if (modal) modal.hide();
                        if (data.message) {
                            showToast(data.message, data.status === 'success' ? 'success' : 'error');
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('campaign-deactivate', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Desativar Campanha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer desativar esta campanha?</p>
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
<!-- Modal Eliminar -->
<div class="modal fade" id="modalDeleteCampaign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/marketing/campaigns/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteCampaign'));
                        if (modal) modal.hide();
                        if (data.message) {
                            showToast(data.message, data.status === 'success' ? 'success' : 'error');
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('campaign-delete', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Campanha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar definitivamente esta campanha?</p>
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
