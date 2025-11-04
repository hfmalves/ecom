<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Gestão de Regras de Carrinho<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-2">

    <!-- Total -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Regras</h6>
                    <i class="mdi mdi-bullhorn-outline text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registadas no sistema</small>
            </div>
        </div>
    </div>

    <!-- Ativas -->
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

    <!-- Inativas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Inativas</h6>
                    <i class="mdi mdi-close-circle-outline text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['inactive'] ?? 0 ?></h3>
                <small class="text-muted">temporariamente desativadas</small>
            </div>
        </div>
    </div>

    <!-- A Decorrer -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">A Decorrer</h6>
                    <i class="mdi mdi-timer-outline text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['running'] ?? 0 ?></h3>
                <small class="text-muted">ativas neste momento</small>
            </div>
        </div>
    </div>

    <!-- Agendadas -->
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

    <!-- Expiradas -->
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

    <!-- Criadas nos últimos 30 dias -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Últimos 30 dias</h6>
                    <i class="mdi mdi-calendar-plus text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['last_30_days'] ?? 0 ?></h3>
                <small class="text-muted">regras criadas recentemente</small>
            </div>
        </div>
    </div>

    <!-- Atualizadas nos últimos 30 dias -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Atualizadas</h6>
                    <i class="mdi mdi-calendar-edit text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['modified_30_days'] ?? 0 ?></h3>
                <small class="text-muted">alteradas nos últimos 30 dias</small>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 fw-bold">Gestão de Regras de Carrinho</h4>
                    <small class="text-muted">Visualize, edite ou remova regras de desconto aplicadas no carrinho</small>
                </div>
                <button type="button" class="btn btn-primary btn-sm"
                        data-bs-toggle="modal" data-bs-target="#modalCreateCartRule">
                    <i class="mdi mdi-plus me-1"></i> Nova Regra
                </button>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover align-middle nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Ativa</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Período</th>
                            <th>Prioridade</th>
                            <th>Categorias</th>
                            <th>Produtos</th>
                            <th>Grupos</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($rules as $r): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($r['name']) ?></td>
                                <td>
                                    <span class="badge w-100 bg-<?= $r['status'] ? 'success' : 'danger' ?>">
                                        <?= $r['status'] ? 'Ativa' : 'Inativa' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $typeLabels = [
                                        'percent'       => 'Percentagem',
                                        'fixed'         => 'Valor Fixo',
                                        'free_shipping' => 'Envio Grátis',
                                        'buy_x_get_y'   => 'Leve X Pague Y',
                                    ];
                                    $typeColors = [
                                        'percent'       => 'info',
                                        'fixed'         => 'secondary',
                                        'free_shipping' => 'warning',
                                        'buy_x_get_y'   => 'primary',
                                    ];
                                    $t   = $r['discount_type'] ?? '';
                                    $lbl = $typeLabels[$t]  ?? ucfirst($t);
                                    $col = $typeColors[$t]  ?? 'dark';
                                    ?>
                                    <span class="badge w-100 bg-<?= $col ?>">
                                        <?= $lbl ?>
                                    </span>
                                </td>
                                <td><strong><?= number_format($r['discount_value'], 2, ',', '.') ?> €</strong></td>
                                <td>
                                    <?= $r['start_date'] ? date('d/m/Y', strtotime($r['start_date'])) : '-' ?><br>
                                    <?= $r['end_date'] ? date('d/m/Y', strtotime($r['end_date'])) : '-' ?>
                                </td>
                                <td><?= esc($r['priority'] ?? 0) ?></td>
                                <td>
                                    <?php if (!empty($r['include_categories']) && in_array(1, $r['include_categories'])): ?>
                                        <span class="badge w-100 bg-success">Inclui</span>
                                    <?php else: ?>
                                        <span class="badge w-100 bg-secondary">Nenhum</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($r['include_products']) && in_array(1, $r['include_products'])): ?>
                                        <span class="badge w-100 bg-success">Inclui</span>
                                    <?php else: ?>
                                        <span class="badge w-100 bg-secondary">Nenhum</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($r['include_groups']) && in_array(1, $r['include_groups'])): ?>
                                        <span class="badge w-100 bg-success">Inclui</span>
                                    <?php else: ?>
                                        <span class="badge w-100 bg-secondary">Nenhum</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                        <li>
                                            <a href="<?= base_url('admin/marketing/cart-rules/edit/' . $r['id']) ?>"
                                               class="btn btn-sm btn-light text-info" title="Editar Regra">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-light text-warning"
                                                    @click="
                                                        window.dispatchEvent(new CustomEvent('cart-rule-deactivate', {
                                                            detail: { id: <?= $r['id'] ?>, name: '<?= addslashes($r['name']) ?>' }
                                                        }));
                                                        new bootstrap.Modal(document.getElementById('modalDeactivateCartRule')).show();
                                                    "
                                                    title="Desativar Regra">
                                                <i class="mdi mdi-cancel"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-light text-danger"
                                                    @click="
                                                        window.dispatchEvent(new CustomEvent('cart-rule-delete', {
                                                            detail: { id: <?= $r['id'] ?>, name: '<?= addslashes($r['name']) ?>' }
                                                        }));
                                                        new bootstrap.Modal(document.getElementById('modalDeleteCartRule')).show();
                                                    "
                                                    title="Eliminar Regra">
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
<div class="modal fade" id="modalCreateCartRule" tabindex="-1" aria-labelledby="modalCreateCartRuleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"
             x-data="{
                 ...formHandler('<?= base_url('admin/marketing/cart-rules/store') ?>', {
                     name: '',
                     discount_type: 'percent',
                     discount_value: '',
                     start_date: '',
                     end_date: '',
                     status: 1,
                     <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                 }, { resetOnSuccess: true })
             }">

            <div class="modal-header bg-primary-subtle">
                <h5 class="modal-title text-primary fw-semibold" id="modalCreateCartRuleLabel">
                    Nova Regra de Carrinho
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome da Regra</label>
                        <input type="text" class="form-control" x-model="form.name">
                        <div class="text-danger small" x-text="errors.name"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tipo de Desconto</label>
                        <select class="form-select" x-model="form.discount_type">
                            <option value="percent">Percentagem</option>
                            <option value="fixed">Valor Fixo</option>
                            <option value="free_shipping">Envio Grátis</option>
                            <option value="buy_x_get_y">Leve X, Pague Y</option>
                        </select>
                        <div class="text-danger small" x-text="errors.discount_type"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Valor</label>
                        <input type="number" step="0.01" class="form-control" x-model="form.discount_value">
                        <div class="text-danger small" x-text="errors.discount_value"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Início</label>
                        <input type="date" class="form-control" x-model="form.start_date">
                        <div class="text-danger small" x-text="errors.start_date"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fim</label>
                        <input type="date" class="form-control" x-model="form.end_date">
                        <div class="text-danger small" x-text="errors.end_date"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select class="form-select" x-model="form.status">
                            <option value="1">Ativa</option>
                            <option value="0">Inativa</option>
                        </select>
                        <div class="text-danger small" x-text="errors.status"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" @click="submit()" :disabled="loading">
                    <span x-show="!loading"><i class="mdi mdi-content-save-outline me-1"></i> Guardar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin me-1"></i> A guardar...</span>
                </button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modalDeactivateCartRule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/marketing/cart-rules/deactivate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeactivateCartRule'));
                        if (modal) modal.hide();
                        if (data.message) {
                            const type = data.status === 'success' ? 'success' : 'error';
                            showToast(data.message, type);
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="window.addEventListener('cart-rule-deactivate', e => { form.id = e.detail.id; form.name = e.detail.name; });">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Desativar Regra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer desativar esta regra?</p>
                <p><strong>Regra:</strong> <span x-text="form.name"></span></p>
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
<div class="modal fade" id="modalDeleteCartRule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/marketing/cart-rules/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteCartRule'));
                        if (modal) modal.hide();
                        if (data.message) {
                            const type = data.status === 'success' ? 'success' : 'error';
                            showToast(data.message, type);
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="window.addEventListener('cart-rule-delete', e => { form.id = e.detail.id; form.name = e.detail.name; });">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Regra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar definitivamente esta regra?</p>
                <p><strong>Regra:</strong> <span x-text="form.name"></span></p>
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
