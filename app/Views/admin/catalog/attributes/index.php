<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row g-3 mb-4">

    <!-- Total de Atributos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Atributos</h6>
                    <i class="mdi mdi-tag-multiple text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?? 0 ?></h3>
                <small class="text-muted">definidos no sistema</small>
            </div>
        </div>
    </div>

    <!-- Atributos Ativos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Atributos Ativos</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active'] ?? 0 ?></h3>
                <small class="text-muted">visíveis no catálogo</small>
            </div>
        </div>
    </div>

    <!-- Atributos Inativos -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Atributos Inativos</h6>
                    <i class="mdi mdi-minus-circle-outline text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['inactive'] ?? 0 ?></h3>
                <small class="text-muted">ocultos do catálogo</small>
            </div>
        </div>
    </div>

    <!-- Atributos Filtráveis -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Filtráveis</h6>
                    <i class="mdi mdi-filter-variant text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['filterable'] ?? 0 ?></h3>
                <small class="text-muted">usados em filtros de loja</small>
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
                                <h4 class="card-title">Lista de atributos</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" x-data="systemModal()"
                                    @click="open('#formAttribute', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>

                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                    <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Obrigatório</th>
                        <th>Filtrável</th>
                        <th>Ativo</th>
                        <th class="text-center">Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $typeLabels = [
                            'text'        => 'Texto',
                            'select'      => 'Seleção',
                            'multiselect' => 'Seleção múltipla',
                            'boolean'     => 'Sim/Não',
                            'number'      => 'Número',
                    ];
                    ?>
                    <?php if (!empty($atributes)): ?>
                        <?php foreach ($atributes as $atribute): ?>
                            <tr>
                                <td><?= esc($atribute['code']) ?></td>
                                <td><?= esc($atribute['name']) ?></td>
                                <td><?= $typeLabels[$atribute['type']] ?? ucfirst($atribute['type']) ?></td>

                                <td class="text-center">
                                    <?= $atribute['is_required'] ? '<span class="badge bg-success w-100">Sim</span>' : '<span class="badge bg-secondary">Não</span>' ?>
                                </td>
                                <td class="text-center">
                                    <?= $atribute['is_filterable'] ? '<span class="badge bg-success w-100">Sim</span>' : '<span class="badge bg-secondary">Não</span>' ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($atribute['is_active']): ?>
                                        <span class="badge bg-success w-100">Sim</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary w-100">Não</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="<?= base_url('admin/catalog/attributes/edit/' . $atribute['id']) ?>"
                                                   class="btn btn-sm btn-light text-info" title="Editar atributo">
                                                    <i class="mdi mdi-pencil-outline"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Nenhum atributo encontrado</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formAttribute" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Atributo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/attributes/store',
                  {
                    code: '',
                    name: '',
                    type: 'text',
                    is_required: '0',
                    is_filterable: '0',
                    is_active: '1',
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

                // inicializar todos os select2 do modal
                $nextTick(() => {
                    $('#formAttribute select.select2').each(function() {
                        const el = $(this);
                        el.select2({
                            width: '100%',
                            placeholder: '-- Selecionar --',
                            dropdownParent: $('#formAttribute')
                        });

                        const field = el.attr('name');
                        el.val(form[field]).trigger('change.select2');

                        el.on('change', function () {
                            form[field] = $(this).val();
                        });

                        $watch('form.' + field, (val) => {
                            setTimeout(() => el.val(val).trigger('change.select2'), 10);
                        });
                    });
                });
             ">
            <form @submit.prevent="submit()">

                <!-- code -->
                <div class="mb-3">
                    <label class="form-label">Código *</label>
                    <input type="text" class="form-control" name="code" x-model="form.code">
                    <div class="text-danger small" x-text="errors.code"></div>
                </div>

                <!-- name -->
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <!-- type -->
                <div class="mb-3">
                    <label class="form-label">Tipo *</label>
                    <select class="form-select select2" name="type" x-model="form.type">
                        <option value="">-- Selecionar --</option>
                        <option value="text">Texto</option>
                        <option value="number">Número</option>
                        <option value="select">Seleção</option>
                        <option value="multiselect">Seleção múltipla</option>
                        <option value="boolean">Sim/Não</option>
                    </select>
                    <div class="text-danger small" x-text="errors.type"></div>
                </div>

                <!-- is_required -->
                <div class="mb-3">
                    <label class="form-label">Obrigatório *</label>
                    <select class="form-select select2" name="is_required" x-model="form.is_required">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_required"></div>
                </div>

                <!-- is_filterable -->
                <div class="mb-3">
                    <label class="form-label">Filtrável *</label>
                    <select class="form-select select2" name="is_filterable" x-model="form.is_filterable">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_filterable"></div>
                </div>

                <!-- is_active -->
                <div class="mb-3">
                    <label class="form-label">Estado *</label>
                    <select class="form-select select2" name="is_active" x-model="form.is_active">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    <div class="text-danger small" x-text="errors.is_active"></div>
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
