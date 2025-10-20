<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Editar atributo: <strong><?= esc($attribute['name']) ?></strong></h5>
                <p class="text-muted mb-0">Atualiza as propriedades e valores associados a este atributo.</p>
            </div>

            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('attributeForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                <i class="far fa-save me-1"></i> Guardar
            </a>
        </div>
    </div><!-- end col -->
</div><!-- end row -->

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
        is_active: '<?= esc($attribute['is_active']) ?>',
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
                            <tbody
                                    x-data='sortableTable(<?= json_encode(array_values($attributesValues), JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) ?>)'
                                    x-init="$nextTick(() => init())">

                            <template x-for="(row, index) in rows" :key="row.id">
                                    <tr draggable="true"
                                        @dragstart="dragStart(index, $event)"
                                        @dragover.prevent
                                        @drop="drop(index, $event)">
                                        <th scope="row" x-text="row.id"></th>
                                        <td x-text="row.value"></td>
                                        <td x-text="index + 1"></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                    <li>
                                                        <button type="button"
                                                                x-data="systemModal()"
                                                                @click="open('#editComponent', 'md', { id: row.id, name: row.value, sort_order: index + 1 })"
                                                                class="btn btn-sm btn-light text-info"
                                                                title="Editar opção">
                                                            <i class="mdi mdi-pencil-outline"></i>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button"
                                                                x-data="systemModal()"
                                                                @click="open('#deleteComponent', 'md', { id: row.id, name: row.value })"
                                                                class="btn btn-sm btn-light text-danger"
                                                                title="Eliminar opção">
                                                            <i class="mdi mdi-trash-can-outline"></i>
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
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Visibilidade</h4>
                    <p class="card-title-desc">Informações de Visibilidade</p>

                    <div class="row">

                        <!-- Tipo -->
                        <div class="col-md-12"
                             x-data="{ field: 'type' }"
                             x-init="$nextTick(() => {
                         const el = $refs.select;
                         $(el).select2({
                             width: '100%',
                             placeholder: '-- Selecionar --',
                             dropdownParent: $(el).closest('.card-body'),
                             language: 'pt'
                         });
                         $(el).val(form[field]).trigger('change.select2');
                         $(el).on('change', () => form[field] = $(el).val());
                         $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                     })">
                            <label class="form-label" :for="field">Tipo</label>
                            <select class="form-select select2" x-ref="select" :id="field" name="type">
                                <option value="text">Texto</option>
                                <option value="select">Seleção</option>
                                <option value="multiselect">Seleção múltipla</option>
                                <option value="boolean">Sim/Não</option>
                                <option value="number">Número</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Obrigatório -->
                        <div class="col-md-12 mt-3"
                             x-data="{ field: 'is_required' }"
                             x-init="$nextTick(() => {
                         const el = $refs.select;
                         $(el).select2({
                             width: '100%',
                             placeholder: '-- Selecionar --',
                             dropdownParent: $(el).closest('.card-body'),
                             language: 'pt'
                         });
                         $(el).val(form[field]).trigger('change.select2');
                         $(el).on('change', () => form[field] = $(el).val());
                         $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                     })">
                            <label class="form-label" :for="field">Obrigatório</label>
                            <select class="form-select select2" x-ref="select" :id="field" name="is_required">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Filtrável -->
                        <div class="col-md-12 mt-3"
                             x-data="{ field: 'is_filterable' }"
                             x-init="$nextTick(() => {
                         const el = $refs.select;
                         $(el).select2({
                             width: '100%',
                             placeholder: '-- Selecionar --',
                             dropdownParent: $(el).closest('.card-body'),
                             language: 'pt'
                         });
                         $(el).val(form[field]).trigger('change.select2');
                         $(el).on('change', () => form[field] = $(el).val());
                         $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                     })">
                            <label class="form-label" :for="field">Filtrável</label>
                            <select class="form-select select2" x-ref="select" :id="field" name="is_filterable">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-12 mt-3"
                             x-data="{ field: 'is_active' }"
                             x-init="$nextTick(() => {
                         const el = $refs.select;
                         $(el).select2({
                             width: '100%',
                             placeholder: '-- Selecionar --',
                             dropdownParent: $(el).closest('.card-body'),
                             language: 'pt'
                         });
                         $(el).val(form[field]).trigger('change.select2');
                         $(el).on('change', () => form[field] = $(el).val());
                         $watch('form[field]', val => setTimeout(() => $(el).val(val).trigger('change.select2'), 10));
                     })">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2" x-ref="select" :id="field" name="is_active">
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
             form: { value: '', attribute_id: '<?= esc($attribute['id']) ?>' },
             errors: {},
             loading: false,
             async submit() {
                 this.loading = true;
                 try {
                     const response = await fetch('/admin/catalog/attributes/value/store', {
                         method: 'POST',
                         headers: { 'Content-Type': 'application/json' },
                         body: JSON.stringify(this.form)
                     });
                     const data = await response.json();
                     this.loading = false;
                     if (data.status === 'success') {
                         const activeModal = document.querySelector('.modal.show');
                         if (activeModal) {
                             const modal = bootstrap.Modal.getInstance(activeModal);
                             if (modal) modal.hide();
                         }

                         const newItem = {
                             id: data.id,
                             value: this.form.value,
                             attribute_id: this.form.attribute_id,
                             sort_order: 0
                         };

                         document.dispatchEvent(new CustomEvent('attribute-value-added', { detail: newItem }));
                         this.form.value = '';
                         this.errors = {};
                         showToast('Elemento criado com sucesso.', 'success');
                     } else {
                         this.errors = data.errors || {};
                         showToast(data.message || 'Erro ao criar elemento.', 'error');
                     }
                 } catch (err) {
                     this.loading = false;
                     console.error(err);
                     showToast('Erro de comunicação com o servidor.', 'error');
                 }
             }
         }">
        <div class="modal-header">
            <h5 class="modal-title">Criar Elemento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.value">
                    <div class="text-danger small" x-text="errors.value"></div>
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
<div id="editComponent" class="d-none">
    <div class="modal-content"
         x-data="{
             form: { id:'', name:'', sort_order:'' },
             errors: {},
             async submit() {
                 try {
                     const response = await fetch('/admin/catalog/attributes/value/update', {
                         method: 'POST',
                         headers: { 'Content-Type': 'application/json' },
                         body: JSON.stringify(this.form)
                     });
                     const data = await response.json();
                     if (data.status === 'success') {
                         const activeModal = document.querySelector('.modal.show');
                         if (activeModal) {
                             const modal = bootstrap.Modal.getInstance(activeModal);
                             if (modal) modal.hide();
                         }
                         document.dispatchEvent(new CustomEvent('attribute-value-updated', {
                             detail: { id: this.form.id, value: this.form.name }
                         }));
                         showToast('Elemento atualizado com sucesso.', 'success');
                     } else {
                         this.errors = data.errors || {};
                         showToast(data.message || 'Erro ao atualizar elemento.', 'error');
                     }
                 } catch (err) {
                     showToast('Erro de comunicação com o servidor.', 'error');
                 }
             }
         }"
         x-init="$el.addEventListener('fill-form', e => Object.assign(form, e.detail))">
        <div class="modal-header">
            <h5 class="modal-title">Editar Elemento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <div class="mb-3">
                    <label>Nome *</label>
                    <input type="text" class="form-control" x-model="form.name">
                    <div class="text-danger small" x-text="errors.name"></div>
                </div>
                <div class="mb-3">
                    <label>Ordem</label>
                    <input type="number" class="form-control" x-model="form.sort_order">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteComponent" class="d-none">
    <div class="modal-content"
         x-data="{
            form: { id:'', name:'' },
            async submit() {
                try {
                    const response = await fetch('/admin/catalog/attributes/value/delete', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.form)
                    });
                    const data = await response.json();
                    if (data.status === 'success') {
                        const activeModal = document.querySelector('.modal.show');
                        if (activeModal) {
                            const modal = bootstrap.Modal.getInstance(activeModal);
                            if (modal) modal.hide();
                        }
                        document.dispatchEvent(new CustomEvent('attribute-value-deleted', {
                            detail: { id: this.form.id }
                        }));
                        showToast('Elemento eliminado com sucesso.', 'success');
                    } else {
                        showToast(data.message || 'Erro ao eliminar elemento.', 'error');
                    }
                } catch (err) {
                    showToast('Erro ao eliminar elemento.', 'error');
                }
            }
        }"
         x-init="$el.addEventListener('fill-form', e => Object.assign(form, e.detail))">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar Elemento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="submit()">
                <input type="hidden" x-model="form.id">
                <p>Tem a certeza que deseja eliminar <strong x-text="form.name"></strong>?</p>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
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

            async drop(index, event) {
                const draggedIndex = this.draggingIndex;
                if (draggedIndex === null || draggedIndex === index) return;
                const draggedItem = this.rows[draggedIndex];
                this.rows.splice(draggedIndex, 1);
                this.rows.splice(index, 0, draggedItem);
                this.draggingIndex = null;
                showToast('Elementos reordenados com sucesso.', 'success');
            },

            init() {
                document.addEventListener('attribute-value-deleted', e => {
                    const id = e.detail.id;
                    const index = this.rows.findIndex(r => r.id == id);
                    if (index !== -1) this.rows.splice(index, 1);
                });

                document.addEventListener('attribute-value-added', e => {
                    const newValue = e.detail;
                    if (!newValue || !newValue.id) return;
                    const exists = this.rows.some(r => r.id == newValue.id);
                    if (!exists) {
                        this.rows.push(newValue);
                        this.rows = [...this.rows];
                    } else {
                        console.warn('🔁 Valor duplicado ignorado:', newValue);
                    }
                });

                document.addEventListener('attribute-value-updated', e => {
                    const updated = e.detail;
                    const index = this.rows.findIndex(r => r.id == updated.id);
                    if (index !== -1) this.rows[index].value = updated.value;
                    this.rows = [...this.rows];
                });
            }
        }
    }
</script>
<?= $this->endSection() ?>
