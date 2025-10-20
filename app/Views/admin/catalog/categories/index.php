<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div class="row g-3 mb-4">

    <!-- Total de Categorias -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Total de Categorias</h6>
                    <i class="mdi mdi-shape text-primary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['total'] ?></h3>
                <small class="text-muted">no sistema</small>
            </div>
        </div>
    </div>

    <!-- Categorias Ativas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Categorias Ativas</h6>
                    <i class="mdi mdi-check-decagram text-success fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['active'] ?></h3>
                <small class="text-muted">visíveis no catálogo</small>
            </div>
        </div>
    </div>

    <!-- Categorias Inativas -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Categorias Inativas</h6>
                    <i class="mdi mdi-minus-circle-outline text-secondary fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['inactive'] ?></h3>
                <small class="text-muted">ocultas no catálogo</small>
            </div>
        </div>
    </div>

    <!-- Produtos Associados -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="text-muted">Produtos Associados</h6>
                    <i class="mdi mdi-package-variant text-info fs-4"></i>
                </div>
                <h3 class="fw-semibold mb-0"><?= $kpi['products'] ?></h3>
                <small class="text-muted">distribuídos por categorias</small>
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
                                <h4 class="card-title">Lista de Categorias</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 offset-sm-6">
                        <div class="text-sm-end">

                            <?php if ($parentId > 0): ?>
                                <a href="<?= base_url('admin/catalog/categories?parent_id=' . $parentParentId) ?>"
                                   class="btn btn-light ">
                                    <i class="mdi mdi-arrow-left"></i> Voltar
                                </a>
                            <?php endif; ?>

                            <button type="button" x-data="systemModal()"
                                    @click="open('#formCategory', 'md')"
                                    class="btn btn-primary">
                                <i class="bx bx-plus-circle me-1"></i> Adicionar
                            </button>
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive"
                         x-data="{
                            open: {},
                            toggle(id) {
                                this.open[id] = !this.open[id];
                            }
                         }">
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Estado</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Slug</th>
                                <th>Qtd Artigos</th>
                                <th>Ativar</th>
                                <th>Actualizado em</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Verifica se existem categorias neste nível
                            $hasCategories = false;
                            foreach ($tree as $category) {
                                if ((int)($category['parent_id'] ?? 0) === (int)$parentId) {
                                    $hasCategories = true;
                                    break;
                                }
                            }
                            ?>
                            <?php if ($hasCategories): ?>
                                <?php foreach ($tree as $category): ?>
                                    <?php if ((int)($category['parent_id'] ?? 0) !== (int)$parentId) continue; ?>

                                    <tr class="align-middle" data-id="<?= $category['id'] ?>">
                                        <td><i class="bx bx-move-vertical"></i></td>
                                        <td>
                                            <?= $category['is_active']
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-secondary w-100">Inativo</span>' ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($category['image'])): ?>
                                                <img src="<?= base_url('uploads/categories/' . $category['image']) ?>"
                                                     alt="<?= esc($category['name']) ?>"
                                                     class="rounded" width="40" height="40">
                                            <?php else: ?>
                                                <div class="bg-light text-muted text-center rounded"
                                                     style="width:40px;height:40px;line-height:40px;">
                                                    <i class="mdi mdi-image-off"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($category['name']) ?></td>
                                        <td><?= esc($category['slug']) ?></td>
                                        <td><span class="badge bg-dark"><?= esc($category['products_count'] ?? 0) ?></span></td>
                                        <td class="text-center"
                                            x-data="{
                                            form: { id: '<?= $category['id'] ?>', <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                                            loading: false,
                                            async submit(event) {
                                                this.loading = true;

                                                // vê se o checkbox está marcado
                                                const checked = event.target.checked;

                                                const url = checked
                                                    ? '/admin/catalog/categories/enabled'
                                                    : '/admin/catalog/categories/disable';

                                                try {
                                                    const response = await fetch(url, {
                                                        method: 'POST',
                                                        headers: { 'Content-Type': 'application/json' },
                                                        body: JSON.stringify(this.form)
                                                    });

                                                    const data = await response.json();
                                                    this.loading = false;

                                                    const type = data.status === 'success' ? 'success' : 'error';
                                                    showToast(data.message, type);
                                                } catch (err) {
                                                    this.loading = false;
                                                    console.error(err);
                                                }
                                            }
                                        }"
                                        >
                                            <input
                                                    type="checkbox"
                                                    id="toggle_<?= $category['id'] ?>"
                                                    <?= $category['is_active'] ? 'checked' : '' ?>
                                                    @change="form.id = '<?= $category['id'] ?>'; submit($event)"
                                                    switch="none"
                                            >
                                            <label
                                                    for="toggle_<?= $category['id'] ?>"
                                                    data-on-label="Ativo"
                                                    data-off-label="Inativo">
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <?= $category['updated_at'] ?>
                                        </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                        <li>
                                                            <a href="<?= base_url('admin/catalog/categories?parent_id=' . $category['id']) ?>"
                                                               class="btn btn-sm btn-light text-primary" title="Abrir subcategorias">
                                                                <i class="mdi mdi-eye-outline"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= base_url('admin/catalog/categories/edit/' . $category['id']) ?>"
                                                               class="btn btn-sm btn-light text-info" title="Editar categoria">
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
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="mdi mdi-folder-outline fs-3 d-block mb-2"></i>
                                        <strong>Sem categorias neste nível</strong><br>
                                        <small>Use o botão <b>“Adicionar”</b> para criar uma nova categoria.</small>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div id="formCategory" class="d-none">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Criar Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/catalog/categories/store', {
                    id: '',
                    name: '',
                    parent_id: '',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                }, { resetOnSuccess: true })
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
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <!-- Categoria Pai -->
                <div class="mb-3">
                    <label class="form-label">Categoria Pai</label>
                    <div class="border rounded p-2" style="max-height: 350px; overflow-y: auto;">

                        <!-- Categoria principal -->
                        <div class="mb-2">
                            <label class="d-flex align-items-center gap-2">
                                <input type="radio" name="parent_id" x-model="form.parent_id"
                                       value="0" <?= $parentId === 0 ? 'checked' : '' ?>
                                       class="form-check-input">
                                <strong>Categoria Principal</strong>
                            </label>
                        </div>

                        <!-- Lista achatada de todas as categorias -->
                        <?php
                        function flattenTree($categories, $level = 0, &$flat = [])
                        {
                            foreach ($categories as $c) {
                                $flat[] = [
                                    'id' => $c['id'],
                                    'name' => str_repeat('— ', $level) . $c['name']
                                ];
                                if (!empty($c['children'])) {
                                    flattenTree($c['children'], $level + 1, $flat);
                                }
                            }
                            return $flat;
                        }

                        $flat = [];
                        flattenTree($fullTree, 0, $flat);

                        foreach ($flat as $cat): ?>
                            <div class="mb-1">
                                <label class="d-flex align-items-center gap-2">
                                    <input type="radio" name="parent_id" x-model="form.parent_id"
                                           value="<?= $cat['id'] ?>"
                                           class="form-check-input"
                                        <?= ($parentId == $cat['id']) ? 'checked' : '' ?>>
                                    <span><?= esc($cat['name']) ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-danger small" x-text="errors.parent_id"></div>
                </div>

                <!-- Botões -->
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        new Sortable(tbody, {
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: async () => {
                const ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                    .map(tr => tr.dataset.id)
                    .filter(Boolean);

                if (!ids.length) return;

                console.log('🔥 Nova ordem:', ids);

                try {
                    const response = await fetch('<?= base_url('admin/catalog/categories/reorder') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            parent_id: <?= $parentId ?: 'null' ?>,
                            ids: ids
                        })
                    });

                    const data = await response.json();

                    // ✅ feedback imediato ao utilizador
                    if (data.message) {
                        const type = data.status === 'success' ? 'success' : 'error';
                        showToast(data.message, type);
                    }

                } catch (err) {
                    console.error('Erro ao reordenar categorias:', err);
                    showToast('Erro ao guardar nova ordem.', 'error');
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>
