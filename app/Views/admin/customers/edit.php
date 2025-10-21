<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Gestão de Cliente
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Gestão de Cliente</h5>
                <p class="text-muted mb-0">Editar informações e preferências do cliente</p>
            </div>
            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('customerForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>
        </div>
    </div>
</div>

<form id="customerForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/customers/update') ?>',
          {
              id: '<?= $customer['id'] ?>',
              name: '<?= esc($customer['name']) ?>',
              email: '<?= esc($customer['email']) ?>',
              phone: '<?= esc($customer['phone']) ?>',
              is_active: '<?= $customer['is_active'] ?>',
              is_verified: '<?= $customer['is_verified'] ?>',
              login_2step: '<?= $customer['login_2step'] ?>',
              group_id: '<?= $customer['group_id'] ?>',
              date_of_birth: '<?= $customer['date_of_birth'] ?>',
              preferred_language: '<?= $customer['preferred_language'] ?>',
              preferred_currency: '<?= $customer['preferred_currency'] ?>',
              loyalty_points: '<?= $customer['loyalty_points'] ?>',
              newsletter_optin: '<?= $customer['newsletter_optin'] ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Compras</h4>
                    <p class="card-title-desc">Últimos registos de compras do cliente</p>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Status</th>
                                <th class="text-center">Itens</th>
                                <th class="text-end">Impostos</th>
                                <th class="text-end">Desconto</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Data</th>
                                <th class="text-end" style="width: 90px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= esc($order['id']) ?></td>
                                        <td class="text-center">
                                            <?php
                                            $statusClass = match ($order['status']) {
                                                'pending'    => 'bg-warning text-dark',
                                                'processing' => 'bg-info text-dark',
                                                'completed'  => 'bg-success',
                                                'canceled'   => 'bg-secondary',
                                                'refunded'   => 'bg-primary',
                                                'failed'     => 'bg-danger',
                                                default      => 'bg-light text-dark',
                                            };
                                            ?>
                                            <span class="badge <?= $statusClass ?> w-100">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?= number_format($order['total_items'], 0, ',', '.') ?></td>
                                        <td class="text-end"><?= number_format($order['total_tax'], 2, ',', '.') ?> €</td>
                                        <td class="text-end">-<?= number_format($order['total_discount'], 2, ',', '.') ?> €</td>
                                        <td class="text-end fw-semibold "><?= number_format($order['grand_total'], 2, ',', '.') ?> €</td>
                                        <td class="text-center"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                        <td class="text-end">
                                            <ul class="list-unstyled hstack gap-1 mb-0 justify-content-end">
                                                <li>
                                                    <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>"
                                                       class="btn btn-sm btn-light text-info"
                                                       title="Ver detalhes da encomenda">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Sem registos</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Pagamentos</h4>
                    <p class="card-title-desc">Últimos registos de pagamentos do cliente</p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th class="text-center">Estado</th>
                                <th>Método</th>
                                <th>Referência</th>
                                <th>Transação</th>
                                <th class="text-end">Valor</th>
                                <th class="text-center">Moeda</th>
                                <th class="text-center">Data</th>
                                <th class="text-end" style="width: 90px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($payments)): ?>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= esc($payment['id']) ?></td>
                                        <td class="text-center">
                                            <?php
                                            $statusClass = match ($payment['status']) {
                                                'pending'  => 'bg-warning text-dark',
                                                'paid'     => 'bg-success',
                                                'failed'   => 'bg-danger',
                                                'refunded' => 'bg-primary',
                                                'partial'  => 'bg-info text-dark',
                                                default    => 'bg-light text-dark',
                                            };
                                            ?>
                                            <span class="badge <?= $statusClass ?> w-100">
                                                <?= ucfirst($payment['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= esc($payment['method']) ?: '<span class="text-muted">—</span>' ?></td>
                                        <td><?= esc($payment['reference']) ?: '<span class="text-muted">—</span>' ?></td>
                                        <td><?= esc($payment['transaction_id']) ?: '<span class="text-muted">—</span>' ?></td>

                                        <td class="text-end fw-semibold">
                                            <?= number_format($payment['amount'], 2, ',', '.') ?> €
                                        </td>
                                        <td class="text-center"><?= esc($payment['currency'] ?? 'EUR') ?></td>
                                        <td class="text-center">
                                            <?= !empty($payment['paid_at'])
                                                ? date('d/m/Y', strtotime($payment['paid_at']))
                                                : '<span class="text-muted">—</span>' ?>
                                        </td>
                                        <td class="text-end">
                                            <ul class="list-unstyled hstack gap-1 mb-0 justify-content-end">
                                                <li>
                                                    <a href="<?= base_url('admin/payments/view/' . $payment['id']) ?>"
                                                       class="btn btn-sm btn-light text-info"
                                                       title="Ver detalhes do pagamento">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Sem registos</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Envios</h4>
                    <p class="card-title-desc">Últimos registos de envios do cliente</p>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Transportadora</th>
                                <th>Nº de Rastreamento</th>
                                <th class="text-center">Enviada em</th>
                                <th class="text-center">Criada em</th>
                                <th class="text-end" style="width: 90px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($shipments)): ?>
                                <?php foreach ($shipments as $shipment): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= esc($shipment['id']) ?></td>
                                        <td><?= esc($shipment['carrier']) ?: '<span class="text-muted">—</span>' ?></td>
                                        <td><?= esc($shipment['tracking_number']) ?: '<span class="text-muted">—</span>' ?></td>
                                        <td class="text-center">
                                            <?= !empty($shipment['shipped_at'])
                                                ? date('d/m/Y', strtotime($shipment['shipped_at']))
                                                : '<span class="text-muted">—</span>' ?>
                                        </td>
                                        <td class="text-center">
                                            <?= !empty($shipment['created_at'])
                                                ? date('d/m/Y', strtotime($shipment['created_at']))
                                                : '<span class="text-muted">—</span>' ?>
                                        </td>
                                        <td class="text-end">
                                            <ul class="list-unstyled hstack gap-1 mb-0 justify-content-end">
                                                <li>
                                                    <a href="<?= base_url('admin/shipments/view/' . $shipment['id']) ?>"
                                                       class="btn btn-sm btn-light text-info"
                                                       title="Ver detalhes do envio">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Sem registos</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Devoluções</h4>
                    <p class="card-title-desc">Últimos registos de devoluções do cliente</p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th class="text-center">Estado</th>
                                <th>Motivo</th>
                                <th>Resolução</th>
                                <th class="text-end">Valor</th>
                                <th class="text-center">Criado em</th>
                                <th class="text-end" style="width: 90px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($returns)): ?>
                                <?php foreach ($returns as $return): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= esc($return['id']) ?></td>

                                        <td class="text-center">
                                            <?php
                                            $statusClass = match ($return['status']) {
                                                'pending'   => 'bg-warning text-dark',
                                                'approved'  => 'bg-success',
                                                'rejected'  => 'bg-danger',
                                                'received'  => 'bg-info text-dark',
                                                'refunded'  => 'bg-primary',
                                                default     => 'bg-light text-dark',
                                            };
                                            ?>
                                            <span class="badge <?= $statusClass ?> w-100">
                                    <?= ucfirst($return['status']) ?>
                                </span>
                                        </td>

                                        <td><?= esc($return['reason']) ?: '<span class="text-muted">—</span>' ?></td>
                                        <td><?= esc($return['resolution']) ?: '<span class="text-muted">—</span>' ?></td>

                                        <td class="text-end fw-semibold">
                                            <?= number_format($return['refund_amount'], 2, ',', '.') ?> €
                                        </td>

                                        <td class="text-center">
                                            <?= !empty($return['created_at'])
                                                ? date('d/m/Y', strtotime($return['created_at']))
                                                : '<span class="text-muted">—</span>' ?>
                                        </td>

                                        <td class="text-end">
                                            <ul class="list-unstyled hstack gap-1 mb-0 justify-content-end">
                                                <li>
                                                    <a href="<?= base_url('admin/returns/view/' . $return['id']) ?>"
                                                       class="btn btn-sm btn-light text-info"
                                                       title="Ver detalhes da devolução">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Sem registos</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Coluna Lateral -->
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informação de Conta</h4>
                    <p class="card-title-desc">Defina o estado e preferências do cliente</p>

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-12 mb-3" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome completo" x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 mb-3" x-data="{ field: 'email' }">
                            <label class="form-label" :for="field">Email</label>
                            <input type="email" class="form-control" :id="field" :name="field"
                                   placeholder="Email do cliente" x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <!-- Telefone -->
                        <div class="col-md-12 mb-3" x-data="{ field: 'phone' }">
                            <label class="form-label" :for="field">Telefone</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Telefone / Telemóvel" x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'is_active' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2" data-minimum-results-for-search="Infinity"
                                    :id="field" :name="field" x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>

                        <!-- Verificado -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'is_verified' }">
                            <label class="form-label" :for="field">Verificado</label>
                            <select class="form-select select2" data-minimum-results-for-search="Infinity"
                                    :id="field" :name="field" x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>

                        <!-- Login 2FA -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'login_2step' }">
                            <label class="form-label" :for="field">2FA</label>
                            <select class="form-select select2" data-minimum-results-for-search="Infinity"
                                    :id="field" :name="field" x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Ativo</option>
                                <option value="0">Desativado</option>
                            </select>
                        </div>

                        <!-- Grupo -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'group_id' }">
                            <label class="form-label" :for="field">Grupo</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <?php foreach ($costumers_group ?? [] as $cg): ?>
                                    <option value="<?= $cg['id'] ?>"><?= esc($cg['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Data Nascimento -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'date_of_birth' }">
                            <label class="form-label" :for="field">Data de Nascimento</label>
                            <input type="date" class="form-control" :id="field" :name="field"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>

                        <!-- Newsletter -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'newsletter_optin' }">
                            <label class="form-label" :for="field">Newsletter</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <option value="1">Subscrito</option>
                                <option value="0">Não Subscrito</option>
                            </select>
                        </div>

                        <!-- Pontos de Fidelização -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'loyalty_points' }">
                            <label class="form-label" :for="field">Pontos</label>
                            <input type="number" min="0" class="form-control" :id="field" :name="field"
                                   x-model="form[field]" placeholder="0" :class="{ 'is-invalid': errors[field] }">
                        </div>

                        <!-- Idioma -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'preferred_language' }">
                            <label class="form-label" :for="field">Idioma</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <option value="pt_PT">Português</option>
                                <option value="en_US">Inglês</option>
                                <option value="es_ES">Espanhol</option>
                            </select>
                        </div>

                        <!-- Moeda -->
                        <div class="col-md-6 mb-3" x-data="{ field: 'preferred_currency' }">
                            <label class="form-label" :for="field">Moeda</label>
                            <select class="form-select select2" :id="field" :name="field"
                                    x-model="form[field]" x-init="initSelect2($el)">
                                <option value="EUR">Euro (EUR)</option>
                                <option value="USD">Dólar (USD)</option>
                                <option value="GBP">Libra (GBP)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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
