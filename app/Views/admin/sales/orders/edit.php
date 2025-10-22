<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Detalhes da Encomenda</h5>
                <p class="text-muted mb-0">Consulta e gere todas as informações associadas a esta encomenda.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary">
                    <i class="mdi mdi-content-duplicate me-1"></i> Duplicar Encomenda
                </button>
                <button type="button"
                        class="btn btn-primary"
                        @click="
                        window.dispatchEvent(new CustomEvent('order-return', {
                            detail: { id: <?= $order['id'] ?> }
                        }));
                        new bootstrap.Modal(document.getElementById('modalCreateReturn')).show();
                    ">
                    <i class="mdi mdi-autorenew me-1"></i> Criar Devolução
                </button>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->
<form id="customerForm"
      x-ref="form"
      x-data="formHandler(
            '<?= base_url('admin/customers/update') ?>',
            {


                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            }
        )"
      @submit.prevent="submit">
    <div class="row">
        <div class="col-8">
            <!-- Informação Geral -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Artigos</h4>
                    <p class="card-title-desc">Artigos da Encomenda</p>
                    <?php if (!empty($order['items'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Variante</th>
                                    <th>Qtd</th>
                                    <th>Preço Unit.</th>
                                    <th>Total Linha</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $subtotal = 0;
                                foreach ($order['items'] as $idx => $item):
                                    $lineTotal = $item['qty'] * $item['price'];
                                    $subtotal += $lineTotal;
                                    ?>
                                    <tr>
                                        <td><?= $idx + 1 ?></td>
                                        <td><?= esc($item['product_name']) ?></td>
                                        <td><?= esc($item['variant_name']) ?></td>
                                        <td><?= esc($item['qty']) ?></td>
                                        <td><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($lineTotal, 2, ',', ' ') ?> €</td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">Subtotal</th>
                                    <th><?= number_format($subtotal, 2, ',', ' ') ?> €</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-end">Imposto</th>
                                    <th><?= number_format($order['total_tax'] ?? 0, 2, ',', ' ') ?> €</th>
                                </tr>
                                <?php if (!empty($order['total_discount']) && $order['total_discount'] > 0): ?>
                                    <tr>
                                        <th colspan="5" class="text-end">Desconto</th>
                                        <th>-<?= number_format($order['total_discount'], 2, ',', ' ') ?> €</th>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th colspan="5" class="text-end">Total Encomenda</th>
                                    <th><?= number_format($order['grand_total'] ?? 0, 2, ',', ' ') ?> €</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Nenhum artigo nesta encomenda.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Morada de Envio</h4>
                            <p class="card-title-desc">Dados para entrega</p>
                            <?php if (!empty($order['shipping_address'])): ?>
                                <address>
                                    <strong><?= esc($order['shipping_address']['type'] ?? 'Envio') ?></strong><br>
                                    <?= esc($order['shipping_address']['street'] ?? '-') ?><br>
                                    <?= esc($order['shipping_address']['city'] ?? '-') ?>,
                                    <?= esc($order['shipping_address']['postcode'] ?? '-') ?><br>
                                    <?= esc($order['shipping_address']['country'] ?? '-') ?><br>
                                </address>
                            <?php else: ?>
                                <p class="text-muted">Sem morada de envio associada</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Morada de Faturação</h4>
                            <p class="card-title-desc">Dados do cliente para faturação</p>
                            <?php if (!empty($order['billing_address'])): ?>
                                <address>
                                    <strong><?= esc($order['billing_address']['type'] ?? 'Faturação') ?></strong><br>
                                    <?= esc($order['billing_address']['street'] ?? '-') ?><br>
                                    <?= esc($order['billing_address']['city'] ?? '-') ?>,
                                    <?= esc($order['billing_address']['postcode'] ?? '-') ?><br>
                                    <?= esc($order['billing_address']['country'] ?? '-') ?><br>
                                </address>
                            <?php else: ?>
                                <p class="text-muted">Sem morada de faturação associada</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Informação de Pagamento -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informação de Pagamento</h4>
                            <p class="card-title-desc">Estado do pagamento</p>

                            <?php if (!empty($order['payment_method'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Método de Pagamento</label>
                                    <input type="text" class="form-control"
                                           value="<?= esc($order['payment_method']['name'] ?? '-') ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pago em</label>
                                    <input type="text" class="form-control"
                                           value="<?= !empty($order['paid_at']) ? date('d/m/Y H:i', strtotime($order['paid_at'])) : '-' ?>" readonly>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Nenhum pagamento registado</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Informação de Envio -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informação de Envio</h4>
                            <p class="card-title-desc">Estado da expedição</p>

                            <?php if (!empty($order['shipments'][0])):
                                $shipment = $order['shipments'][0];
                                ?>
                                <div class="mb-3">
                                    <label class="form-label">Carrier</label>
                                    <input type="text" class="form-control"
                                           value="<?= esc($shipment['carrier'] ?? $order['shipping_method']['name'] ?? '-') ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tracking</label>
                                    <input type="text" class="form-control"
                                           value="<?= esc($shipment['tracking_number'] ?? '-') ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Expedido em</label>
                                    <input type="text" class="form-control"
                                           value="<?= !empty($shipment['shipped_at']) ? date('d/m/Y H:i', strtotime($shipment['shipped_at'])) : '-' ?>" readonly>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Nenhuma expedição registada</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Coluna lateral -->
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informação do Cliente</h4>
                    <p class="card-title-desc">Dados principais da conta do cliente</p>

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control"
                                   value="<?= esc($order['user']['name'] ?? '-') ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Telefone -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" class="form-control"
                                   value="<?= esc($order['user']['phone'] ?? '-') ?>" readonly>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control"
                                   value="<?= esc($order['user']['email'] ?? '-') ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado</label>
                            <input type="text" class="form-control"
                                   value="<?= !empty($order['user']['is_active']) ? 'Ativo' : 'Inativo' ?>" readonly>
                        </div>

                        <!-- Verificado -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Verificado</label>
                            <input type="text" class="form-control"
                                   value="<?= !empty($order['user']['is_verified']) ? 'Sim' : 'Não' ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Grupo -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Grupo de Cliente</label>
                            <input type="text" class="form-control"
                                   value="<?= esc($order['user']['group_name'] ?? '-') ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Histórico da Encomenda</h4>
                    <ul class="verti-timeline list-unstyled">
                        <?php foreach ($order['status_history'] as $history): ?>
                            <li class="event-list <?= ($history === end($order['status_history'])) ? 'active' : '' ?>">
                                <div class="event-timeline-dot">
                                    <?php
                                    // Ícone consoante o estado
                                    $icons = [
                                        'pending'    => 'bx bx-time',
                                        'processing' => 'bx bx-cog',
                                        'completed'  => 'bx bx-check-circle',
                                        'canceled'   => 'bx bx-x-circle text-danger',
                                        'refunded'   => 'bx bx-revision text-warning',
                                    ];
                                    $icon = $icons[$history['status']] ?? 'bx bx-right-arrow-circle';
                                    ?>
                                    <i class="<?= $icon ?> font-size-18"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <h5 class="font-size-14">
                                            <?= date('d M Y H:i', strtotime($history['created_at'])) ?>
                                            <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                        </h5>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <strong><?= ucfirst($history['status']) ?></strong>
                                            <?php if (!empty($history['comment'])): ?>
                                                – <?= esc($history['comment']) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Atualizar Estado da Encomenda</h4>
                    <form action="<?= base_url('admin/sales/orders/updateStatus/'.$order['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Novo Estado</label>
                            <select name="status_1" id="status_1" class="form-select" required>
                                <option value="">-- Selecionar Estado --</option>
                                <option value="pending">Pendente</option>
                                <option value="processing">Em processamento</option>
                                <option value="completed">Concluída</option>
                                <option value="canceled">Cancelada</option>
                                <option value="refunded">Reembolsada</option>
                            </select>
                        </div>
                        <!-- Comentário -->
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comentário</label>
                            <textare
                        <!-- Notificação -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notify" name="notify" value="1">
                            <label class="form-check-label" for="notify">
                                Notificar cliente por email
                            </label>
                        </div>

                        <!-- Botão -->
                        <div>
                            <button type="submit" class="btn btn-primary w-100">Guardar Atualização</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="refundModal" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Reembolso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th>Qtd Encomenda</th>
                    <th>Qtd a Reembolsar</th>
                    <th>Preço Unit.</th>
                    <th>Total Linha</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order['items'] as $idx => $item): ?>
                    <tr>
                        <td><?= $idx + 1 ?></td>
                        <td><?= esc($item['name'] ?? 'Produto #'.$item['product_id']) ?></td>
                        <td><?= esc($item['qty']) ?></td>
                        <td>
                            <input type="number" class="form-control"
                                   name="refund[<?= $item['id'] ?>]"
                                   max="<?= $item['qty'] ?>" min="0" value="0">
                        </td>
                        <td><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                        <td><?= number_format($item['qty'] * $item['price'], 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Subtotal</th>
                    <td><?= number_format($order['total_items'], 2, ',', ' ') ?> €</td>
                </tr>
                <tr>
                    <th colspan="5" class="text-end">IVA (23%)</th>
                    <td><?= number_format($order['total_tax'], 2, ',', ' ') ?> €</td>
                </tr>
                <tr>
                    <th colspan="5" class="text-end">Total Reembolso</th>
                    <td><b><?= number_format($order['grand_total'], 2, ',', ' ') ?> €</b></td>
                </tr>
                </tfoot>
            </table>

            <div class="mb-3">
                <label class="form-label">Motivo</label>
                <textarea class="form-control" name="reason"
                          placeholder="Descreve o motivo do reembolso"></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary">Confirmar Reembolso</button>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
<?= $this->section('content-script') ?>

<?= $this->endSection() ?>
