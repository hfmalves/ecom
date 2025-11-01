<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="card-title">Lista de Devoluções</h4>
                    </div>
                    <div class="col-sm-8 text-sm-end">
                        <button type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#modalCreateRma">
                            <i class="mdi mdi-plus me-1"></i> Nova RMA
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap w-100 align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>RMA</th>
                            <th>Encomenda</th>
                            <th>Cliente</th>
                            <th class="text-end">Qtd. Devolvida</th>
                            <th class="text-end">Reembolso (€)</th>
                            <th>Motivo</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($returns)): ?>
                            <?php foreach ($returns as $r): ?>
                                <?php
                                $totalQty = 0;
                                $totalRefund = 0;
                                if (!empty($r['items'])) {
                                    foreach ($r['items'] as $item) {
                                        $totalQty += $item['qty_returned'] ?? 0;
                                        $totalRefund += $item['refund_amount'] ?? 0;
                                    }
                                }

                                $status = $r['status'] ?? 'requested';
                                $labels = [
                                    'requested' => 'Pedido',
                                    'approved'  => 'Aprovado',
                                    'rejected'  => 'Rejeitado',
                                    'refunded'  => 'Reembolsado',
                                    'completed' => 'Concluído',
                                ];
                                $colors = [
                                    'requested' => 'warning',
                                    'approved'  => 'success',
                                    'rejected'  => 'danger',
                                    'refunded'  => 'info',
                                    'completed' => 'primary',
                                ];
                                ?>
                                <tr>
                                    <td><strong><?= esc($r['rma_number'] ?? 'RMA-'.$r['id']) ?></strong></td>

                                    <td>
                                        #<?= esc($r['order']['id'] ?? '-') ?><br>
                                        <small class="text-muted">
                                            <?= number_format($r['order']['grand_total'] ?? 0, 2, ',', ' ') ?> €
                                        </small>
                                    </td>

                                    <td>
                                        <?= esc($r['customer']['name'] ?? 'Sem cliente') ?><br>
                                        <small class="text-muted"><?= esc($r['customer']['email'] ?? '') ?></small>
                                    </td>

                                    <td class="text-end"><?= $totalQty ?></td>

                                    <td class="text-end"><?= number_format($totalRefund, 2, ',', ' ') ?> €</td>

                                    <td><?= esc($r['reason'] ?? '-') ?></td>

                                    <td>
                                        <span class="badge bg-<?= $colors[$status] ?? 'light' ?> w-100">
                                            <?= esc($labels[$status] ?? ucfirst($status)) ?>
                                        </span>
                                    </td>

                                    <td><?= !empty($r['created_at']) ? date('d/m/Y H:i', strtotime($r['created_at'])) : '-' ?></td>

                                    <td class="text-center">
                                        <a href="<?= base_url('admin/sales/returns/edit//'.$r['id']) ?>"
                                           class="btn btn-sm btn-light text-primary" title="Ver detalhes">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Botão -->
<button type="button" class="btn btn-primary"
        data-bs-toggle="modal" data-bs-target="#modalCreateRma">
    <i class="mdi mdi-plus me-1"></i> Nova RMA
</button>

<!-- Modal Nova RMA -->
<div id="modalCreateRma" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"
             x-data="formHandler('<?= base_url('admin/sales/returns/store') ?>', {
                 order_id: '',
                 resolution: '',
                 reason: '',
                 notes: '',
                 <?= csrf_token() ?>: '<?= csrf_hash() ?>'
             })">
            <div class="modal-header">
                <h5 class="modal-title">Nova Devolução (RMA)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <!-- Encomenda -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Encomenda</label>
                            <select
                                    class="form-select"
                                    id="orderSelectRma"
                                    x-model="form.order_id"
                                    x-init="
                                    $nextTick(() => {
                                        const el = $el;
                                        $(el).select2({
                                            dropdownParent: $('#modalCreateRma'),
                                            width: '100%',
                                            placeholder: '-- Selecionar Encomenda --',
                                            allowClear: true
                                        }).on('change', e => form.order_id = e.target.value);
                                    })
                                "
                            >
                                <option value="">-- Selecionar Encomenda --</option>
                                <?php foreach ($orders as $o): ?>
                                    <?php if ($o['status'] === 'completed'): ?>
                                        <option value="<?= esc($o['id']) ?>">
                                            #<?= esc($o['id']) ?> — <?= esc($o['customer']['name']) ?>
                                        </option>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Resolução</label>
                            <select class="form-select" x-model="form.resolution">
                                <option value="">-- Selecionar --</option>
                                <option value="refund">Reembolso</option>
                                <option value="replacement">Substituição</option>
                                <option value="store_credit">Crédito em Loja</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea class="form-control" x-model="form.reason"
                                  placeholder="Descreve o motivo da devolução..." rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas Internas (opcional)</label>
                        <textarea class="form-control" x-model="form.notes"
                                  placeholder="Observações internas, visíveis apenas pela equipa..." rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" :disabled="loading">
                        <span x-show="!loading">Criar RMA</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A criar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
