<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
RMA #<?= esc($return['rma_number']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-lg-12 d-flex align-items-center justify-content-between">
        <div>
            <h5 class="mb-2 card-title">Detalhes da Devolução</h5>
            <p class="text-muted mb-0">Consulta e atualiza as informações desta RMA.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/sales/returns') ?>" class="btn btn-secondary">
                <i class="mdi mdi-arrow-left"></i> Voltar à Lista
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Coluna principal -->
    <div class="col-lg-8">
        <!-- Informação Geral -->

        <!-- GESTÃO DE DEVOLUÇÕES -->
        <div
                x-data="{
            available: [
                <?php foreach ($availableItems as $i => $item): ?>
                {
                    id: <?= (int)$item['id'] ?>,
                    name: '<?= esc($item['product_name']) ?>',
                    sku: '<?= esc($item['sku']) ?><?= $item['variant_name'] ? ' - ' . esc($item['variant_name']) : '' ?>',
                    qty_ordered: <?= (int)($item['qty_ordered'] ?? $item['qty'] ?? 0) ?>,
                    qty_available: <?= (int)($item['qty_available'] ?? max(($item['qty_ordered'] ?? $item['qty'] ?? 0) - ($item['qty_returned'] ?? 0), 0)) ?>,
                    price: <?= (float)$item['price'] ?>,
                    qty_to_return: 0,
                    condition: 'new',
                    restocked_qty: 0
                },
                <?php endforeach; ?>
            ],
            returned: [
                <?php foreach ($returnItems as $r): ?>
                <?php $orderItem = array_values(array_filter($items, fn($oi) => $oi['id'] == $r['order_item_id']))[0] ?? null; ?>
                {
                    id: <?= (int)$r['order_item_id'] ?>,
                    name: '<?= addslashes($orderItem['product_name'] ?? 'Produto desconhecido') ?>',
                    sku: '<?= addslashes($orderItem['sku'] ?? '-') ?>',
                    qty_ordered: <?= (int)($orderItem['qty'] ?? 0) ?>,
                    qty_returned: <?= (int)($r['qty_returned'] ?? 0) ?>,
                    refund_amount: '<?= number_format((float)($r['refund_amount'] ?? 0), 2, '.', '') ?>',
                    price: <?= (float)($r['refund_amount'] ?? 0) / max((int)($r['qty_returned'] ?? 1), 1) ?>,
                    condition: '<?= addslashes($r['condition'] ?? 'new') ?>',
                    restocked_qty: <?= ((int)($r['restocked_qty'] ?? 0) === 1 ? 'true' : 'false') ?>
                },
                <?php endforeach; ?>
            ],

            limitQty(index) {
                const item = this.available[index];
                if (item.qty_to_return > item.qty_available) item.qty_to_return = item.qty_available;
                if (item.qty_to_return < 0 || isNaN(item.qty_to_return)) item.qty_to_return = 0;
            },

            async saveSingle(index) {
                const i = this.available[index];
                if (i.qty_to_return <= 0) {
                    showToast('Quantidade inválida.', 'warning');
                    return;
                }

                const refund = (i.qty_to_return * i.price).toFixed(2);
                const payload = [{
                    id: i.id,
                    qty_returned: i.qty_to_return,
                    refund_amount: refund,
                    condition: i.condition,
                    restocked_qty: i.restocked_qty
                }];

                try {
                    const resp = await fetch('<?= base_url('admin/sales/returns/saveItems') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ rma_id: <?= (int)$return['id'] ?>, items: payload })
                    });
                    const data = await resp.json();

                    if (!resp.ok || data.status !== 'success') {
                        showToast(data.message || 'Erro ao guardar devolução.', 'error');
                        return;
                    }

                    showToast(data.message || 'Devolução registada.', 'success');

                    const existing = this.returned.find(r =>
                        r.id === i.id &&
                        r.condition === i.condition &&
                        r.restocked_qty === i.restocked_qty
                    );

                    if (existing) {
                        existing.qty_returned += i.qty_to_return;
                        existing.refund_amount = (existing.qty_returned * i.price).toFixed(2);
                    } else {
                        this.returned.push({
                            id: i.id,
                            name: i.name,
                            sku: i.sku,
                            qty_ordered: i.qty_ordered,
                            qty_returned: i.qty_to_return,
                            refund_amount: refund,
                            price: i.price,
                            condition: i.condition,
                            restocked_qty: i.restocked_qty
                        });
                    }

                    i.qty_available -= i.qty_to_return;
                    i.qty_to_return = 0;
                    i.condition = 'new';
                    i.restocked_qty = 0;
                    this.available = this.available.filter(x => x.qty_available > 0);

                } catch (err) {
                    console.error('Erro de comunicação', err);
                    showToast('Erro de comunicação com o servidor.', 'error');
                }
            },

            async removeFromReturn(index) {
                const item = this.returned[index];
                const existing = this.available.find(i => i.id === item.id);
                if (existing) existing.qty_available += item.qty_returned;
                else this.available.push({
                    id: item.id, name: item.name, sku: item.sku, qty_ordered: item.qty_ordered,
                    qty_available: item.qty_returned, price: item.price, qty_to_return: 0
                });

                try {
                    const resp = await fetch('<?= base_url('admin/sales/returns/removeItems') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ rma_id: <?= (int)$return['id'] ?>, items: [{ id: item.id }] })
                    });
                    const data = await resp.json();

                    if (!resp.ok || data.status !== 'success') {
                        showToast(data.message || 'Erro ao remover devolução.', 'error');
                        return;
                    }

                    showToast(data.message || 'Devolução removida.', 'success');
                    this.returned.splice(index, 1);

                } catch (err) {
                    console.error('Erro', err);
                    showToast('Erro de comunicação com o servidor.', 'error');
                }
            }
            }"
        >
        <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Artigos da Encomenda</h4>
                    <template x-if="available.length > 0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th><th>Produto</th><th>Qtd Encomenda</th><th>Disponível</th><th>Qtd a Devolver</th><th>Condição</th><th>Stock</th><th>Reembolso (€)</th><th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <template x-for="(item, i) in available" :key="item.id">
                                    <tr>
                                        <td x-text="i + 1"></td>
                                        <td><span x-text="item.name"></span><br><small class="text-muted" x-text="item.sku"></small></td>
                                        <td x-text="item.qty_ordered"></td>
                                        <td x-text="item.qty_available"></td>
                                        <td><input type="number" min="0" :max="item.qty_available" class="form-control form-control-sm text-end" x-model.number="item.qty_to_return" @input="limitQty(i)"></td>
                                        <td>
                                            <select
                                                    x-model="item.condition"
                                                    x-init="
                                                        $nextTick(() => {
                                                            const el = $el;
                                                            $(el).select2({
                                                                width: '100%',
                                                                minimumResultsForSearch: Infinity, // esconde a barra de pesquisa
                                                                dropdownParent: $(el).closest('td') // evita problemas em modais
                                                            }).on('change', function () {
                                                                item.condition = $(this).val();
                                                            });
                                                        });
                                                    "
                                                    class="form-select form-select-sm"
                                            >
                                                <option value="new">Novo</option>
                                                <option value="opened">Aberto</option>
                                                <option value="damaged">Danificado</option>
                                                <option value="defective">Defeituoso</option>
                                            </select>
                                        </td>
                                        <td class="text-center"><input type="checkbox"
                                                                       x-model="item.restocked_qty"
                                                                       @change="item.restocked_qty = $event.target.checked ? 1 : 0"
                                                                       :checked="item.restocked_qty == 1"></td>
                                        <td class="text-end"><input type="text" class="form-control form-control-sm text-end" readonly :value="(item.qty_to_return * item.price).toFixed(2)"></td>
                                        <td><button type="button" class="btn btn-sm btn-primary w-100" @click="saveSingle(i)"><i class='mdi mdi-content-save'></i></button></td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <p x-show="!available.length" class="text-muted mb-0">Nenhum artigo disponível para devolução.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Artigos Devolvidos</h4>
                    <template x-if="returned.length > 0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                <tr><th>#</th><th>Produto</th><th>Qtd Encomenda</th><th>Disponível</th><th>Qtd Devolvida</th><th>Condição</th><th>Stock</th><th>Reembolso (€)</th><th></th></tr>
                                </thead>
                                <tbody>
                                <template x-for="(item, i) in returned" :key="'r' + item.id + '-' + i">
                                    <tr>
                                        <td x-text="i + 1"></td>
                                        <td><span x-text="item.name"></span><br><small class="text-muted" x-text="item.sku"></small></td>
                                        <td x-text="item.qty_ordered"></td>
                                        <td x-text="item.qty_available ?? '-'"></td>
                                        <td x-text="item.qty_returned"></td>
                                        <td class="text-center">
                                            <span x-show="item.condition === 'new'" class="badge bg-success w-100">Novo</span>
                                            <span x-show="item.condition === 'opened'" class="badge bg-info w-100 text-dark">Aberto</span>
                                            <span x-show="item.condition === 'damaged'" class="badge bg-danger w-100">Danificado</span>
                                            <span x-show="item.condition === 'defective'" class="badge bg-warning w-100">Defeituoso</span>
                                        </td>
                                        <td class="text-center">
                                            <span x-show="item.restocked_qty == 1" class="badge bg-success w-100">Sim</span>
                                            <span x-show="item.restocked_qty == 0" class="badge bg-secondary w-100">Não</span>
                                        </td>
                                        <td class="text-end"><input type="text" class="form-control form-control-sm text-end" readonly :value="(item.qty_returned * item.price).toFixed(2)"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger w-100" @click="removeFromReturn(i)"><i class='mdi mdi-delete'></i></button></td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <p x-show="!returned.length" class="text-muted mb-0">Nenhum artigo devolvido.</p>
                </div>
            </div>
        </div>

    </div>
    <!-- Coluna lateral -->
    <div class="col-lg-4">

        <!-- Informação da Devolução -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação da Devolução</h4>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Estado Atual</label><br>
                        <?php
                        $status = strtolower($return['status'] ?? 'pending');
                        $labels = [
                            'pending'  => ['Pendente', 'warning'],
                            'approved' => ['Aprovada', 'success'],
                            'rejected' => ['Rejeitada', 'danger'],
                            'received' => ['Recebida', 'primary'],
                            'refunded' => ['Reembolsada', 'info'],
                        ];
                        [$label, $color] = $labels[$status] ?? ['Desconhecido', 'dark'];
                        ?>
                        <span class="badge bg-<?= esc($color) ?> w-100 fs-6 py-2"><?= esc($label) ?></span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Tipo de Resolução</label>
                        <input type="text" class="form-control"
                               value="<?= esc(ucfirst($return['resolution'] ?? '-')) ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Data Criação</label>
                        <input type="text" class="form-control"
                               value="<?= date('d/m/Y H:i', strtotime($return['created_at'])) ?>" readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Motivo</label>
                    <textarea class="form-control" rows="2" readonly><?= esc($return['reason'] ?? '-') ?></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">Notas Internas</label>
                    <textarea class="form-control" rows="2" readonly><?= esc($return['notes'] ?? '-') ?></textarea>
                </div>
            </div>
        </div>
        <div class="card" >
            <div class="card-body">
                <h4 class="card-title mb-3">Atualizar Estado</h4>
                <form x-data="formHandler('<?= base_url('admin/sales/returns/update') ?>', {
                        id: '<?= $return['id'] ?>',
                        status: '',
                        notes: '',
                        notify_client: false,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    })"
                      @submit.prevent="submit()">
                    <div class="mb-3">
                        <label class="form-label">Novo Estado</label>
                        <select class="form-select"
                                x-model="form.status"
                                x-init="
                                $nextTick(() => {
                                    const el = $el;
                                    $(el).select2({
                                        width: '100%',
                                        dropdownParent: $(el).closest('div'),
                                        minimumResultsForSearch: Infinity
                                    })
                                    .val(form.status || '')   // força valor inicial correto
                                    .trigger('change')        // atualiza o select2
                                    .on('change', function () {
                                        form.status = $(this).val();
                                    });
                                });
                                ">
                            <option value="">-- Selecionar --</option>
                            <option value="pending">Pendente</option>
                            <option value="approved">Aprovada</option>
                            <option value="rejected">Rejeitada</option>
                            <option value="received">Recebida</option>
                            <option value="refunded">Reembolsada</option>
                        </select>

                        <small class="text-danger" x-show="errors.status" x-text="errors.status"></small>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas Internas</label>
                        <textarea class="form-control"
                                  x-model="form.notes"
                                  rows="2"
                                  placeholder="Regista observações internas..."></textarea>
                        <small class="text-danger" x-show="errors.notes" x-text="errors.notes"></small>

                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox"
                               class="form-check-input"
                               id="notifyClient"
                               x-model="form.notify_client">
                        <label for="notifyClient" class="form-check-label">
                            Notificar Cliente
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                        <template x-if="loading">
                            <span><i class='mdi mdi-loading mdi-spin me-1'></i> A atualizar...</span>
                        </template>
                        <template x-if="!loading">
                            <span>Atualizar Estado</span>
                        </template>
                    </button>
                </form>

            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação do Cliente</h4>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control"
                               value="<?= esc($return['customer']['first_last'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control"
                               value="<?= esc($return['customer']['email'] ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Contato</label>
                        <input type="text" class="form-control"
                               value="<?= esc($return['customer']['phone'] ?? '-') ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Histórico da Devolução</h4>
                <?php if (!empty($return['history'])): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Ação</th>
                                <th>Estado da Encomenda</th>
                                <th>Notas</th>
                                <th>Utilizador</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($return['history'] as $h): ?>
                                <tr>
                                    <td><?= esc(date('d/m/Y H:i', strtotime($h['created_at']))) ?></td>
                                    <td>
                                        <?php
                                        $labels = [
                                            'item_added'    => ['Artigo adicionado',  'success'],
                                            'item_removed'  => ['Artigo removido',    'danger'],
                                            'status_change' => ['Estado alterado',    'info'],
                                            'comment'       => ['Comentário adicionado', 'secondary'],
                                        ];
                                        [$text, $color] = $labels[$h['status']] ?? [ucfirst($h['status']), 'dark'];
                                        ?>
                                        <span class="badge w-100 bg-<?= esc($color) ?>">
        <?= esc($text) ?>
    </span>
                                    </td>

                                    <td>
                                        <?php
                                        $statusColors = [
                                            'pending'   => 'warning',
                                            'completed' => 'success',
                                            'refunded'  => 'info',
                                            'canceled'  => 'danger',
                                            'approved'  => 'primary',
                                            'rejected'  => 'secondary',
                                        ];
                                        $statusText = ucfirst($h['order_status'] ?? '-');
                                        $statusColor = $statusColors[$h['order_status']] ?? 'dark';
                                        ?>
                                        <span class="badge w-100 bg-<?= esc($statusColor) ?>">
        <?= esc($statusText) ?>
    </span>
                                    </td>

                                    <td><?= esc($h['notes'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        if (!empty($h['handled_by'])) {
                                            $user = model('App\Models\UserModel')->find($h['handled_by']);
                                            echo esc($user['name'] ?? 'Utilizador #' . $h['handled_by']);
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary text-center py-2 mb-0">
                        Sem histórico registado.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
