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

            <div class="d-flex flex-wrap gap-2"
                 x-data="{
                     status: '<?= strtolower($order['status'] ?? 'pending') ?>',
                     shipStatus: '<?= strtolower($order['shipments'][0]['status'] ?? 'pending') ?>',
                     paymentStatus: '<?= strtolower($order['payment']['status'] ?? 'pending') ?>'
                   }">
                <button class="btn btn-outline-secondary"
                        x-show="!['canceled','refunded'].includes(status)"
                        @click="
                          window.dispatchEvent(new CustomEvent('order-duplicate', { detail: { id: <?= $order['id'] ?> } }));
                          new bootstrap.Modal(document.getElementById('modalDuplicateOrder')).show();
                        ">
                    <i class="mdi mdi-content-duplicate me-1"></i> Duplicar Encomenda
                </button>

                <button class="btn btn-primary"
                        x-show="['shipped','delivered','returned'].includes(shipStatus)
                        && !['canceled','refunded'].includes(status)"
                        @click="
                  window.dispatchEvent(new CustomEvent('order-return', { detail: { id: <?= $order['id'] ?> } }));
                  new bootstrap.Modal(document.getElementById('modalCreateReturn')).show();
                ">
                    <i class="mdi mdi-autorenew me-1"></i> Criar Devolução
                </button>
                <button class="btn btn-danger"
                        x-show="['paid','partial'].includes(paymentStatus)
                        && !['refunded','canceled'].includes(status)"
                        @click="
                  window.dispatchEvent(new CustomEvent('order-refund', { detail: { id: <?= $order['id'] ?> } }));
                  new bootstrap.Modal(document.getElementById('refundModal')).show();
                ">
                    <i class="mdi mdi-cash-refund me-1"></i> Criar Reembolso
                </button>
                <button type="button"
                        class="btn btn-info"
                        x-show="['delivered','returned'].includes(shipStatus)
                        && ['paid','partial'].includes(paymentStatus)
                        && !['refunded','canceled'].includes(status)"
                        @click="
                  window.dispatchEvent(new CustomEvent('order-exchange', { detail: { id: <?= $order['id'] ?> } }));
                  new bootstrap.Modal(document.getElementById('modalCreateExchange')).show();
                ">
                    <i class="mdi mdi-compare-horizontal me-1"></i> Criar Troca
                </button>
            </div>

        </div>
    </div><!--end col-->
