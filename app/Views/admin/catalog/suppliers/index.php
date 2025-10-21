<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row g-3">

    <!-- Total de Fornecedores -->
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

    <!-- Fornecedores Ativos -->
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

    <!-- Fornecedores Inativos -->
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

    <!-- Percentagem de Ativos -->
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

    <!-- Fornecedores com API Ligada -->
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

    <!-- Fornecedores de Alto Risco -->
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

    <!-- Países distintos -->
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

    <!-- Moedas distintas -->
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
                                                            onclick="confirmDelete(<?= $supplier['id'] ?>)">
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
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/suppliers/store',
                  {
                    id: '',
                    name: '',
                    legal_number: '',
                    email: '',
                    status: 'active',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                  },
                  { resetOnSuccess: true })
             }"
             x-init="
                $el.addEventListener('fill-form', e => {
                  Object.entries(e.detail).forEach(([k,v]) => { if (k in form) form[k] = v })
                });
                $el.addEventListener('reset-form', () => {
                  Object.keys(form).forEach(k => {
                    if (k !== '<?= csrf_token() ?>') form[k] = ''
                  })
                });
                document.addEventListener('csrf-update', e => {
                  form[e.detail.token] = e.detail.hash
                });
             ">

            <form @submit.prevent="submit()">
                <!-- Nome -->
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <!-- Número Legal -->
                <div class="mb-3">
                    <label class="form-label">Número Legal *</label>
                    <input type="text" class="form-control" name="legal_number" x-model="form.legal_number">
                    <div class="text-danger small" x-text="errors.legal_number"></div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" x-model="form.email">
                    <div class="text-danger small" x-text="errors.email"></div>
                </div>

                <div class="modal-footer mt-3">
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


<?= $this->endSection() ?>
