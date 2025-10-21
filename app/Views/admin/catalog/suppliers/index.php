<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row g-3">
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Fornecedores</h6>
                    <i class="mdi mdi-factory text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">registados no sistema</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Ativos</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['ativos'] ?? 0 ?></h3>
                <small class="text-muted">disponíveis para compras</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Inativos</h6>
                    <i class="mdi mdi-close-octagon text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['inativos'] ?? 0 ?></h3>
                <small class="text-muted">não operacionais</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">% Ativos</h6>
                    <i class="mdi mdi-chart-pie text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['ativosPct'] ?? 0 ?>%</h3>
                <small class="text-muted">taxa de atividade</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Integrações API</h6>
                    <i class="mdi mdi-cloud-sync text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['apiLigados'] ?? 0 ?></h3>
                <small class="text-muted">fornecedores com ligação ativa</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Alto Risco</h6>
                    <i class="mdi mdi-alert-octagram text-danger fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['altoRisco'] ?? 0 ?></h3>
                <small class="text-muted">fornecedores com risco elevado</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Países</h6>
                    <i class="mdi mdi-earth text-warning fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['paises'] ?? 0 ?></h3>
                <small class="text-muted">origens distintas</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Moedas</h6>
                    <i class="mdi mdi-currency-eur text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['moedas'] ?? 0 ?></h3>
                <small class="text-muted">moedas distintas</small>
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
                                <h4 class="card-title">Lista de Fornecedores</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formSupplier', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Pessoa de Contacto</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>País</th>
                                <th>Tipo</th>
                                <th>Risco</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($suppliers as $supplier): ?>
                                <?php
                                // Traduções e estilos coerentes
                                $tipo = match (strtolower($supplier['type'])) {
                                    'manufacturer' => 'Fabricante',
                                    'distributor'  => 'Distribuidor',
                                    'service'      => 'Serviço',
                                    'other'        => 'Outro',
                                    default        => 'Desconhecido',
                                };

                                $riscoLabel = match (strtolower($supplier['risk_level'])) {
                                    'high'   => 'Alto',
                                    'medium' => 'Médio',
                                    'low'    => 'Baixo',
                                    default  => '—',
                                };

                                $riskColor = match (strtolower($supplier['risk_level'])) {
                                    'high'   => 'danger',
                                    'medium' => 'warning',
                                    'low'    => 'success',
                                    default  => 'secondary',
                                };

                                $statusLabel = $supplier['status'] === 'active' ? 'Ativo' : 'Inativo';
                                $statusColor = $supplier['status'] === 'active' ? 'success' : 'secondary';
                                ?>
                                <tr>
                                    <td><strong><?= esc($supplier['code']) ?></strong></td>
                                    <td><?= esc($supplier['name']) ?></td>
                                    <td>
                                        <?php
                                        $parts = explode(' ', trim($supplier['contact_person']));
                                        $shortName = $parts[0] ?? '';
                                        if (count($parts) > 1) $shortName .= ' ' . end($parts);
                                        ?>
                                        <?= esc($shortName) ?>
                                    </td>
                                    <td><?= esc($supplier['email']) ?></td>
                                    <td><?= esc($supplier['phone']) ?></td>
                                    <td><?= esc($supplier['country']) ?></td>
                                    <td><span class="badge bg-info text-white w-100"><?= esc($tipo) ?></span></td>
                                    <td><span class="badge bg-<?= $riskColor ?> text-white w-100"><?= esc(strtoupper($riscoLabel)) ?></span></td>
                                    <td><span class="badge bg-<?= $statusColor ?> text-white w-100"><?= esc($statusLabel) ?></span></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <ul class="list-unstyled hstack gap-1 mb-0">
                                                <li>
                                                    <a href="<?= base_url('admin/catalog/suppliers/edit/' . $supplier['id']) ?>"
                                                       class="btn btn-sm btn-light text-info" title="Editar fornecedor">
                                                        <i class="mdi mdi-pencil-outline"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-sm btn-light text-danger"
                                                            title="Eliminar fornecedor"
                                                            @click="
                                                                window.dispatchEvent(new CustomEvent('supplier-delete', {
                                                                    detail: { id: <?= $supplier['id'] ?>, name: '<?= addslashes($supplier['name']) ?>' }
                                                                }));
                                                                new bootstrap.Modal(document.getElementById('modalDeleteSupplier')).show();
                                                            ">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formSupplier" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Fornecedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/suppliers/store', {
                    id: '',
                    name: '',
                    legal_number: '',
                    vat: '',
                    email: '',
                    phone: '',
                    contact_person: '',
                    status: 'active',
                    type: 'manufacturer',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                }, { resetOnSuccess: true })
             }"
             x-init="csrfHandler(form)">
            <form @submit.prevent="submit()">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome *</label>
                        <input type="text" class="form-control" x-model="form.name">
                        <div class="text-danger small" x-text="errors.name"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIF / Número Legal *</label>
                        <input type="text" class="form-control" x-model="form.legal_number">
                        <div class="text-danger small" x-text="errors.legal_number"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">VAT / Internacional</label>
                        <input type="text" class="form-control" x-model="form.vat">
                        <div class="text-danger small" x-text="errors.vat"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" x-model="form.email">
                        <div class="text-danger small" x-text="errors.email"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone *</label>
                        <input type="text" class="form-control" x-model="form.phone">
                        <div class="text-danger small" x-text="errors.phone"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Pessoa de Contacto</label>
                        <input type="text" class="form-control" x-model="form.contact_person">
                        <div class="text-danger small" x-text="errors.contact_person"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"
                         x-data="{ field: 'type' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 placeholder: '-- Selecionar --',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 language: 'pt'
                             });
                             $(el).val(form[field]).trigger('change.select2');
                             $(el).on('change', () => form[field] = $(el).val());
                             $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                         })">
                        <label class="form-label" :for="field">Tipo</label>
                        <select class="form-select select2" x-ref="select" :id="field" :name="field">
                            <option value="manufacturer">Fabricante</option>
                            <option value="distributor">Distribuidor</option>
                            <option value="service">Serviço</option>
                            <option value="other">Outro</option>
                        </select>
                        <template x-if="errors[field]">
                            <small class="text-danger" x-text="errors[field]"></small>
                        </template>
                    </div>
                    <div class="col-md-6"
                         x-data="{ field: 'status' }"
                         x-init="$nextTick(() => {
                             const el = $refs.select;
                             $(el).select2({
                                 width: '100%',
                                 placeholder: '-- Selecionar --',
                                 dropdownParent: $(el).closest('.modal-content'),
                                 language: 'pt'
                             });
                             $(el).val(form[field]).trigger('change.select2');
                             $(el).on('change', () => form[field] = $(el).val());
                             $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                         })">
                        <label class="form-label" :for="field">Estado</label>
                        <select class="form-select select2" x-ref="select" :id="field" :name="field">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                        <template x-if="errors[field]">
                            <small class="text-danger" x-text="errors[field]"></small>
                        </template>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Guardar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A guardar...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDeleteSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"
             x-data="{
                form: { id: '', name: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                loading: false,
                submit() {
                    this.loading = true;
                    fetch('/admin/catalog/suppliers/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.loading = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalDeleteSupplier'));
                        if (modal) modal.hide();

                        if (data.message) {
                            const type = data.status === 'success' ? 'success' : 'error';
                            showToast(data.message, type);
                        }

                        if (data.status === 'success') {
                            setTimeout(() => location.reload(), 800);
                        }
                    })
                    .catch(() => this.loading = false);
                }
             }"
             x-init="
                window.addEventListener('supplier-delete', e => {
                    form.id = e.detail.id;
                    form.name = e.detail.name;
                });
             ">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger">Eliminar Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-alert-outline text-danger" style="font-size: 48px;"></i>
                <p class="mt-2">Tem a certeza que quer eliminar este fornecedor?</p>
                <p><strong>Nome:</strong> <span x-text="form.name"></span></p>
            </div>
            <div class="modal-footer">
                <button @click="submit" type="button" class="btn btn-danger" :disabled="loading">
                    <span x-show="!loading">Confirmar</span>
                    <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A eliminar...</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
