<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Envios
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-2 card-title">Detalhes do Envio</h5>
            <p class="text-muted mb-0">Consulta e atualiza as informações deste envio.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/sales/shipments') ?>" class="btn btn-secondary">
                <i class="mdi mdi-arrow-left"></i> Voltar à Lista
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Coluna principal -->
    <div class="col-lg-8">
        <!-- Informação Geral -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação do Envio</h4>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado Atual</label><br>
                        <?php
                        $status = strtolower($shipment['status'] ?? 'pending');
                        $labels = [
                            'pending'    => ['Pendente', 'warning'],
                            'processing' => ['Em processamento', 'info'],
                            'shipped'    => ['Enviado', 'primary'],
                            'delivered'  => ['Entregue', 'success'],
                            'returned'   => ['Devolvido', 'secondary'],
                            'canceled'   => ['Cancelado', 'danger'],
                        ];
                        [$label, $color] = $labels[$status] ?? ['Desconhecido', 'dark'];
                        ?>
                        <span class="badge bg-<?= esc($color) ?> w-100"><?= esc($label) ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Transportadora</label>
                        <input type="text" class="form-control"
                               value="<?= esc($shipment['carrier'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Código de Tracking</label>
                        <?php if (!empty($shipment['tracking_number'])): ?>
                            <input type="text" class="form-control"
                                   value="<?= esc($shipment['tracking_number'] ?? '-') ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="form-control" value="—" readonly>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Link</label>
                        <?php if (!empty($shipment['tracking_number'])): ?>
                            <a href="<?= esc($shipment['tracking_url'] ?? '#') ?>" target="_blank"
                               class="form-control-plaintext text-primary">
                                <?= esc($shipment['tracking_number']) ?>
                                <i class="mdi mdi-open-in-new ms-1"></i>
                            </a>
                        <?php else: ?>
                            <input type="text" class="form-control" value="—" readonly>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Peso Total</label>
                        <input type="text" class="form-control"
                               value="<?= number_format($shipment['weight'] ?? 0, 2, ',', ' ') ?> kg" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Volume Total</label>
                        <input type="text" class="form-control"
                               value="<?= number_format(($shipment['volume'] ?? 0) * 1000, 0, ',', ' ') ?> L" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Expedido em</label>
                        <input type="text" class="form-control"
                               value="<?= !empty($shipment['shipped_at'])
                                       ? date('d/m/Y H:i', strtotime($shipment['shipped_at']))
                                       : '-' ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Entregue em</label>
                        <input type="text" class="form-control"
                               value="<?= !empty($shipment['delivered_at'])
                                       ? date('d/m/Y H:i', strtotime($shipment['delivered_at']))
                                       : '-' ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Devolvido em</label>
                        <input type="text" class="form-control"
                               value="<?= !empty($shipment['returned_at'])
                                       ? date('d/m/Y H:i', strtotime($shipment['returned_at']))
                                       : '-' ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentários</label>
                    <textarea class="form-control" rows="2" readonly><?= esc($shipment['comments'] ?? '-') ?></textarea>
                </div>
            </div>
        </div>
        <!-- Informação da Encomenda + Morada de Envio lado a lado -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Morada de Faturação</h4>
                        <?php $addr = $shipment['billing_address'] ?? []; ?>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Rua</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['street'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['city'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Código Postal</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['postcode'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">País</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['country'] ?? '-') ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Morada de Envio</h4>
                        <?php $addr = $shipment['shipping_address'] ?? []; ?>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Rua</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['street'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['city'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Código Postal</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['postcode'] ?? '-') ?>" readonly>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">País</label>
                                <input type="text" class="form-control"
                                       value="<?= esc($addr['country'] ?? '-') ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title">Artigos da Encomenda</h4>
                                <p class="card-title-desc">Produtos incluídos neste envio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 offset-sm-6">
                        <div class="text-sm-end">
                            <div class="row mb-2">
                                <input type="text" class="form-control"
                                       value="#<?= esc($shipment['order']['id'] ?? '-') ?>" disabled>
                            </div>
                        </div>
                    </div><!-- end col-->
                </div>

                <?php if (!empty($shipment['items'])): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Produto</th>
                                <th>Variante</th>
                                <th>Qtd</th>
                                <th>Peso</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($shipment['items'] as $idx => $item): ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td><?= esc($item['product_name'] ?? '-') ?></td>
                                    <td><?= esc($item['variant_name'] ?? '-') ?></td>
                                    <td><?= esc($item['qty'] ?? 0) ?></td>
                                    <td><?= number_format($item['weight'] ?? 0, 2, ',', ' ') ?> kg</td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhum artigo associado ao envio.</p>
                <?php endif; ?>
            </div>
        </div>



    </div>

    <!-- Coluna lateral -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação do Cliente</h4>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Entregue em</label>
                        <input type="text" class="form-control"
                               value="<?= esc($shipment['customer']['name'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control"
                               value="<?= esc($shipment['customer']['email'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control"
                               value="<?= esc($shipment['customer']['phone'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Grupo</label>
                        <input type="text" class="form-control"
                               value="<?= esc($shipment['customer']['group_name'] ?? '-') ?>" readonly>
                    </div>
                </div>
            </div>

        </div>
        <div class="card"
             x-data="{
                    status: '<?= strtolower($shipment['status'] ?? 'pending') ?>',
                    form: {
                        id: '<?= $shipment['id'] ?>',
                        carrier: '<?= addslashes($shipment['carrier'] ?? '') ?>',
                        tracking_number: '<?= addslashes($shipment['tracking_number'] ?? '') ?>',
                        status: '<?= strtolower($shipment['status'] ?? 'pending') ?>',
                        comments: '<?= addslashes($shipment['comments'] ?? '') ?>',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    async submit() {
                        try {
                            const res = await fetch('<?= base_url('admin/sales/shipments/update') ?>', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify(this.form)
                            });
                            const data = await res.json();
                            if (data.status === 'success') {
                                showToast('Envio atualizado com sucesso.', 'success');
                                setTimeout(() => location.reload(), 800);
                            } else {
                                showToast(data.message || 'Erro ao atualizar envio.', 'error');
                            }
                        } catch (e) {
                            showToast('Falha de comunicação com o servidor.', 'error');
                        }
                    }
                 }">
            <div class="card-body">
                <h4 class="card-title mb-3">Atualizar Envio</h4>
                <p class="text-muted mb-3">Permite editar apenas transportadora, tracking e estado (caso ainda não esteja concluído).</p>
                <template x-if="!['delivered','returned','canceled'].includes(status)">
                    <form @submit.prevent="submit">

                        <div class="mb-3"
                             x-data="{ field: 'carrier' }"
                             x-init="$nextTick(() => {
                                const el = $refs.select;
                                $(el).select2({
                                    width: '100%',
                                    minimumResultsForSearch: Infinity
                                });
                                $(el).val(form[field]).trigger('change');
                                $(el).on('change', function() {
                                    form[field] = $(this).val();
                                });
                                $watch('form[field]', (val) => {
                                    $(el).val(val).trigger('change.select2');
                                });
                             })">
                            <label class="form-label" :for="field">Transportadora</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :name="field"
                                    x-model="form[field]">
                                <option value="">-- Selecionar --</option>
                                <option value="CTT Expresso">CTT Expresso</option>
                                <option value="UPS">UPS</option>
                                <option value="DHL">DHL</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Código Tracking</label>
                            <input type="text" class="form-control" x-model="form.tracking_number"
                                   placeholder="Ex: CTT-123456">
                        </div>
                        <div class="mb-3"
                             x-data="{ field: 'status' }"
                             x-init="$nextTick(() => {
                                const el = $refs.select;
                                $(el).select2({
                                    width: '100%',
                                    minimumResultsForSearch: Infinity
                                });
                                $(el).val(form[field]).trigger('change');
                                $(el).on('change', function() {
                                    form[field] = $(this).val();
                                });
                                $watch('form[field]', (val) => {
                                    $(el).val(val).trigger('change.select2');
                                });
                             })">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :name="field"
                                    x-model="form[field]">
                                <option value="pending">Pendente</option>
                                <option value="processing">Em Processamento</option>
                                <option value="shipped">Enviado</option>
                                <option value="delivered">Entregue</option>
                                <option value="returned">Devolvido</option>
                                <option value="canceled">Cancelado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comentários</label>
                            <textarea class="form-control" x-model="form.comments" rows="2"
                                      placeholder="Notas internas..."></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <span>Guardar Alterações</span>
                            </button>
                        </div>
                    </form>
                </template>
                <template x-if="['delivered','returned','canceled'].includes(status)">
                    <div class="alert alert-secondary text-center py-3 mb-0">
                        <i class="mdi mdi-lock-outline me-1"></i>
                        Este envio encontra-se finalizado e não pode ser alterado.
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
