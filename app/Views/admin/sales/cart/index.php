<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Carrinhos<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row mb-1">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Carrinhos</h6>
                    <i class="mdi mdi-cart-outline text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total_carts'] ?? 0 ?></h3>
                <small class="text-muted">criados no sistema</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ativos</h6>
                    <i class="mdi mdi-cart-check text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active_carts'] ?? 0 ?></h3>
                <small class="text-muted">carrinhos em progresso</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Abandonados</h6>
                    <i class="mdi mdi-cart-off text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['abandoned_carts'] ?? 0 ?></h3>
                <small class="text-muted">total de carrinhos não finalizados</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Convertidos</h6>
                    <i class="mdi mdi-cart-arrow-right text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['converted_carts'] ?? 0 ?></h3>
                <small class="text-muted">carrinhos transformados em encomenda</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Valor Médio (€)</h6>
                    <i class="mdi mdi-currency-eur text-dark fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['avg_cart_value'] ?></h3>
                <small class="text-muted">por carrinho</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Itens Médios</h6>
                    <i class="mdi mdi-format-list-bulleted text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['avg_items'] ?></h3>
                <small class="text-muted">por carrinho</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Últimos 30 dias</h6>
                    <i class="mdi mdi-calendar-clock text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['new_30_days'] ?? 0 ?></h3>
                <small class="text-muted">carrinhos criados</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Abandonados (30d)</h6>
                    <i class="mdi mdi-alert-circle-outline text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['abandoned_30_days'] ?? 0 ?></h3>
                <small class="text-muted">nos últimos 30 dias</small>
            </div>
        </div>
    </div>
</div>

<!-- tabela -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="card-title mb-0">Lista de Carrinhos</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover align-middle dt-responsive nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>Status</th>
                            <th>Cliente</th>
                            <th>Itens</th>
                            <th>Total (€)</th>
                            <th>Valor Médio Item (€)</th>
                            <th>Criado em</th>
                            <th>Atualizado em</th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($carts as $c): ?>
                            <tr>
                                <td>
                                    <?php
                                    $statusLabels = [
                                        'active'    => '<span class="badge bg-warning text-dark w-100">Ativo</span>',
                                        'abandoned' => '<span class="badge bg-danger w-100">Abandonado</span>',
                                        'converted' => '<span class="badge bg-success w-100">Convertido</span>',
                                    ];
                                    echo $statusLabels[$c['status']] ?? $c['status'];
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($c['customer'])): ?>
                                        <?= esc($c['customer']['name']) ?><br>
                                        <small class="text-muted"><?= esc($c['customer']['email']) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Guest</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?= number_format((int)($c['total_items'] ?? 0), 0, '', '.') ?>
                                </td>
                                <td class="text-end fw-semibold"><?= number_format($c['total_value'] ?? 0, 2, ',', ' ') ?> €</td>
                                <td class="text-end">
                                    <?php
                                    $avgItem = ($c['total_items'] ?? 0) > 0
                                        ? ($c['total_value'] / $c['total_items'])
                                        : 0;
                                    echo number_format($avgItem, 2, ',', ' ') . ' €';
                                    ?>
                                </td>
                                <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                                <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($c['updated_at'] ?? $c['created_at'])) ?></td>
                                <td class="text-center">
                                    <ul class="list-unstyled hstack gap-1 mb-0 justify-content-center"
                                        x-data="{ status: '<?= $c['status'] ?>' }">

                                        <!-- Ver / Editar Carrinho (sempre visível) -->
                                        <li>
                                            <a href="<?= base_url('admin/sales/cart/edit/' . $c['id']) ?>"
                                               class="btn btn-sm btn-light text-success" title="Ver Carrinho">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>
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
<div class="modal fade" id="modalAbandonCart" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/sales/cart/abandon', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAbandonCart'));
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
                window.addEventListener('cart-abandon', e => {
                    form.id = e.detail.id;
                });
             ">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning">Marcar como Abandonado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-cart-off text-warning" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer marcar este carrinho como abandonado?</p>
                <p><strong>ID:</strong> <span x-text="form.id"></span></p>
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
<div class="modal fade" id="modalDeleteCart" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/sales/cart/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteCart'));
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
                window.addEventListener('cart-delete', e => {
                    form.id = e.detail.id;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Carrinho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-alert-octagram text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar definitivamente este carrinho?</p>
                <p><strong>ID:</strong> <span x-text="form.id"></span></p>
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
