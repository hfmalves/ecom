<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <!-- Total de Encomendas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Encomendas</h6>
                    <i class="mdi mdi-cart-outline text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total_orders'] ?></h3>
                <small class="text-muted">todas as encomendas</small>
            </div>
        </div>
    </div>
    <!-- Pendentes -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Pendentes</h6>
                    <i class="mdi mdi-timer-sand text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['pending_orders'] ?></h3>
                <small class="text-muted">aguardam processamento</small>
            </div>
        </div>
    </div>
    <!-- Em Processamento -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Em Processamento</h6>
                    <i class="mdi mdi-progress-clock text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['processing_orders'] ?></h3>
                <small class="text-muted">em preparação / expedição</small>
            </div>
        </div>
    </div>
    <!-- Concluídas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Concluídas</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['completed_orders'] ?></h3>
                <small class="text-muted">entregues com sucesso</small>
            </div>
        </div>
    </div>
    <!-- Canceladas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Canceladas</h6>
                    <i class="mdi mdi-cancel text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['canceled_orders'] ?></h3>
                <small class="text-muted">anuladas pelo sistema / cliente</small>
            </div>
        </div>
    </div>
    <!-- Reembolsadas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Reembolsadas</h6>
                    <i class="mdi mdi-cash-refund text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['refunded_orders'] ?></h3>
                <small class="text-muted">com devolução de valor</small>
            </div>
        </div>
    </div>
    <!-- Receita Total -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Receita Total</h6>
                    <i class="mdi mdi-currency-eur text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total_revenue'] ?> €</h3>
                <small class="text-muted">valor bruto acumulado</small>
            </div>
        </div>
    </div>
    <!-- Descontos Totais -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Descontos Totais</h6>
                    <i class="mdi mdi-sale text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total_discount'] ?> €</h3>
                <small class="text-muted">valores de desconto aplicados</small>
            </div>
        </div>
    </div>
    <!-- Ticket Médio -->
    <!-- Ticket Médio -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ticket Médio</h6>
                    <i class="mdi mdi-chart-bar text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['avg_ticket'] ?> €</h3>
                <small class="text-muted">valor médio por encomenda</small>
            </div>
        </div>
    </div>

    <!-- Artigos Médios -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Artigos Médios</h6>
                    <i class="mdi mdi-package-variant text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['avg_items'] ?></h3>
                <small class="text-muted">média de produtos por encomenda</small>
            </div>
        </div>
    </div>
    <!-- Novas Encomendas (30 dias) -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Novas (30 dias)</h6>
                    <i class="mdi mdi-calendar-clock text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['new_30_days'] ?></h3>
                <small class="text-muted">encomendas criadas recentemente</small>
            </div>
        </div>
    </div>
    <!-- Receita (30 dias) -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Receita (30 dias)</h6>
                    <i class="mdi mdi-chart-line text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['revenue_30_days'] ?> €</h3>
                <small class="text-muted">faturação do último mês</small>
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
                                <h4 class="card-title">Minhas Encomendas </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="<?= base_url('admin/sales/orders/create') ?>"
                               class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Nova Encomenda
                            </a>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100 align-middle">
                            <thead class="table-light">
                            <tr>
                                <th rowspan="2">Estado</th>
                                <th rowspan="2">Cliente</th>
                                <th rowspan="2">Artigos</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">Desconto</th>
                                <th colspan="3" class="text-center">Pagamento</th>
                                <th colspan="4" class="text-center">Envios</th>
                                <th rowspan="2">Criada em</th>
                                <th rowspan="2" class="text-center">Ações</th>
                            </tr>
                                <tr>
                                    <th>Método</th>
                                    <th>Estado</th>
                                    <th>Data</th>
                                    <th>Transportadora</th>
                                    <th>Codigo</th>
                                    <th>Estado</th>
                                    <th>Data</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $o): ?>
                                    <tr>
                                        <!-- Estado -->
                                        <td>
                                            <?php
                                            echo match($o['status']) {
                                                'pending'    => '<span class="badge w-100 bg-warning ">Pendente</span>',
                                                'processing' => '<span class="badge w-100 bg-info">Em processamento</span>',
                                                'completed'  => '<span class="badge w-100 bg-success">Concluída</span>',
                                                'canceled'   => '<span class="badge w-100 bg-danger">Cancelada</span>',
                                                'refunded'   => '<span class="badge w-100 bg-secondary">Reembolsada</span>',
                                                default      => '<span class="badge w-100 bg-dark">Desconhecido</span>',
                                            };
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $fullName = trim($o['user']['name'] ?? 'Sem cliente');
                                            $parts    = explode(' ', $fullName);
                                            $displayName = count($parts) > 1
                                                ? "{$parts[0]} " . end($parts)
                                                : $fullName;
                                            ?>
                                            <strong><?= esc($displayName) ?></strong><br>
                                            <small class="text-muted"><?= esc($o['user']['email'] ?? '-') ?></small>
                                        </td>

                                        <td class="text-end"><?= number_format($o['total_items'], 0, ',', ' ') ?></td>
                                        <td class="text-end"><?= number_format($o['grand_total'], 2, ',', ' ') ?> €</td>
                                        <td class="text-end">
                                            <?php if ($o['total_discount'] > 0): ?>
                                                <span class="badge w-100 bg-danger">-<?= number_format($o['total_discount'], 2, ',', ' ') ?> €</span>
                                            <?php else: ?>
                                                <span class="badge w-100 bg-success">0,00 €</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= !empty($o['payment_method']['name'])
                                                    ? '<span class="badge w-100 bg-primary">' . esc($o['payment_method']['name']) . '</span>'
                                                    : '<span class="badge w-100 bg-light text-muted">—</span>'
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $status = $o['payment']['status'] ?? 'pending';
                                            $map = [
                                                'pending'  => 'warning',
                                                'paid'     => 'success',
                                                'refunded' => 'info',
                                                'failed'   => 'danger',
                                                'partial'  => 'secondary',
                                            ];
                                            $color = $map[$status] ?? 'light';
                                            ?>
                                            <span class="badge w-100 bg-<?= $color ?>">
                                            <?= ucfirst($status) ?>
                                            </span>
                                        </td>
                                        <td>

                                            <?php if (!empty($o['payment']['paid_at'])): ?>
                                                <br>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($o['payment']['paid_at'])) ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= !empty($o['shipping_method']['name'])
                                                    ? '<span class="badge w-100 bg-info">' . esc($o['shipping_method']['name']) . '</span>'
                                                    : '<span class="badge w-100 bg-light">—</span>' ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($o['shipments'])): ?>
                                                <?php foreach ($o['shipments'] as $s): ?>
                                                    <small class="text-muted"><?= esc($s['tracking_number'] ?? '-') ?></small><br>
                                                <?php endforeach ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $shipStatus = $o['shipment_status'] ?? 'pending';
                                            $mapShip = [
                                                'pending'    => 'warning',
                                                'processing' => 'info',
                                                'shipped'    => 'primary',
                                                'delivered'  => 'success',
                                                'returned'   => 'secondary',
                                                'canceled'   => 'danger',
                                            ];
                                            $shipColor = $mapShip[$shipStatus] ?? 'light';
                                            ?>
                                            <span class="badge w-100 bg-<?= $shipColor ?>">
                                                <?= ucfirst($shipStatus) ?>
                                            </span>

                                        </td>
                                        <td>
                                            <?php if (!empty($o['shipped_at'])): ?>
                                                <br><small class="text-muted"><?= date('d/m/Y', strtotime($o['shipped_at'])) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= !empty($o['created_at'])
                                                    ? date('d/m/Y H:i', strtotime($o['created_at']))
                                                    : '<span class="text-muted">—</span>' ?>
                                        </td>
                                        <?php
                                        $paymentStatus = $o['payment']['status'] ?? 'pending';
                                        $shipStatus    = $o['shipment_status'] ?? 'pending';
                                        $orderStatus   = $o['status'] ?? 'pending';
                                        ?>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                    <!-- Ver Detalhes -->
                                                    <li>
                                                        <a href="<?= base_url('admin/sales/orders/edit/' . $o['id']) ?>"
                                                           class="btn btn-sm btn-light text-primary" title="Ver detalhes">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </a>
                                                    </li>

                                                    <?php if ($orderStatus === 'canceled' || $orderStatus === 'refunded'): ?>
                                                        <!-- Recomprar ou Nota de crédito -->
                                                        <?php if ($orderStatus === 'refunded'): ?>
                                                            <li>
                                                                <a href="<?= base_url('admin/sales/orders/credit-note/' . $o['id']) ?>"
                                                                   class="btn btn-sm btn-light text-secondary" title="Ver nota de crédito">
                                                                    <i class="mdi mdi-file-document-edit-outline"></i>
                                                                </a>
                                                            </li>
                                                        <?php else: ?>
                                                            <li>
                                                                <button type="button" class="btn btn-sm btn-light text-info"
                                                                        title="Recomprar encomenda"
                                                                        @click="
                                                                            window.dispatchEvent(new CustomEvent('order-rebuy', {
                                                                                detail: { id: <?= $o['id'] ?> }
                                                                            }));
                                                                            new bootstrap.Modal(document.getElementById('modalRebuyOrder')).show();
                                                                        ">
                                                                    <i class="mdi mdi-refresh"></i>
                                                                </button>
                                                            </li>
                                                        <?php endif; ?>

                                                    <?php elseif ($paymentStatus !== 'paid'): ?>
                                                        <!-- Aguardar pagamento -->
                                                        <li>
                                                            <button type="button"
                                                                    class="btn btn-sm btn-light text-warning"
                                                                    title="Cancelar encomenda"
                                                                    @click="
                                                                        window.dispatchEvent(new CustomEvent('order-cancel', {
                                                                            detail: { id: <?= $o['id'] ?>, name: '<?= addslashes($o['user']['name'] ?? 'Sem nome') ?>' }
                                                                        }));
                                                                        new bootstrap.Modal(document.getElementById('modalCancelOrder')).show();
                                                                    ">
                                                                <i class="mdi mdi-cancel"></i>
                                                            </button>
                                                        </li>

                                                    <?php elseif ($paymentStatus === 'paid' && $shipStatus === 'pending'): ?>
                                                        <!-- Enviar encomenda -->
                                                        <li>
                                                            <button type="button"
                                                                    class="btn btn-sm btn-light text-success"
                                                                    title="Preparar / Enviar encomenda"
                                                                    @click="
                                                                        window.dispatchEvent(new CustomEvent('order-send', {
                                                                            detail: { id: <?= $o['id'] ?> }
                                                                        }));
                                                                        new bootstrap.Modal(document.getElementById('modalSendOrder')).show();
                                                                    ">
                                                                <i class="mdi mdi-truck-fast-outline"></i>
                                                            </button>
                                                        </li>

                                                    <?php elseif ($shipStatus === 'shipped'): ?>
                                                        <!-- Marcar como entregue -->
                                                        <li>
                                                            <button type="button"
                                                                    class="btn btn-sm btn-light text-success"
                                                                    title="Marcar como entregue"
                                                                    @click="
                                                                        window.dispatchEvent(new CustomEvent('order-deliver', {
                                                                            detail: { id: <?= $o['id'] ?> }
                                                                        }));
                                                                        new bootstrap.Modal(document.getElementById('modalDeliverOrder')).show();
                                                                    ">
                                                                <i class="mdi mdi-package-variant-closed-check"></i>
                                                            </button>
                                                        </li>

                                                    <?php elseif ($shipStatus === 'delivered' && $orderStatus === 'completed'): ?>
                                                        <!-- Fatura -->
                                                        <li>
                                                            <a href="<?= base_url('admin/sales/orders/invoice/' . $o['id']) ?>"
                                                               class="btn btn-sm btn-light text-secondary" title="Ver fatura">
                                                                <i class="mdi mdi-file-document-outline"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
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
    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
<?= $this->section('content-script') ?>
<?= $this->endSection() ?>

