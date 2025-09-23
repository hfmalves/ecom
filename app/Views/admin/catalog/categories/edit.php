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
                        <div class="col-md-6" x-data="{ field: 'is_active' }">
                            <label class="form-label" :for="field">Estado</label>
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
