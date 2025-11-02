<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">


<div class="row">
    <div class="col-8">
        <!-- Informação Geral -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Artigos</h4>
                <p class="card-title-desc">Artigos do Carrinho</p>
                <?php if (!empty($cart['items'])): ?>
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
                            foreach ($cart['items'] as $idx => $item):
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
                                <th><?= number_format($cart['total_tax'] ?? 0, 2, ',', ' ') ?> €</th>
                            </tr>
                            <?php if (!empty($cart['total_discount']) && $cart['total_discount'] > 0): ?>
                                <tr>
                                    <th colspan="5" class="text-end">Desconto</th>
                                    <th>-<?= number_format($cart['total_discount'], 2, ',', ' ') ?> €</th>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th colspan="5" class="text-end">Total Carrinho</th>
                                <th><?= number_format($cart['grand_total'] ?? 0, 2, ',', ' ') ?> €</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Nenhum artigo neste carrinho.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Morada de Envio</h4>
                        <p class="card-title-desc">Dados para entrega</p>
                        <?php if (!empty($cart['shipping_address'])): ?>
                            <address>
                                <strong><?= esc($cart['shipping_address']['type'] ?? 'Envio') ?></strong><br>
                                <?= esc($cart['shipping_address']['street'] ?? '-') ?><br>
                                <?= esc($cart['shipping_address']['city'] ?? '-') ?>,
                                <?= esc($cart['shipping_address']['postcode'] ?? '-') ?><br>
                                <?= esc($cart['shipping_address']['country'] ?? '-') ?><br>
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
                        <?php if (!empty($cart['billing_address'])): ?>
                            <address>
                                <strong><?= esc($cart['billing_address']['type'] ?? 'Faturação') ?></strong><br>
                                <?= esc($cart['billing_address']['street'] ?? '-') ?><br>
                                <?= esc($cart['billing_address']['city'] ?? '-') ?>,
                                <?= esc($cart['billing_address']['postcode'] ?? '-') ?><br>
                                <?= esc($cart['billing_address']['country'] ?? '-') ?><br>
                            </address>
                        <?php else: ?>
                            <p class="text-muted">Sem morada de faturação associada</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pagamento -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Informação de Pagamento</h4>
                        <p class="card-title-desc text-muted mb-3">Detalhes do processamento</p>
                        <?php
                        $payment = $cart['payment'] ?? [];
                        $status = strtolower($payment['status'] ?? 'pending');
                        $labels = [
                            'pending' => ['Pendente', 'warning'],
                            'processing' => ['A Processar', 'info'],
                            'paid' => ['Pago', 'success'],
                            'failed' => ['Falhou', 'danger'],
                            'refunded' => ['Reembolsado', 'secondary'],
                            'canceled' => ['Cancelado', 'dark'],
                        ];
                        [$label, $color] = $labels[$status] ?? ['Desconhecido', 'secondary'];
                        ?>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Método</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($cart['payment_method']['name'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Estado</label><br>
                                <span class="badge w-100 bg-<?= esc($color) ?>"><?= esc($label) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Envio -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Informação de Envio</h4>
                        <p class="card-title-desc text-muted mb-3">Estado e dados de expedição</p>
                        <?php $shipment = $cart['shipments'][0] ?? []; ?>
                        <?php
                        $shipStatus = $shipment['status'] ?? 'pending';
                        $shipLabels = [
                            'pending' => ['Pendente', 'warning'],
                            'processing' => ['A Processar', 'info'],
                            'shipped' => ['Enviado', 'primary'],
                            'delivered' => ['Entregue', 'success'],
                            'returned' => ['Devolvido', 'danger'],
                            'canceled' => ['Cancelado', 'secondary'],
                        ];
                        [$label, $color] = $shipLabels[$shipStatus] ?? ['Desconhecido', 'dark'];
                        ?>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Transportadora</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($shipment['carrier'] ?? $cart['shipping_method']['name'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Estado</label><br>
                                <span class="badge w-100 bg-<?= esc($color) ?>"><?= esc($label) ?></span>
                            </div>
                        </div>
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
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control"
                               value="<?= esc($cart['user']['name'] ?? '-') ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control"
                               value="<?= esc($cart['user']['phone'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control"
                               value="<?= esc($cart['user']['email'] ?? '-') ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" class="form-control"
                               value="<?= !empty($cart['user']['is_active']) ? 'Ativo' : 'Inativo' ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Verificado</label>
                        <input type="text" class="form-control"
                               value="<?= !empty($cart['user']['is_verified']) ? 'Sim' : 'Não' ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Grupo de Cliente</label>
                        <input type="text" class="form-control"
                               value="<?= esc($cart['user']['group_name'] ?? '-') ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDuplicateCart" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
             x-data="{
                 form: { cart_id: '', include_items: true, include_customer: false, note: '' },
                 async submit() {
                     try {
                         const res = await fetch('/admin/sales/carts/duplicate', {
                             method: 'POST',
                             headers: { 'Content-Type': 'application/json' },
                             body: JSON.stringify(this.form)
                         });
                         const data = await res.json();
                         if (data.status === 'success') {
                             showToast('Carrinho duplicado com sucesso.', 'success');
                             bootstrap.Modal.getInstance($el.closest('.modal')).hide();
                             document.dispatchEvent(new CustomEvent('cart-updated'));
                         } else {
                             showToast(data.message || 'Erro ao duplicar carrinho.', 'error');
                         }
                     } catch {
                         showToast('Erro de comunicação com o servidor.', 'error');
                     }
                 }
             }"
             x-init="$el.addEventListener('cart-duplicate', e => form.cart_id = e.detail.id)">
            <div class="modal-header">
                <h5 class="modal-title">Duplicar Carrinho</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submit()">
                    <p class="text-muted mb-3">Selecione as opções desejadas antes de duplicar.</p>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="includeItems" x-model="form.include_items">
                        <label class="form-check-label" for="includeItems">Incluir produtos do carrinho original</label>
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
