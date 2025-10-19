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
                                <th style="width: 0px;"></th>
                                <th style="width: 60px;">Estado</th>
                                <th>Nome</th>
                                <th>Slug</th>
                                <th style="width: 100px;">Produtos</th>
                                <th style="width: 120px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tree as $category): ?>
                                    <?php if ((int)($category['parent_id'] ?? 0) !== (int)$parentId) continue; ?>

                                    <tr class="align-middle" data-id="<?= $category['id'] ?>">

                                    <td>
                                            <i class="bx bx-move-vertical"></i>
                                        </td>
                                        <td>
                                            <?= $category['is_active']
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-secondary w-100">Inativo</span>' ?>
                                        </td>

                                        <td><?= esc($category['name']) ?></td>
                                        <td><?= esc($category['slug']) ?></td>
                                        <td><span class="badge bg-dark"><?= esc($category['products_count'] ?? 0) ?></span></td>

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
            ...formHandler('/admin/catalog/categories/store',
              {
                id: '',
                name: '',
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
                if (k !== '<?= csrf_token() ?>') {
                  form[k] = ''
                }
              })
            });
            document.addEventListener('csrf-update', e => {
              form[e.detail.token] = e.detail.hash
            });
         ">

            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
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