</div><!--end row-->
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
            <div class="col-md-6 mb-4" x-data="{ paymentStatus: '<?= $order['payment_status'] ?? 'pending' ?>' }">

            <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Informação de Pagamento</h4>
                        <p class="card-title-desc text-muted mb-3">Detalhes do processamento</p>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Método</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($order['payment_method']['name'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Estado</label><br>
                                <?php
                                $payment = $order['payment'] ?? [];
                                $status = strtolower($payment['status'] ?? 'pending');

                                $labels = [
                                    'pending'    => ['Pendente', 'warning'],
                                    'processing' => ['A Processar', 'info'],
                                    'paid'       => ['Pago', 'success'],
                                    'failed'     => ['Falhou', 'danger'],
                                    'refunded'   => ['Reembolsado', 'secondary'],
                                    'canceled'   => ['Cancelado', 'dark'],
                                ];

                                [$label, $color] = $labels[$status] ?? ['Desconhecido', 'secondary'];
                                ?>
                                <span class="badge w-100 bg-<?= esc($color) ?>"><?= esc($label) ?></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Referência / Transação</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($order['payment']['transaction_id'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Montante Pago</label>
                                <input type="text" class="form-control"
                                       value="<?= number_format($order['payment']['amount'] ?? 0, 2, ',', ' ') ?> €" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Pago em</label>
                                <input type="text" class="form-control"
                                       value="<?= !empty($order['payment']['paid_at'])
                                           ? date('d/m/Y H:i', strtotime($order['payment']['paid_at']))
                                           : '-' ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Informação de Envio</h4>
                        <p class="card-title-desc text-muted mb-3">Estado e dados de expedição</p>
                        <?php $shipment = $order['shipments'][0] ?? []; ?>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Transportadora</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($shipment['carrier'] ?? $order['shipping_method']['name'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Estado</label><br>
                                <?php
                                $shipStatus = $shipment['status'] ?? 'pending';
                                $shipLabels = [
                                    'pending'    => ['Pendente', 'warning'],
                                    'processing' => ['A Processar', 'info'],
                                    'shipped'    => ['Enviado', 'primary'],
                                    'delivered'  => ['Entregue', 'success'],
                                    'returned'   => ['Devolvido', 'danger'],
                                    'canceled'   => ['Cancelado', 'secondary'],
                                ];
                                [$label, $color] = $shipLabels[$shipStatus] ?? ['Desconhecido', 'dark'];
                                ?>
                                <span class="badge w-100 bg-<?= esc($color) ?>"><?= esc($label) ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Código Tracking</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($shipment['tracking_number'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Expedido em</label>
                                <input type="text" class="form-control"
                                       value="<?= !empty($shipment['shipped_at'])
                                           ? date('d/m/Y H:i', strtotime($shipment['shipped_at']))
                                           : '-' ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4"
                 x-data="{ paymentStatus: '<?= strtolower($order['payment']['status'] ?? 'pending') ?>' }">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Alterar Método de Pagamento</h4>
                        <p class="card-title-desc text-muted mb-3">
                            Selecione um novo método e guarde a alteração.
                        </p>

                        <!-- Só mostra se o pagamento ainda não estiver concluído -->
                        <template x-if="['pending','failed'].includes(paymentStatus)">
                            <form
                                    x-data="formHandler('<?= base_url('admin/sales/orders/updatePaymentMethod') ?>', {
                        id: '<?= $order['id'] ?>',
                        payment_method_id: '<?= $order['payment_method_id'] ?>',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    })"
                                    @submit.prevent="submit">

                                <div class="mb-3"
                                     x-data="{ field: 'payment_method_id' }"
                                     x-init="$nextTick(() => {
                             const el = $refs.paymentSelect;
                             $(el).select2({ width: '100%' });
                             $(el).val(form[field]).trigger('change');
                             $(el).on('change', () => form[field] = $(el).val());
                         })">
                                    <label class="form-label">Novo Método</label>
                                    <select class="form-select select2"
                                            x-ref="paymentSelect"
                                            x-model="form[field]">
                                        <option value="">-- Selecionar Método --</option>
                                        <?php foreach ($paymentMethods as $method): ?>
                                            <option value="<?= $method['id'] ?>">
                                                <?= esc($method['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        <span x-show="!loading">Guardar Alteração</span>
                                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A atualizar...</span>
                                    </button>
                                </div>
                            </form>
                        </template>

                        <!-- Se estiver pago ou reembolsado, mostra aviso -->
                        <template x-if="!['pending','failed'].includes(paymentStatus)">
                            <div class="alert alert-secondary mb-0 text-center py-3">
                                <i class="mdi mdi-lock-outline me-1"></i>
                                Este pagamento já foi processado e não pode ser alterado.
                            </div>
                        </template>

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4"
                 x-data="{ shipStatus: '<?= strtolower($order['shipments'][0]['status'] ?? 'pending') ?>' }">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Alterar Método de Envio</h4>
                        <p class="card-title-desc text-muted mb-3">Selecione uma nova transportadora e guarde a alteração.</p>

                        <!-- Mostra o formulário apenas se o envio ainda estiver pendente ou em processamento -->
                        <template x-if="['pending','processing','returned'].includes(shipStatus)">

                        <form
                                    x-data="formHandler('<?= base_url('admin/sales/orders/updateShippingMethod') ?>', {
                        id: '<?= $order['id'] ?>',
                        shipping_method_id: '<?= $order['shipping_method_id'] ?>',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    })"
                                    @submit.prevent="submit">

                                <div class="mb-3"
                                     x-data="{ field: 'shipping_method_id' }"
                                     x-init="$nextTick(() => {
                             const el = $refs.shippingSelect;
                             $(el).select2({ width: '100%' });
                             $(el).val(form[field]).trigger('change');
                             $(el).on('change', () => form[field] = $(el).val());
                         })">
                                    <label class="form-label">Nova Transportadora</label>
                                    <select class="form-select select2"
                                            x-ref="shippingSelect"
                                            x-model="form[field]">
                                        <option value="">-- Selecionar Método --</option>
                                        <?php foreach ($shippingMethods as $method): ?>
                                            <option value="<?= $method['id'] ?>">
                                                <?= esc($method['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        <span x-show="!loading">Guardar Alteração</span>
                                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A atualizar...</span>
                                    </button>
                                </div>
                            </form>
                        </template>

                        <!-- Caso contrário, mostra aviso de bloqueio -->
                        <template x-if="!['pending','processing', 'returned'].includes(shipStatus)">
                            <div class="alert alert-secondary mb-0 text-center py-3">
                                <i class="mdi mdi-lock-outline me-1"></i>
                                Este envio já foi processado e não pode ser alterado.
                            </div>
                        </template>

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
                        <input type="text" class="form-control" value="<?= esc($order['user']['group_name'] ?? '-') ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4"
             x-data="{ status: '<?= $order['status'] ?>' }">
            <template x-if="!['canceled', 'refunded'].includes(status)">
                <form id="orderStatusForm"
                      x-ref="form"
                      x-data="formHandler(
                          '<?= base_url('admin/sales/orders/updateStatus') ?>',
                          {
                              id: '<?= $order['id'] ?>',
                              status: '',
                              comment: '',
                              notify: '0',
                              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                          }
                      )"
                      @submit.prevent="submit">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Atualizar Estado da Encomenda</h4>
                                    <p class="card-title-desc">
                                        Defina o novo estado, adicione um comentário e opte por notificar o cliente.
                                    </p>
                                    <div class="col-md-12 mb-3"
                                         x-data="{
                                            field: 'status',
                                                status: '<?= $order['status'] ?>'
                                             }"
                                            x-init="$nextTick(() => {
                                                const el = $refs.select;
                                                $(el).select2({
                                                    width: '100%',
                                                    minimumResultsForSearch: Infinity
                                                });
                                                $(el).val(form[field]).trigger('change');
                                                $(el).on('change', function () {
                                                    form[field] = $(this).val();
                                                });
                                                $watch('form[field]', val => {
                                                    $(el).val(val).trigger('change.select2');
                                                });
                                             })">
                                        <label class="form-label" :for="field">Novo Estado *</label>
                                        <select class="form-select select2"
                                                x-ref="select"
                                                :id="field"
                                                :name="field"
                                                x-model="form[field]"
                                                :disabled="['canceled', 'refunded'].includes(status)"
                                                :class="{
                                                'is-invalid': errors[field],
                                                'bg-light text-muted': ['canceled', 'refunded'].includes(status)
                                            }">
                                            <option value="">-- Selecionar Estado --</option>
                                            <option value="pending">Pendente</option>
                                            <option value="processing">Em processamento</option>
                                            <option value="completed">Concluída</option>
                                            <option value="canceled">Cancelada</option>
                                            <option value="refunded">Reembolsada</option>
                                        </select>
                                        <template x-if="errors[field]">
                                            <small class="text-danger" x-text="errors[field]"></small>
                                        </template>
                                        <template x-if="['canceled', 'refunded'].includes(status)">
                                            <small class="text-danger d-block mt-2">
                                                Esta encomenda não pode ser atualizada porque está
                                                <span x-text="status === 'canceled' ? 'cancelada' : 'reembolsada'"></span>.
                                            </small>
                                        </template>
                                    </div>
                                    <div class="col-md-12 mb-3" x-data="{ field: 'notify' }">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   :id="field" :name="field"
                                                   x-model="form[field]" true-value="1" false-value="0">
                                            <label class="form-check-label" :for="field">
                                                Notificar cliente por email
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer mt-3">
                                        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                                            <span x-show="!loading">Guardar Atualização</span>
                                            <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A atualizar...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
            <template x-if="['canceled', 'refunded'].includes(status)">
                <div class="p-4 text-center fw-bold"
                     :class="status === 'canceled' ? 'text-danger' : 'text-info'">
                    <i :class="status === 'canceled' ? 'fa fa-ban me-2' : 'fa fa-undo me-2'"></i>
                    <span x-text="status === 'canceled'
                        ? 'Esta encomenda foi cancelada e não pode ser atualizada.'
                        : 'Esta encomenda foi devolvida e não pode ser atualizada.'">
                    </span>
                </div>
            </template>
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
    </div>
