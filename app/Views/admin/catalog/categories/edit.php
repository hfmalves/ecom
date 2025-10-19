<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h4 class="fw-bold mb-0"><?= esc($category['name'] ?: 'Nova Categoria') ?></h4>
                <small class="text-muted">Última atualização: <?= esc($category['updated_at'] ?? '-') ?></small>
            </div>

            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('categoryForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>

        </div>
    </div><!--end col-->
</div><!--end row-->
<form id="categoryForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/catalog/categories/update') ?>',
          {
              id: '<?= esc($category['id']) ?>',
              parent_id: '<?= esc($category['parent_id']) ?>',
              name: '<?= esc($category['name']) ?>',
              slug: '<?= esc($category['slug']) ?>',
              description: '<?= esc($category['description']) ?>',
              image: '<?= esc($category['image']) ?>',
              is_active: '<?= esc($category['is_active']) ?>',
              position: '<?= esc($category['position']) ?>',
              meta_title: '<?= esc($category['meta_title']) ?>',
              meta_description: '<?= esc($category['meta_description']) ?>',
              meta_keywords: '<?= esc($category['meta_keywords']) ?>',
              created_at: '<?= esc($category['created_at']) ?>',
              updated_at: '<?= esc($category['updated_at']) ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">
    <div class="row">
        <div class="col-8">
            <!-- Informação Geral -->
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
                        <div class="col-4" x-data="{ field: 'slug' }">
                            <label class="form-label" :for="field">Slug</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="ex: produto-exemplo"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" x-data="{ field: 'description' }">
                            <label :for="field">Descrição</label>
                            <textarea class="form-control" :id="field" :name="field"
                                      x-model="form[field]" :class="{ 'is-invalid': errors[field] }"></textarea>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Informação Geral -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detalhes SEO </h4>
                    <p class="card-title-desc">Informação Geral</p>
                    <div class="row">
                        <div class="col-md-12" x-data="{ field: 'meta_title' }">
                            <label class="form-label" :for="field">Meta Title</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   x-model="form[field]" placeholder="Título SEO do produto"
                                   :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-12" x-data="{ field: 'meta_description' }">
                            <label class="form-label" :for="field">Meta Description</label>
                            <textarea class="form-control" :id="field" :name="field" rows="3"
                                      placeholder="Descrição SEO do produto"
                                      x-model="form[field]" :class="{ 'is-invalid': errors[field] }"></textarea>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-12" x-data="{ field: 'meta_keywords' }">
                            <label class="form-label" :for="field">Meta Keywords</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="ex: sapatilhas, running, homem"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
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
                        <div class="col-md-12"
                             x-data="{ field: 'is_active' }"
                             x-init="$nextTick(() => {
                     const el = $refs.select;
                     $(el).select2({
                         width: '100%',
                         placeholder: '-- Selecionar --',
                         dropdownParent: $(el).closest('.card-body')
                     });

                     $(el).val(form[field]).trigger('change.select2');

                     $(el).on('change', function () {
                         form[field] = $(this).val();
                     });

                     $watch('form[field]', (val) => {
                         setTimeout(() => $(el).val(val).trigger('change.select2'), 10);
                     });
                 })">

                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    name="is_active">
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

            <!-- Imagem da Categoria -->
            <div class="card mt-3"
                 x-data="{
                    imagePreview: '<?= $category['image'] ? base_url('uploads/categories/' . $category['image']) : '' ?>',
                    uploading: false,
                    async uploadImage(event) {
                        const file = event.target.files[0];
                        if (!file) return;

                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('category_id', '<?= $category['id'] ?>');

                        this.uploading = true;

                        try {
                            const res = await fetch('<?= base_url('admin/catalog/categories/upload-image') ?>', {
                                method: 'POST',
                                body: formData,
                                credentials: 'include'
                            });

                            const data = await res.json();
                            this.uploading = false;

                            if (data?.path) {
                                this.imagePreview = '/' + data.path;
                                showToast('Imagem carregada com sucesso!', 'success');
                            } else {
                                showToast('Erro ao carregar imagem.', 'error');
                            }

                        } catch (err) {
                            this.uploading = false;
                            console.error(err);
                            showToast('Erro de comunicação.', 'error');
                        }
                    }
                 }"
                >
                <div class="card-body ">
                    <h4 class="card-title">Imagem</h4>
                    <p class="card-title-desc">Imagem de categoria</p>

                    <!-- Preview -->
                    <template x-if="imagePreview">
                        <div class="position-relative d-inline-block mb-3">
                            <img :src="imagePreview" alt="Imagem da categoria"
                                 class="rounded shadow-sm"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </template>

                    <!-- Placeholder -->
                    <template x-if="!imagePreview">
                        <div class="bg-light border rounded d-flex align-items-center justify-content-center mb-3"
                             style="width: 150px; height: 150px;">
                            <i class="mdi mdi-image-off fs-1 text-muted"></i>
                        </div>
                    </template>

                    <!-- Upload -->
                    <div class="d-grid gap-2">
                        <label class="btn btn-outline-primary mb-0">
                            <input type="file" accept="image/*" class="d-none" @change="uploadImage">
                            <span x-show="!uploading"><i class="mdi mdi-upload"></i> Carregar Imagem</span>
                            <span x-show="uploading"><i class="fa fa-spinner fa-spin"></i> A carregar...</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- CATEGORIA PAI -->
            <!-- CATEGORIA PAI -->
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">Categoria Pai</h4>
                    <p class="card-title-desc">Selecione a categoria principal (opcional)</p>

                    <div class="border rounded p-2" style="max-height: 300px; overflow-y: auto;">

                        <!-- Opção de topo -->
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="parent_id" value="0"
                                   x-model="form.parent_id"
                                    <?= empty($category['parent_id']) ? 'checked' : '' ?>>
                            <label class="form-check-label text-muted">Sem categoria pai</label>
                        </div>

                        <?php foreach ($categoriesTree as $cat1): ?>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="parent_id"
                                       value="<?= $cat1['id'] ?>"
                                       x-model="form.parent_id"
                                        <?= $category['parent_id'] == $cat1['id'] ? 'checked' : '' ?>>
                                <label class="form-check-label"><?= esc($cat1['name']) ?></label>
                            </div>

                            <?php if (!empty($cat1['children'])): ?>
                                <?php foreach ($cat1['children'] as $cat2): ?>
                                    <div class="form-check mb-1 ms-3">
                                        <input class="form-check-input" type="radio" name="parent_id"
                                               value="<?= $cat2['id'] ?>"
                                               x-model="form.parent_id"
                                                <?= $category['parent_id'] == $cat2['id'] ? 'checked' : '' ?>>
                                        <label class="form-check-label"><?= esc($cat2['name']) ?></label>
                                    </div>

                                    <?php if (!empty($cat2['children'])): ?>
                                        <?php foreach ($cat2['children'] as $cat3): ?>
                                            <div class="form-check mb-1 ms-4">
                                                <input class="form-check-input" type="radio" name="parent_id"
                                                       value="<?= $cat3['id'] ?>"
                                                       x-model="form.parent_id"
                                                        <?= $category['parent_id'] == $cat3['id'] ? 'checked' : '' ?>>
                                                <label class="form-check-label"><?= esc($cat3['name']) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>


        </div>
    </div>
</form>



<?= $this->endSection() ?>
<?= $this->section('content-script') ?>
<script>
    $(document).ready(function() {
        $('#description, #short_description').summernote({
            height: 200,
            minHeight: 150,
            maxHeight: null,
            focus: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']]
            ]
        });
    });
</script>
<?= $this->endSection() ?>
