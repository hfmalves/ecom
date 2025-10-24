<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Envios<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Envios</h6>
                    <i class="mdi mdi-truck-delivery text-primary fs-4"></i>
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
                    <h6 class="text-muted">Pendentes</h6>
                    <i class="mdi mdi-timer-sand text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['pending'] ?? 0 ?></h3>
                <small class="text-muted">aguardam processamento</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Em Processamento</h6>
                    <i class="mdi mdi-cog text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['processing'] ?? 0 ?></h3>
                <small class="text-muted">em preparação</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Enviados</h6>
                    <i class="mdi mdi-truck-fast text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['shipped'] ?? 0 ?></h3>
                <small class="text-muted">em transporte</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Entregues</h6>
                    <i class="mdi mdi-check-circle text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['delivered'] ?? 0 ?></h3>
                <small class="text-muted">entregues com sucesso</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Devolvidos</h6>
                    <i class="mdi mdi-autorenew text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['returned'] ?? 0 ?></h3>
                <small class="text-muted">retornados ao armazém</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Cancelados</h6>
                    <i class="mdi mdi-close-circle text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['canceled'] ?? 0 ?></h3>
                <small class="text-muted">anulados pelo sistema</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Últimos 30 dias</h6>
                    <i class="mdi mdi-calendar-clock text-dark fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['last_30_days'] ?? 0 ?></h3>
                <small class="text-muted">envios recentes</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Lista de Envios</h4>
                    <button type="button" class="btn btn-outline-secondary" disabled>
                        <i class="mdi mdi-plus me-1"></i> Criar Envio (via Encomenda)
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap w-100 align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Encomenda</th>
                            <th>Cliente</th>
                            <th>Transportadora</th>
                            <th>Tracking</th>
                            <th class="text-end">Peso</th>
                            <th class="text-end">Volume</th>
                            <th>Estado</th>
                            <th>Criado em</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($shipments)): ?>
                            <?php foreach ($shipments as $s): ?>
                                <tr>
                                    <td><strong>#<?= esc($s['id']) ?></strong></td>

                                    <td>
                                        #<?= esc($s['order']['id'] ?? '—') ?><br>
                                        <small class="text-muted">
                                            <?= number_format($s['order']['grand_total'] ?? 0, 2, ',', ' ') ?> €
                                        </small>
                                    </td>
                                    <td>
                                        <?= esc($s['customer']['name'] ?? '—') ?><br>
                                        <small class="text-muted"><?= esc($s['customer']['email'] ?? '') ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info w-100">
                                            <?= esc($s['carrier'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($s['tracking_number'])): ?>
                                            <a href="<?= esc($s['tracking_url'] ?? '#') ?>" target="_blank">
                                                <?= esc($s['tracking_number']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <?= number_format($s['weight'] ?? 0, 2, ',', ' ') ?> kg
                                    </td>
                                    <td class="text-end">
                                        <?= number_format(($s['volume'] ?? 0) / 1000000, 3, ',', ' ') ?> m³
                                    </td>
                                    <td>
                                        <?php
                                        $status = $s['status'] ?? 'pendente';
                                        $labels = [
                                                'pending'    => 'Pendente',
                                                'processing' => 'Em processamento',
                                                'shipped'    => 'Enviado',
                                                'delivered'  => 'Entregue',
                                                'returned'   => 'Devolvido',
                                                'canceled'   => 'Cancelado',
                                        ];
                                        $colors = [
                                                'pending'    => 'warning',
                                                'processing' => 'info',
                                                'shipped'    => 'primary',
                                                'delivered'  => 'success',
                                                'returned'   => 'secondary',
                                                'canceled'   => 'danger',
                                        ];
                                        ?>
                                        <span class="badge bg-<?= $colors[$status] ?? 'light' ?> w-100">
                                            <?= esc($labels[$status] ?? ucfirst($status)) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($s['created_at'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($s['updated_at'] ?? $s['created_at'])) ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/sales/shipments/edit/'.$s['id']) ?>"
                                           class="btn btn-sm btn-light text-primary" title="Ver detalhes">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
