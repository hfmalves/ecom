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
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação da Devolução</h4>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado Atual</label><br>
                        <?php
                        $status = strtolower($return['status'] ?? 'requested');
                        $labels = [
                            'requested' => ['Pedido', 'warning'],
                            'approved'  => ['Aprovado', 'success'],
                            'rejected'  => ['Rejeitado', 'danger'],
                            'refunded'  => ['Reembolsado', 'info'],
                            'completed' => ['Concluído', 'primary'],
                        ];
                        [$label, $color] = $labels[$status] ?? ['Desconhecido', 'dark'];
                        ?>
                        <span class="badge bg-<?= esc($color) ?> w-100"><?= esc($label) ?></span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo de Resolução</label>
                        <input type="text" class="form-control"
                               value="<?= esc(ucfirst($return['resolution'] ?? '-')) ?>" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data Criação</label>
                        <input type="text" class="form-control"
                               value="<?= date('d/m/Y H:i', strtotime($return['created_at'])) ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Motivo</label>
                    <textarea class="form-control" rows="2" readonly><?= esc($return['reason'] ?? '-') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas Internas</label>
                    <textarea class="form-control" rows="2" readonly><?= esc($return['notes'] ?? '-') ?></textarea>
                </div>
            </div>
        </div>
        <!-- GESTÃO DE DEVOLUÇÕES -->
        <div x-data="{
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
            saveSingle(index) {
                const i = this.available[index];
                if (i.qty_to_return <= 0) return alert('Quantidade inválida.');
                const refund = (i.qty_to_return * i.price).toFixed(2);
                const payload = [{
                    id: i.id,
                    qty_returned: i.qty_to_return,
                    refund_amount: refund,
                    condition: i.condition,
                    restocked_qty: i.restocked_qty
                }];
                fetch('<?= base_url('admin/sales/returns/saveItems') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rma_id: <?= (int)$return['id'] ?>, items: payload })
                }).then(res => res.json()).then(data => {
                    if (data.status !== 'success') return alert('Erro ao guardar devolução.');
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
                }).catch(err => console.error('Erro de comunicação', err));
            },
            removeFromReturn(index) {
                const item = this.returned[index];
                const existing = this.available.find(i => i.id === item.id);
                if (existing) existing.qty_available += item.qty_returned;
                else this.available.push({
                    id: item.id, name: item.name, sku: item.sku, qty_ordered: item.qty_ordered,
                    qty_available: item.qty_returned, price: item.price, qty_to_return: 0
                });
                fetch('<?= base_url('admin/sales/returns/removeItems') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ rma_id: <?= (int)$return['id'] ?>, items: [{ id: item.id }] })
                }).then(res => res.json()).then(data => {
                    if (data.status !== 'success') alert('Erro ao remover devolução.');
                }).catch(err => console.error('Erro', err));
                this.returned.splice(index, 1);
            }
        }">
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
                                        <td><select x-model="item.condition" class="form-select form-select-sm"><option value="new">Novo</option><option value="opened">Aberto</option><option value="damaged">Danificado</option><option value="defective">Defeituoso</option></select></td>
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
        <!-- Cliente -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Informação do Cliente</h4>
                <div class="mb-2">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control"
                           value="<?= esc($return['customer']['name'] ?? '-') ?>" readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control"
                           value="<?= esc($return['customer']['email'] ?? '-') ?>" readonly>
                </div>
            </div>
        </div>

        <!-- Atualizar Estado -->
        <div class="card"
             x-data="{
                form: {
                    id: '<?= $return['id'] ?>',
                    status: '<?= strtolower($return['status'] ?? 'requested') ?>',
                    notes: '',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                async submit() {
                    try {
                        const res = await fetch('<?= base_url('admin/sales/returns/updateStatus') ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.form)
                        });
                        const data = await res.json();
                        if (data.status === 'success') {
                            showToast('Estado atualizado com sucesso.', 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showToast(data.message || 'Erro ao atualizar estado.', 'error');
                        }
                    } catch (e) {
                        showToast('Falha de comunicação com o servidor.', 'error');
                    }
                }
             }">
            <div class="card-body">
                <h4 class="card-title mb-3">Atualizar Estado</h4>
                <form @submit.prevent="submit()">
                    <div class="mb-3">
                        <label class="form-label">Novo Estado</label>
                        <select class="form-select" x-model="form.status">
                            <option value="">-- Selecionar --</option>
                            <option value="requested">Pedido</option>
                            <option value="approved">Aprovado</option>
                            <option value="rejected">Rejeitado</option>
                            <option value="refunded">Reembolsado</option>
                            <option value="completed">Concluído</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas Internas</label>
                        <textarea class="form-control" x-model="form.notes" rows="2"
                                  placeholder="Regista observações internas..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        Atualizar Estado
                    </button>
                </form>
            </div>
        </div>

        <!-- Histórico -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Histórico da Devolução</h4>
                <?php if (!empty($return['history'])): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Estado</th>
                                <th>Notas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($return['history'] as $h): ?>
                                <tr>
                                    <td><?= esc(date('d/m/Y H:i', strtotime($h['created_at']))) ?></td>
                                    <td><?= ucfirst(esc($h['status'])) ?></td>
                                    <td><?= esc($h['notes'] ?? '-') ?></td>
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
