<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Hello, Henry Franklin</h5>
                <p class="text-muted mb-0">Ready to jump back in?</p>
            </div>

            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('attributeForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                <i class=" far fa-save  me-1"></i>
                Guardar

            </a>

        </div>
    </div><!--end col-->
</div><!--end row-->
<form id="attributeForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/catalog/attributes/update') ?>',
          {
              id: '<?= esc($attribute['id']) ?>',
              code: '<?= esc($attribute['code']) ?>',
              name: '<?= esc($attribute['name']) ?>',
              type: '<?= esc($attribute['type']) ?>',
              is_required: '<?= esc($attribute['is_required']) ?>',
              is_filterable: '<?= esc($attribute['is_filterable']) ?>',
              sort_order: '<?= esc($attribute['sort_order']) ?>',
              default_value: '<?= esc($attribute['default_value']) ?>',
              validation: '<?= esc($attribute['validation']) ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informação Geral</h4>
                    <p class="card-title-desc">Informação Geral</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome do produto"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-4" x-data="{ field: 'code' }">
                            <label class="form-label" :for="field">Codigo</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="ex: produto-exemplo"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title">Opções </h4>
                                    <p class="card-title-desc">Composição do atributo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <button type="button" x-data="systemModal()"
                                        @click="open('#createComponent', 'md')"
                                        class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Ordem</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody x-data='sortableTable(<?= json_encode(array_values($attributesValues), JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                <template x-for="(row, index) in rows" :key="row.id">
                                    <tr draggable="true"
                                        @dragstart="dragStart(index, $event)"
                                        @dragover.prevent
                                        @drop="drop(index, $event)">
                                        <th scope="row" x-text="row.id"></th>
                                        <td x-text="row.value"></td>
                                        <td x-text="index + 1"></td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button type="button" x-data="systemModal()"
                                                                @click="open('#editComponent', 'md', { id: row.id, name: row.value, sort_order: index + 1 })"
                                                                class="dropdown-item">
                                                            <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" x-data="systemModal()"
                                                                @click="open('#deleteComponent', 'md', { id: row.id, name: row.value })"
                                                                class="dropdown-item">
                                                            <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Eliminar
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Coluna lateral -->
        <div class="col-4">
            <!-- Visibilidade -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Visibilidade</h4>
                    <p class="card-title-desc">Informações de Visibilidade</p>
                    <div class="row">
                        <div class="col-md-6" x-data="{ field: 'type' }">
                            <label class="form-label" :for="field">Tipo</label>
                            <select class="form-select"  :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="text">Texto</option>
                                <option value="number">Número</option>
                                <option value="select">Seleção</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                        <div class="col-md-6" x-data="{ field: 'is_required' }">
                            <label class="form-label" :for="field">Obrigatório</label>
                            <select class="form-select"  :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<div id="createComponent" class="d-none">
    <div class="modal-content"
         x-data="{
            ...formHandler('/admin/catalog/attributes/value/store',
              {
                value: '',
                attribute_id: '<?= esc($attribute['id']) ?>',
                <?= csrf_token() ?>:'<?= csrf_hash() ?>'
              },
              { resetOnSuccess: true }),
            loading:true
         }"
         x-init="
            $el.addEventListener('fill-form', e => {
              Object.entries(e.detail).forEach(([k, v]) => { if (k in form) form[k] = v })
              loading = false
            });
            $el.addEventListener('reset-form', () => {
              Object.keys(form).forEach(k => {
                if (k !== '<?= csrf_token() ?>' && k !== 'attribute_id') form[k] = ''
              })
              loading = false
            });
            document.addEventListener('csrf-update', e => {
              form[e.detail.token] = e.detail.hash
            });
         ">
        <div class="modal-header">
            <h5 class="modal-title">Criar Elemento do Atributo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div x-show="loading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">A carregar...</span>
                </div>
            </div>

            <form @submit.prevent="submit()" x-show="!loading" x-cloak>
                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="value" x-model="form.value">
                    <div class="text-danger small" x-text="errors.value"></div>
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

<div id="editComponent" class="d-none">
    <div x-data="{
        ...formHandler('/admin/catalog/attributes/update',
          { id:'', name:'', sort_order:'', <?= csrf_token() ?>:'<?= csrf_hash() ?>' }),
        loading:true
      }"
         x-init="
         $el.addEventListener('fill-form', e => {
           Object.entries(e.detail).forEach(([k, v]) => { if (k in form) form[k] = v })
           loading = false
         });
         $el.addEventListener('reset-form', () => {
           Object.keys(form).forEach(k => form[k] = '');
           loading = false
         });
       ">
        <div class="modal-header">
            <h5 class="modal-title">Editar Elemento do Atributo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div x-show="loading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">A carregar...</span>
                </div>
            </div>
            <form @submit.prevent="submit()" x-show="!loading" x-cloak>
                <input type="hidden" name="id" x-model="form.id">

                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" class="form-control" name="name" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ordem</label>
                    <input type="number" class="form-control" name="sort_order" x-model="form.sort_order">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteComponent" class="d-none">
    <div x-data="{
        ...formHandler('/admin/catalog/attributes/delete',
          { id:'', name:'', <?= csrf_token() ?>:'<?= csrf_hash() ?>' }),
        loading:true
      }"
         x-init="
         $el.addEventListener('fill-form', e => {
           Object.entries(e.detail).forEach(([k, v]) => { if (k in form) form[k] = v })
           loading = false
         });
         $el.addEventListener('reset-form', () => {
           Object.keys(form).forEach(k => form[k] = '');
           loading = false
         });
       ">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Elemento do Atributo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Spinner -->
            <div x-show="loading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">A carregar...</span>
                </div>
            </div>
            <!-- Form -->
            <form @submit.prevent="submit()" x-show="!loading" x-cloak>
                <input type="hidden" name="id" x-model="form.id">
                <p class="mb-3">
                    Tem a certeza que deseja eliminar o atributo:
                    <strong x-text="form.name"></strong>?
                </p>

                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" :disabled="loading">
                        <span x-show="!loading">Eliminar</span>
                        <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A eliminar...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('content-script') ?>
<script>
    function sortableTable(rows) {
        return {
            rows: rows,
            draggingIndex: null,

            dragStart(index, event) {
                this.draggingIndex = index;
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', index);
            },

            dragOver(index, event) {
                event.preventDefault();
                event.dataTransfer.dropEffect = 'move';
            },

            async drop(index, event) {
                const draggedIndex = this.draggingIndex;
                if (draggedIndex === null || draggedIndex === index) return;

                // mover item no array
                const draggedItem = this.rows[draggedIndex];
                this.rows.splice(draggedIndex, 1);
                this.rows.splice(index, 0, draggedItem);
                this.draggingIndex = null;

                // guardar automaticamente
                const data = this.rows.map((row, i) => ({
                    id: row.id,
                    sort_order: i + 1
                }));

                try {
                    const response = await fetch('<?= base_url('admin/catalog/attributes/values/update-order') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                        },
                        body: JSON.stringify({rows: data})
                    });

                    const result = await response.json();
                    if (!result.success) {
                        console.error('Erro ao guardar a ordem');
                    }
                } catch (err) {
                    console.error('Erro de rede ao guardar a ordem', err);
                }
            }
        }
    }

</script>
<?= $this->endSection() ?>
