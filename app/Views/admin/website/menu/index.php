<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>Menu<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Header -->
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="card-title">Lista de Menus</h4>
                    </div>

                    <div class="col-sm-2 offset-sm-6 text-sm-end">

                        <?php if ($parentId > 0): ?>
                            <a href="<?= base_url('admin/website/menu?parent_id=' . ($breadcrumb[count($breadcrumb)-2]['id'] ?? 0)) ?>"
                               class="btn btn-light ">
                                <i class="mdi mdi-arrow-left"></i> Voltar
                            </a>
                        <?php endif; ?>

                        <button type="button" x-data="systemModal()" @click="open('#formMenu','md')"
                                class="btn btn-primary">
                            <i class="bx bx-plus-circle me-1"></i> Adicionar
                        </button>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="col-sm-12">
                    <div class="table-responsive"
                         x-data="{ open:{}, toggle(id){ this.open[id] = !this.open[id]; } }">

                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Estado</th>
                                <th>Nome</th>
                                <th>URL</th>
                                <th>Tipo</th>
                                <th>Ativar</th>
                                <th>Atualizado em</th>
                                <th>Ações</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($tree)): ?>
                                <?php foreach ($tree as $menu): ?>
                                    <?php if ((int) ($menu['parent_id'] ?? 0) !== (int)$parentId) continue; ?>

                                    <tr class="align-middle" data-id="<?= $menu['id'] ?>">

                                        <td><i class="bx bx-move-vertical"></i></td>

                                        <td>
                                            <?= $menu['is_active']
                                                ? '<span class="badge bg-success w-100">Ativo</span>'
                                                : '<span class="badge bg-secondary w-100">Inativo</span>' ?>
                                        </td>

                                        <td><?= esc($menu['title']) ?></td>
                                        <td><?= esc($menu['url'] ?: '-') ?></td>

                                        <td>
                                            <?= $menu['type'] == 1 ? '<span class="badge bg-info">Mega</span>' : 'Normal' ?>
                                        </td>

                                        <td class="text-center"
                                            x-data="{
                                                form: { id: '<?= $menu['id'] ?>', <?= csrf_token() ?>:'<?= csrf_hash() ?>' },
                                                loading:false,
                                                async submit(ev){
                                                    this.loading=true;

                                                    const url = ev.target.checked
                                                        ? '/admin/website/menu/enable'
                                                        : '/admin/website/menu/disable';

                                                    const response = await fetch(url,{
                                                        method:'POST',
                                                        headers:{'Content-Type':'application/json'},
                                                        body:JSON.stringify(this.form)
                                                    });
                                                    const data = await response.json();
                                                    this.loading=false;

                                                    showToast(data.message, data.status);
                                                }
                                            }">

                                            <input type="checkbox"
                                                   id="toggle_<?= $menu['id'] ?>"
                                                <?= $menu['is_active'] ? 'checked' : '' ?>
                                                   @change="submit($event)" switch="none">

                                            <label for="toggle_<?= $menu['id'] ?>"
                                                   data-on-label="Ativo"
                                                   data-off-label="Inativo"></label>
                                        </td>

                                        <td class="text-center"><?= $menu['updated_at'] ?></td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <ul class="list-unstyled hstack gap-1 mb-0">

                                                    <li>
                                                        <a href="<?= base_url('admin/website/menu?parent_id=' . $menu['id']) ?>"
                                                           class="btn btn-sm btn-light text-primary"
                                                           title="Abrir submenus">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="<?= base_url('admin/website/menu/edit/' . $menu['id']) ?>"
                                                           class="btn btn-sm btn-light text-info"
                                                           title="Editar menu">
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
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="mdi mdi-folder-outline fs-3 d-block mb-2"></i>
                                        <strong>Sem menus neste nível</strong><br>
                                        <small>Use o botão <b>“Adicionar”</b> para criar um novo menu.</small>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL - Criar Menu -->
<div id="formMenu" class="d-none">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Criar Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body"
             x-data="{
                ...formHandler('/admin/website/menu/store', {
                    id:'',
                    title:'',
                    url:'',
                    parent_id:'',
                    type:'0',
                    <?= csrf_token() ?>:'<?= csrf_hash() ?>'
                }, { resetOnSuccess:true })
             }">

            <form @submit.prevent="submit()">

                <!-- Nome -->
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" class="form-control" x-model="form.title">
                    <div class="text-danger small" x-text="errors.title"></div>
                </div>

                <!-- URL -->
                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" class="form-control" x-model="form.url">
                </div>

                <!-- Tipo -->
                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select class="form-select" x-model="form.type">
                        <option value="0">Normal</option>
                        <option value="1">Mega Menu</option>
                    </select>
                </div>

                <!-- Parent -->
                <div class="mb-3">
                    <label class="form-label">Menu Pai</label>
                    <div class="border rounded p-2" style="max-height:350px;overflow-y:auto;">

                        <label class="d-flex align-items-center gap-2 mb-2">
                            <input type="radio" value="0" x-model="form.parent_id" class="form-check-input">
                            <strong>Menu Principal</strong>
                        </label>

                        <?php
                        function flattenMenu($items,$level=0,&$flat=[]){
                            foreach ($items as $i){
                                $flat[] = [
                                    'id'=>$i['id'],
                                    'title'=>str_repeat('— ', $level) . $i['title']
                                ];
                                if (!empty($i['children'])){
                                    flattenMenu($i['children'],$level+1,$flat);
                                }
                            }
                            return $flat;
                        }

                        $flat=[];
                        flattenMenu($fullTree,0,$flat);
                        foreach ($flat as $i):
                            ?>

                            <label class="d-flex align-items-center gap-2 mb-1">
                                <input type="radio" class="form-check-input"
                                       value="<?= $i['id'] ?>" x-model="form.parent_id">
                                <span><?= esc($i['title']) ?></span>
                            </label>

                        <?php endforeach; ?>

                    </div>
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

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        new Sortable(tbody, {
            animation:150,
            ghostClass:'bg-light',
            onEnd: async () => {
                const ids = [...tbody.querySelectorAll('tr[data-id]')]
                    .map(tr => tr.dataset.id);

                const response = await fetch('<?= base_url('admin/website/menu/reorder') ?>', {
                    method:'POST',
                    headers:{'Content-Type':'application/json'},
                    body:JSON.stringify({
                        parent_id: <?= $parentId ?: 'null' ?>,
                        ids: ids
                    })
                });

                const data = await response.json();
                showToast(data.message, data.status);
            }
        });
    });
</script>

<?= $this->endSection() ?>
