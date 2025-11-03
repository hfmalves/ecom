<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Gestão de Cupões<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 fw-bold">Gestão de Cupões</h4>
                    <small class="text-muted">Visualize, edite ou remova cupões de desconto</small>
                </div>
                <button type="button"
                        class="btn btn-primary btn-sm"
                        x-data="systemModal()"
                        @click="open('#formCoupon', 'lg')">
                    <i class="fa-solid fa-plus me-1"></i> Novo Cupão
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover align-middle nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Ativo</th>
                            <th>Tipo</th>
                            <th>Validade</th>
                            <th>Aplicação</th>
                            <th>Acumulável</th>
                            <th>Valor</th>
                            <th>Desconto Máx.</th>
                            <th>Usos</th>
                            <th>Limite Global</th>
                            <th>Limite Cliente</th>
                            <th>Pedido Mín.</th>
                            <th>Pedido Máx.</th>
                            <th>Criado</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>


                        <tbody>
                        <?php foreach ($coupons as $c): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($c['code']) ?></td>
                                <td>
                                    <span class="badge w-100 bg-<?= $c['is_active'] ? 'success' : 'danger' ?>">
                                        <?= $c['is_active'] ? 'Ativo' : 'Inativo' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge w-100 bg-<?= $c['type'] === 'percent' ? 'info' : 'secondary' ?>">
                                        <?= $c['type'] === 'percent' ? 'Percentagem' : 'Valor Fixo' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($c['days_left'] === null): ?>
                                        <span class="badge bg-info">Sem expiração</span>
                                    <?php elseif ($c['days_left'] == 0): ?>
                                        <span class="badge bg-danger">Expirado</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary-subtle text-primary"><?= $c['days_left'] ?> dias</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $scopeLabels = [
                                        'global'   => 'Global',
                                        'category' => 'Categoria',
                                        'product'  => 'Produto',
                                        'shipping' => 'Envio'
                                    ];

                                    $scopeColors = [
                                        'global'   => 'primary',
                                        'category' => 'info',
                                        'product'  => 'success',
                                        'shipping' => 'warning'
                                    ];

                                    $label = $scopeLabels[$c['scope']] ?? ucfirst($c['scope']);
                                    $color = $scopeColors[$c['scope']] ?? 'secondary';
                                    ?>
                                    <span class="badge w-100 bg-<?= $color ?>">
                                        <?= $label ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge w-100 bg-<?= $c['stackable'] ? 'success' : 'secondary' ?>">
                                        <?= $c['stackable'] ? 'Sim' : 'Não' ?>
                                    </span>
                                </td>
                                <td><strong><?= number_format($c['value'], 2, ',', '.') ?> €</strong></td>
                                <td><?= $c['max_discount_value'] ? number_format($c['max_discount_value'], 2, ',', '.') : '-' ?></td>
                                <td><?= esc($c['usages']) ?></td>
                                <td><?= $c['max_uses'] ?: '∞' ?></td>
                                <td><?= $c['max_uses_per_customer'] ?: '∞' ?></td>
                                <td>
                                    <?= $c['min_order_value']
                                        ? '<strong>' . number_format($c['min_order_value'], 2, ',', '.') . ' €</strong>'
                                        : '-' ?>
                                </td>
                                <td>
                                    <?= $c['max_order_value']
                                        ? '<strong>' . number_format($c['max_order_value'], 2, ',', '.') . ' €</strong>'
                                        : '-' ?>
                                </td>
                                <td><?= date('d M Y', strtotime($c['created_at'])) ?></td>
                                <td class="text-center">
                                    <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center">
                                        <li>
                                            <a href="<?= base_url('admin/marketing/coupons/edit/' . $c['id']) ?>"
                                               class="btn btn-sm btn-light text-info" title="Editar Cupão">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-light text-warning"
                                                    @click="
                                                        window.dispatchEvent(new CustomEvent('coupon-deactivate', {
                                                            detail: { id: <?= $c['id'] ?>, code: '<?= addslashes($c['code']) ?>' }
                                                        }));
                                                        new bootstrap.Modal(document.getElementById('modalDeactivateCoupon')).show();
                                                    "
                                                    title="Desativar Cupão">
                                                <i class="mdi mdi-cancel"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-light text-danger"
                                                    @click="
                                                    window.dispatchEvent(new CustomEvent('coupon-delete', {
                                                        detail: { id: <?= $c['id'] ?>, code: '<?= addslashes($c['code']) ?>' }
                                                    }));
                                                    new bootstrap.Modal(document.getElementById('modalDeleteCoupon')).show();
                                                "
                                                    title="Eliminar Cupão">
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
<div class="modal fade" id="modalDeactivateCoupon" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', code: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/marketing/coupons/deactivate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeactivateCoupon'));
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
                window.addEventListener('coupon-deactivate', e => {
                    form.id = e.detail.id;
                    form.code = e.detail.code;
                });
             ">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Desativar Cupão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-warning" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer desativar este cupão?</p>
                <p><strong>Código:</strong> <span x-text="form.code"></span></p>
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
<div class="modal fade" id="modalDeleteCoupon" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', code: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/marketing/coupons/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteCoupon'));
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
                window.addEventListener('coupon-delete', e => {
                    form.id = e.detail.id;
                    form.code = e.detail.code;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Cupão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar definitivamente este cupão?</p>
                <p><strong>Código:</strong> <span x-text="form.code"></span></p>
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
