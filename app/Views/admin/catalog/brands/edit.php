<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Editar Marca
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                <h5 class="mb-2 card-title">Gestão de Marca</h5>
                <p class="text-muted mb-0">Editar dados da marca comercial</p>
            </div>

            <a href="javascript:void(0);"
               class="btn btn-primary"
               onclick="document.getElementById('brandForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>
        </div>
    </div>
</div>

<form id="brandForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/catalog/brands/update') ?>',
          {
              id: '<?= esc($brands['id']) ?>',
              name: '<?= esc($brands['name']) ?>',
              supplier_id: '<?= esc($brands['supplier_id']) ?>',
              country: '<?= esc($brands['country']) ?>',
              website: '<?= esc($brands['website']) ?>',
              featured: '<?= esc($brands['featured']) ?>',
              is_active: '<?= esc($brands['is_active']) ?>',
              description: '<?= esc($brands['description'], 'js') ?>',
              meta_title: '<?= esc($brands['meta_title'], 'js') ?>',
              meta_description: '<?= esc($brands['meta_description'], 'js') ?>',
              sort_order: '<?= esc($brands['sort_order']) ?>',
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
      @submit.prevent="submit">
    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Informação Geral</h4>
                    <p class="card-title-desc">Dados básicos da marca</p>

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-8" x-data="{ field: 'name' }">
                            <label class="form-label" :for="field">Nome da Marca</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Ex: Lumea, FrigoPure, CasaVerde"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Fornecedor -->
                        <div class="col-md-4"
                             x-data="{ field: 'supplier_id' }"
                             x-init="$nextTick(() => {
                                 const el = $refs.select;
                                 $(el).select2({
                                     width: '100%',
                                     placeholder: '-- Selecionar --',
                                     dropdownParent: $(el).closest('.card-body')
                                 });
                                 $(el).val(form[field]).trigger('change.select2');
                                 $(el).on('change', function () { form[field] = $(this).val(); });
                                 $watch('form[field]', (val) => {
                                     setTimeout(() => $(el).val(val).trigger('change.select2'), 10);
                                 });
                             })">
                            <label class="form-label" :for="field">Fornecedor</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    name="supplier_id">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>">
                                        <?= esc($supplier['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>

                    <!-- País e Website -->
                    <div class="row mt-3">
                        <div class="col-md-4" x-data="{ field: 'country' }">
                            <label class="form-label" :for="field">País</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Portugal, Espanha, etc."
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                        <div class="col-md-8" x-data="{ field: 'website' }">
                            <label class="form-label" :for="field">Website</label>
                            <input type="url" class="form-control" :id="field" :name="field"
                                   placeholder="https://www.exemplo.com"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="mt-3" x-data="{ field: 'description' }">
                        <label class="form-label" :for="field">Descrição</label>
                        <textarea class="form-control" :id="field" :name="field"
                                  placeholder="Descrição breve da marca"
                                  rows="4"
                                  x-model="form[field]"
                                  :class="{ 'is-invalid': errors[field] }"></textarea>
                    </div>

                </div>
            </div>

            <!-- SEO -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">SEO & Metadados</h4>
                    <div class="row">
                        <div class="col-md-12" x-data="{ field: 'meta_title' }">
                            <label class="form-label" :for="field">Título Meta</label>
                            <input type="text" class="form-control" :id="field" :name="field"
                                   placeholder="Título para motores de busca"
                                   x-model="form[field]">
                        </div>
                        <div class="col-md-12 mt-3" x-data="{ field: 'meta_description' }">
                            <label class="form-label" :for="field">Descrição Meta</label>
                            <textarea class="form-control" :id="field" :name="field"
                                      rows="3"
                                      placeholder="Descrição curta para motores de busca"
                                      x-model="form[field]"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="col-lg-4">
            <!-- Estado -->
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Estado</h4>
                    <p class="card-title-desc">Defina o estado e visibilidade</p>
                    <div class="row">
                        <!-- Estado -->
                        <div class="col-md-6"
                             x-data="{ field: 'is_active' }"
                             x-init="$nextTick(() => {
                                 const el = $refs.select;
                                 $(el).select2({
                                     width: '100%',
                                     placeholder: '-- Selecionar --',
                                     dropdownParent: $(el).closest('.card-body')
                                 });
                                 $(el).val(form[field]).trigger('change.select2');
                                 $(el).on('change', function () { form[field] = $(this).val(); });
                                 $watch('form[field]', (val) => {
                                     setTimeout(() => $(el).val(val).trigger('change.select2'), 10);
                                 });
                             })">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    name="is_active">
                                <option value="1">Ativa</option>
                                <option value="0">Inativa</option>
                            </select>
                        </div>

                        <!-- Destaque -->
                        <div class="col-md-6"
                             x-data="{ field: 'featured' }"
                             x-init="$nextTick(() => {
                                 const el = $refs.select;
                                 $(el).select2({
                                     width: '100%',
                                     placeholder: '-- Selecionar --',
                                     dropdownParent: $(el).closest('.card-body')
                                 });
                                 $(el).val(form[field]).trigger('change.select2');
                                 $(el).on('change', function () { form[field] = $(this).val(); });
                                 $watch('form[field]', (val) => {
                                     setTimeout(() => $(el).val(val).trigger('change.select2'), 10);
                                 });
                             })">
                            <label class="form-label" :for="field">Destaque</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    name="featured">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3" x-data="{ field: 'sort_order' }">
                        <label class="form-label" :for="field">Ordem</label>
                        <input type="number" class="form-control" :id="field" :name="field"
                               placeholder="1"
                               x-model="form[field]">
                    </div>
                </div>
            </div>
            <!-- Logo -->
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Logo da Marca</h4>
                    <div
                            x-data="{
                                imageUrl: '<?= !empty($brands['logo']) ? base_url('uploads/brands/' . $brands['logo']) : '' ?>',
                                loading: false,
                                uploadFile(e) {
                                    const file = e.target.files[0];
                                    if (!file) return;
                                    const formData = new FormData();
                                    formData.append('file', file);
                                    formData.append('brand_id', '<?= esc($brands['id']) ?>');
                                    this.loading = true;
                                   fetch('<?= base_url('admin/catalog/brands/upload-logo') ?>', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        this.loading = false;
                                        if (data.status === 'success' && data.url) {
                                            this.imageUrl = data.url;
                                            showToast('Logo carregado com sucesso!', 'success');
                                        } else {
                                            showToast(data.message || 'Erro ao carregar o logo.', 'error');
                                        }
                                    })
                                    .catch(() => {
                                        this.loading = false;
                                        showToast('Erro no envio do ficheiro.', 'error');
                                    });
                                },
                                deleteImage() {
                                    if (!this.imageUrl) return;
                                    const payload = {
                                        file: this.imageUrl,
                                        brand_id: '<?= esc($brands['id']) ?>'
                                    };
                                    this.loading = true;
                                    fetch('<?= base_url('admin/catalog/brands/delete-logo') ?>', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json' },
                                        body: JSON.stringify(payload)
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        this.loading = false;
                                        if (data.status === 'success') {
                                            this.imageUrl = '';
                                            showToast(data.message, 'success');
                                        } else {
                                            showToast(data.message || 'Erro ao remover o logo.', 'error');
                                        }
                                    })
                                    .catch(() => {
                                        this.loading = false;
                                        showToast('Erro no pedido de remoção.', 'error');
                                    });
                                }
                            }"
                    >
                        <div class="text-center mb-3">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="rounded border bg-light" style="max-height: 120px;">
                            </template>
                            <template x-if="!imageUrl">
                                <div class="bg-light text-muted text-center rounded p-5">
                                    <i class="mdi mdi-image-outline fs-1"></i><br>Sem imagem
                                </div>
                            </template>
                        </div>

                        <div class="d-flex justify-content-center gap-2">
                            <input type="file" x-ref="file" class="d-none" @change="uploadFile">
                            <button type="button" class="btn btn-light" @click="$refs.file.click()" :disabled="loading">
                                <span x-show="!loading">Carregar</span>
                                <span x-show="loading"><i class="fa fa-spinner fa-spin"></i> A enviar...</span>
                            </button>
                            <button type="button" class="btn btn-danger" @click="deleteImage" x-show="imageUrl && !loading">
                                Remover
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<?= $this->endSection() ?>
<?= $this->section('content-script') ?>

<?= $this->endSection() ?>