</div>
<div id="refundModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
</div>
<div id="modalCreateReturn" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
             x-data="{
                 form: { order_id: '', reason: '', note: '' },
                 async submit() {
                     try {
                         const res = await fetch('/admin/orders/return', {
                             method: 'POST',
                             headers: { 'Content-Type': 'application/json' },
                             body: JSON.stringify(this.form)
                         });
                         const data = await res.json();
                         if (data.status === 'success') {
                             showToast('Devolução criada com sucesso.', 'success');
                             bootstrap.Modal.getInstance($el.closest('.modal')).hide();
                             document.dispatchEvent(new CustomEvent('order-updated'));
                         } else {
                             showToast(data.message || 'Erro ao criar devolução.', 'error');
                         }
                     } catch {
                         showToast('Erro de comunicação com o servidor.', 'error');
                     }
                 }
             }"
             x-init="$el.addEventListener('order-return', e => form.order_id = e.detail.id)">
            <div class="modal-header">
                <h5 class="modal-title">Criar Devolução</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submit()">
                    <div class="mb-3">
                        <label>Motivo da devolução</label>
                        <input type="text" class="form-control" x-model="form.reason" placeholder="Ex: Produto defeituoso">
                    </div>
                    <div class="mb-3">
                        <label>Observações</label>
                        <textarea class="form-control" x-model="form.note"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Submeter Devolução</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modalCreateExchange" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
             x-data="{
                 form: { order_id: '', reason: '', note: '' },
                 async submit() {
                     try {
                         const res = await fetch('/admin/orders/exchange', {
                             method: 'POST',
                             headers: { 'Content-Type': 'application/json' },
                             body: JSON.stringify(this.form)
                         });
                         const data = await res.json();
                         if (data.status === 'success') {
                             showToast('Troca registada com sucesso.', 'success');
                             bootstrap.Modal.getInstance($el.closest('.modal')).hide();
                             document.dispatchEvent(new CustomEvent('order-updated'));
                         } else {
                             showToast(data.message || 'Erro ao registar troca.', 'error');
                         }
                     } catch {
                         showToast('Erro de comunicação com o servidor.', 'error');
                     }
                 }
             }"
             x-init="$el.addEventListener('order-exchange', e => form.order_id = e.detail.id)">
            <div class="modal-header">
                <h5 class="modal-title">Criar Troca</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submit()">
                    <div class="mb-3">
                        <label>Motivo da troca</label>
                        <input type="text" class="form-control" x-model="form.reason" placeholder="Ex: Tamanho incorreto">
                    </div>
                    <div class="mb-3">
                        <label>Observações</label>
                        <textarea class="form-control" x-model="form.note"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info">Confirmar Troca</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modalDuplicateOrder" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
             x-data="{
                 form: { order_id: '', include_items: true, include_customer: false, note: '' },
                 async submit() {
                     try {
                         const res = await fetch('/admin/orders/duplicate', {
                             method: 'POST',
                             headers: { 'Content-Type': 'application/json' },
                             body: JSON.stringify(this.form)
                         });
                         const data = await res.json();
                         if (data.status === 'success') {
                             showToast('Encomenda duplicada com sucesso.', 'success');
                             bootstrap.Modal.getInstance($el.closest('.modal')).hide();
                             document.dispatchEvent(new CustomEvent('order-updated'));
                         } else {
                             showToast(data.message || 'Erro ao duplicar encomenda.', 'error');
                         }
                     } catch {
                         showToast('Erro de comunicação com o servidor.', 'error');
                     }
                 }
             }"
             x-init="$el.addEventListener('order-duplicate', e => form.order_id = e.detail.id)">
            <div class="modal-header">
                <h5 class="modal-title">Duplicar Encomenda</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submit()">
                    <p class="text-muted mb-3">Selecione as opções desejadas antes de duplicar.</p>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="includeItems" x-model="form.include_items">
                        <label class="form-check-label" for="includeItems">Incluir produtos da encomenda original</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="includeCustomer" x-model="form.include_customer">
                        <label class="form-check-label" for="includeCustomer">Associar ao mesmo cliente</label>
                    </div>

                    <div class="mb-3">
                        <label>Nota interna</label>
                        <textarea class="form-control" x-model="form.note" placeholder="Opcional..."></textarea>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success" type="submit">Duplicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('content-script') ?>
<script>
    function initSelect2(el) {
        $(el).select2({
            width: '100%',
            minimumResultsForSearch: Infinity
        }).on('change', function () {
            let event = new Event('input', { bubbles: true });
            event.simulated = true;
            this.dispatchEvent(event);
        });
    }
</script>
<?= $this->endSection() ?>
