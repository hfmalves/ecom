<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Moedas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-0">Moedas</h4>
                        <p class="text-muted">Gestão das moedas e taxas de câmbio</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <button type="button"
                                x-data="systemModal()"
                                @click="open('#createCurrency', 'md')"
                                class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Símbolo</th>
                            <th>Taxa</th>
                            <th>Padrão</th>
                            <th>Status</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($currencies)): ?>
                            <?php foreach ($currencies as $c): ?>
                                <tr>
                                    <td><?= esc($c['id']) ?></td>
                                    <td><code><?= esc($c['code']) ?></code></td>
                                    <td><?= esc($c['symbol']) ?></td>
                                    <td><?= esc(number_format($c['exchange_rate'], 4)) ?></td>
                                    <td>
                                        <?= $c['is_default'] ? '<span class="badge bg-primary">Sim</span>' : '<span class="badge bg-light text-dark">Não</span>' ?>
                                    </td>
                                    <td>
                                        <?= $c['status'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>' ?>
                                    </td>
                                    <td><?= esc($c['updated_at'] ?? '—') ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown"><i class="mdi mdi-dots-horizontal"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#editCurrency', 'md', {
                                                                id: '<?= $c['id'] ?>',
                                                                code: '<?= $c['code'] ?>',
                                                                symbol: '<?= $c['symbol'] ?>',
                                                                exchange_rate: '<?= $c['exchange_rate'] ?>',
                                                                is_default: '<?= $c['is_default'] ?>',
                                                                status: '<?= $c['status'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-pencil text-success me-1"></i> Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" x-data="systemModal()"
                                                            @click="open('#deleteCurrency', 'md', {
                                                                id: '<?= $c['id'] ?>',
                                                                code: '<?= $c['code'] ?>'
                                                            })"
                                                            class="dropdown-item">
                                                        <i class="mdi mdi-trash-can text-danger me-1"></i> Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center">Nenhuma moeda registada.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Create -->
<!-- Create Currency -->
<div id="createCurrency" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/currencies/store', {
            code: '',
            symbol: '',
            exchange_rate: 1,
            is_default: 0,
            status: 1,
            <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         }, { resetOnSuccess: true })"
         x-init="csrfHandler(form)">
        <div class="modal-header">
            <h5 class="modal-title">Criar Moeda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <form @submit.prevent="submit()">

                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code" placeholder="Ex: EUR">
                    <div class="text-danger small" x-text="errors.code"></div>
                </div>

                <div class="mb-3">
                    <label>Símbolo *</label>
                    <input type="text" class="form-control" x-model="form.symbol" placeholder="Ex: €">
                    <div class="text-danger small" x-text="errors.symbol"></div>
                </div>

                <div class="mb-3">
                    <label>Taxa *</label>
                    <input type="number" step="0.0001" class="form-control" x-model="form.exchange_rate" placeholder="1.0000">
                    <div class="text-danger small" x-text="errors.exchange_rate"></div>
                </div>

                <div class="mb-3">
                    <label>Padrão *</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_default"></div>
                </div>

                <div class="mb-3">
                    <label>Status *</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <div class="text-danger small" x-text="errors.status"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100" :disabled="loading">
                        <span x-show="!loading"><i class="mdi mdi-content-save me-1"></i> Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit -->
<div id="editCurrency" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/currencies/update', {
             id:'', code:'', symbol:'', exchange_rate:1, is_default:0, status:1,
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });">
        <div class="modal-header">
            <h5 class="modal-title">Editar Moeda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <div class="mb-3">
                    <label>Código *</label>
                    <input type="text" class="form-control" x-model="form.code">
                </div>
                <div class="mb-3">
                    <label>Símbolo *</label>
                    <input type="text" class="form-control" x-model="form.symbol">
                </div>
                <div class="mb-3">
                    <label>Taxa *</label>
                    <input type="number" step="0.0001" class="form-control" x-model="form.exchange_rate">
                </div>
                <div class="mb-3">
                    <label>Padrão</label>
                    <select class="form-select" x-model="form.is_default">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select class="form-select" x-model="form.status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete -->
<div id="deleteCurrency" class="d-none">
    <div class="modal-content"
         x-data="formHandler('/admin/settings/currencies/delete', {
             id:'', code:'',
             <?= csrf_token() ?>:'<?= csrf_hash() ?>'
         })"
         x-init="csrfHandler(form); $el.addEventListener('fill-form', e => { Object.assign(form, e.detail); });">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Moeda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar a moeda <strong x-text="form.code"></strong>?</p>
                <div class="modal-footer">
                    <button class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
