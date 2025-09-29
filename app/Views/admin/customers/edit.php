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
               onclick="document.getElementById('supplierForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>

        </div>
    </div><!--end col-->
</div><!--end row-->
<form id="supplierForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/customer/update') ?>',
          {
              id: '<?= esc($brands['id']) ?>',
              name: '<?= esc($brands['name']) ?>',
              slug: '<?= esc($brands['slug']) ?>',
              description: '<?= esc($brands['description']) ?>',
              is_active: '<?= esc($brands['is_active']) ?>',
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
                    <p class="card-title-desc">Dados da marca</p>
                    <div class="row">
                        <div class="col-8" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Nome do fornecedor"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-4" x-data="{ field: 'slug' }">
                            <label :for="field">Slug</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Pessoa responsável"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12" x-data="{ field: 'description' }">
                            <label :for="field">Descrição</label>
                            <textarea class="form-control" :id="field" :name="field"
                                      placeholder="Rua, nº, cidade"
                                      x-model="form[field]" :class="{ 'is-invalid': errors[field] }"></textarea>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna lateral -->
        <div class="col-4">
            <!-- Estado -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estado</h4>
                    <p class="card-title-desc">Defina se o fornecedor está ativo ou inativo</p>
                    <div class="row">
                        <div class="col-md-6" x-data="{ field: 'is_active' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select" :name="field"
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
