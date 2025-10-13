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
               onclick="console.log('cliquei no botão'); document.getElementById('productForm').dispatchEvent(new Event('submit', { bubbles:true, cancelable:true }))">
                Guardar
            </a>

        </div>
    </div><!--end col-->
</div><!--end row-->
<form id="productForm"
      x-ref="form"
      x-data="formHandler(
          '<?= base_url('admin/catalog/products/update') ?>',
          {
              id: '<?= esc($product['id']) ?>',
              status: '<?= esc($product['status']) ?>',
              name: '<?= esc($product['name']) ?>',
              slug: '<?= esc($product['slug']) ?>',
              description: '<?= esc($product['description']) ?>',
              short_description: '<?= esc($product['short_description']) ?>',
              meta_title: '<?= esc($product['meta_title']) ?>',
              meta_description: '<?= esc($product['meta_description']) ?>',
              meta_keywords: '<?= esc($product['meta_keywords']) ?>',
              cost_price: '<?= esc($product['cost_price']) ?>',
              base_price: '<?= esc($product['base_price']) ?>',
              base_price_tax: '<?= esc($product['base_price_tax']) ?>',
              tax_class_id: '<?= esc($product['tax_class_id']) ?>',
              discount_type: '<?= esc($product['discount_type']) ?>',
              discount_value: '<?= esc($product['discount_value']) ?>',
              special_price: '<?= esc($product['special_price']) ?>',
              special_price_start: '<?= esc($product['special_price_start']) ?>',
              special_price_end: '<?= esc($product['special_price_end']) ?>',
              weight: '<?= esc($product['weight']) ?>',
              width: '<?= esc($product['width']) ?>',
              height: '<?= esc($product['height']) ?>',
              length: '<?= esc($product['length']) ?>',
              type: '<?= esc($product['type']) ?>',
              visibility: '<?= esc($product['visibility']) ?>',
              is_featured: <?= $product['is_featured'] ? 'true' : 'false' ?>,
              is_new: <?= $product['is_new'] ? 'true' : 'false' ?>,
              stock_qty: '<?= esc($product['stock_qty']) ?>',
              manage_stock: <?= $product['manage_stock'] ? 'true' : 'false' ?>,
              sku: '<?= esc($product['sku']) ?>',
              ean: '<?= esc($product['ean']) ?>',
              upc: '<?= esc($product['upc']) ?>',
              isbn: '<?= esc($product['isbn']) ?>',
              gtin: '<?= esc($product['gtin']) ?>',
              supplier_id: '<?= esc($product['supplier_id']) ?>',
              brand_id: '<?= esc($product['brand_id']) ?>',
              category_id: '<?= esc($product['category_id']) ?>',
              attributes: <?= htmlspecialchars($attributes, ENT_QUOTES, 'UTF-8') ?>,
              productsVariants: <?= htmlspecialchars($productsVariants, ENT_QUOTES, 'UTF-8') ?>,
              productsVariantsAttributes: <?= htmlspecialchars($productsVariantsAttributes, ENT_QUOTES, 'UTF-8') ?>,
              <?= csrf_token() ?>: '<?= csrf_hash() ?>',
              updateVariant(variant) {const csrfName = '<?= csrf_token() ?>';
                const csrfValue = this[csrfName];

    fetch('<?= base_url('admin/catalog/products/variants/update') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfValue
        },
        body: JSON.stringify({
            id: variant.id,
            sku: variant.sku,
            cost_price: variant.cost_price,
            base_price: variant.base_price,
            base_price_tax: variant.base_price_tax,
            stock_qty: variant.stock_qty,
            manage_stock: variant.manage_stock,
            is_default: variant.is_default,
            [csrfName]: csrfValue
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(`Variante ${variant.sku} atualizada com sucesso`, 'success', 'Sucesso');
        } else {
            const msg = data.message || 'Erro ao atualizar variante.';
            showToast(msg, 'error', '❌ Falha');
            if (data.errors) console.warn('Detalhes do erro:', data.errors);
        }

        // Atualiza o token CSRF para os próximos pedidos
        if (data.csrf) {
            this[csrfName] = data.csrf;
        }
    })
    .catch(err => {
            console.error('Erro de rede:', err);
            showToast('Erro de rede ao atualizar variante.', 'error', '⚠️ Erro');
        }); // ❌ TINHAS uma vírgula aqui — remove
    },

          }
      )"
      @submit.prevent="submit"
    >
    <div class="row">
        <div class="col-8">
            <!-- Informação Geral -->
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-geral" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-info-circle"></i></span>
                                <span class="d-none d-sm-block">Informação Geral</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-valores" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-tags"></i></span>
                                <span class="d-none d-sm-block">Valores</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-composicao" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-layer-group"></i></span>
                                <span class="d-none d-sm-block">Composição</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-dimensoes" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-ruler-combined"></i></span>
                                <span class="d-none d-sm-block">Dimensões</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-multimedia" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-photo-video"></i></span>
                                <span class="d-none d-sm-block">Multimédia</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-meta" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-brain"></i></span>
                                <span class="d-none d-sm-block">Meta IA</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content p-0 text-muted">
                        <div class="tab-pane fade show active" id="tab-geral" role="tabpanel">
                            <div class="row mt-2 mb-2">
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
                                <div class="col-md-12"
                                     x-data="{ field: 'description' }"
                                     x-init="
            // Espera Alpine montar o campo e depois inicia o Summernote
            $nextTick(() => {
                $('#description').summernote({
                    height: 200,
                    minHeight: 150,
                    maxHeight: null,
                    focus: true,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture']],
                        ['view', ['codeview']]
                    ],
                    callbacks: {
                        onChange: function(contents) {
                            // 🔹 Atualiza o Alpine x-model sempre que há alteração
                            form.description = contents;
                        }
                    }
                });

                // 🔹 Garante que o valor inicial de Alpine entra no Summernote
                $('#description').summernote('code', form.description);

                // 🔹 Atualiza o Summernote se o Alpine mudar (p.ex. via load AJAX)
                $watch('form.description', value => {
                    if ($('#description').summernote('code') !== value) {
                        $('#description').summernote('code', value);
                    }
                });
            })
         ">
                                    <label :for="field">Descrição</label>
                                    <textarea class="form-control" id="description" name="description"
                                              x-model="form[field]"
                                              :class="{ 'is-invalid': errors[field] }"></textarea>
                                    <template x-if="errors[field]">
                                        <small class="text-danger" x-text="errors[field]"></small>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-valores" role="tabpanel">

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" for="cost_price">Preço de Custo</label>
                                    <input type="number" step="0.01" class="form-control"
                                           id="cost_price" name="cost_price"
                                           x-model="form.cost_price" placeholder="0.00"
                                           :class="{ 'is-invalid': errors.cost_price }">
                                    <template x-if="errors.cost_price">
                                        <small class="text-danger" x-text="errors.cost_price"></small>
                                    </template>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="base_price">Preço Base</label>
                                    <input type="number" step="0.01" class="form-control"
                                           id="base_price" name="base_price"
                                           x-model="form.base_price" placeholder="0.00"
                                           :class="{ 'is-invalid': errors.base_price }"
                                           @input="
           const base = parseFloat(form.base_price) || 0;
           const tax = parseFloat(form.tax_rate) || 0;
           form.base_price_tax = (base * (1 + tax / 100)).toFixed(2);

           // 🔹 Atualiza Preço Promocional se houver desconto
           if (form.discount_type && form.discount_value) {
               const val = parseFloat(form.discount_value) || 0;
               if (form.discount_type === 'percent') {
                   form.special_price = (form.base_price_tax - (form.base_price_tax * val / 100)).toFixed(2);
               } else if (form.discount_type === 'fixed') {
                   form.special_price = (form.base_price_tax - val).toFixed(2);
               }
           }
       ">

                                    <template x-if="errors.base_price">
                                        <small class="text-danger" x-text="errors.base_price"></small>
                                    </template>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="base_price_tax">Preço Base + Imposto</label>
                                    <input type="number" step="0.01" class="form-control"
                                           id="base_price_tax" name="base_price_tax"
                                           x-model="form.base_price_tax" placeholder="0.00"
                                           :class="{ 'is-invalid': errors.base_price_tax }"
                                           disabled>
                                    <template x-if="errors.base_price_tax">
                                        <small class="text-danger" x-text="errors.base_price_tax"></small>
                                    </template>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="tax_class_id">Taxa (IVA)</label>
                                    <select class="form-select"
                                            id="tax_class_id"
                                            name="tax_class_id"
                                            x-model="form.tax_class_id"
                                            @change="
                                        const selected = $event.target.options[$event.target.selectedIndex];
                                            const tax = parseFloat(selected.dataset.rate) || 0;
                                            form.tax_rate = tax;
                                            const base = parseFloat(form.base_price) || 0;
                                            form.base_price_tax = (base * (1 + tax / 100)).toFixed(2);

                                            // 🔹 Atualiza Preço Promocional se houver desconto
                                            if (form.discount_type && form.discount_value) {
                                                const val = parseFloat(form.discount_value) || 0;
                                                if (form.discount_type === 'percent') {
                                                    form.special_price = (form.base_price_tax - (form.base_price_tax * val / 100)).toFixed(2);
                                                } else if (form.discount_type === 'fixed') {
                                                    form.special_price = (form.base_price_tax - val).toFixed(2);
                                                }
                                            }
                                        ">
                                        <option value="">-- Selecionar --</option>
                                        <?php foreach ($product_tax ?? [] as $tax): ?>
                                            <option
                                                    value="<?= $tax['id'] ?>"
                                                    data-rate="<?= esc($tax['rate']) ?>"
                                                <?= ($product['tax_class_id'] ?? '') == $tax['id'] ? 'selected' : '' ?>>
                                                <?= esc($tax['name']) ?> — <?= esc($tax['rate']) ?>%
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3"
                                 x-init="
                                    $nextTick(() => {
                                        const start = $refs.start;
                                        const end = $refs.end;
                                        const today = new Date();
                                        $(start).datepicker({
                                            format: 'dd-mm-yyyy',
                                            autoclose: true,
                                            startDate: today // mínimo = hoje
                                        }).on('changeDate', function() {
                                            const startDate = $(start).datepicker('getDate');
                                            form.special_price_start = $(start).val();
                                            const minEnd = new Date(startDate);
                                            minEnd.setDate(minEnd.getDate() + 1);
                                            $(end).datepicker('setStartDate', minEnd);
                                            const endDate = $(end).datepicker('getDate');
                                            if (!endDate || endDate < minEnd) {
                                                $(end).datepicker('setDate', minEnd);
                                                form.special_price_end = $(end).val();
                                            }
                                        });
                                        $(end).datepicker({
                                            format: 'dd-mm-yyyy',
                                            autoclose: true,
                                            startDate: new Date(today.getTime() + 24 * 60 * 60 * 1000) // mínimo = amanhã
                                        }).on('changeDate', function() {
                                            form.special_price_end = $(end).val();
                                        });
                                    });
                                 ">
                                <!-- Início Promoção -->
                                <div class="col-md-3">
                                    <label class="form-label">Início Promoção</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               placeholder="dd-mm-yyyy"
                                               x-ref="start"
                                               x-model="form.special_price_start">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <!-- Fim Promoção -->
                                <div class="col-md-3">
                                    <label class="form-label">Fim Promoção</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               placeholder="dd-mm-yyyy"
                                               x-ref="end"
                                               x-model="form.special_price_end">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <!-- Tipo de Desconto -->
                                <div class="col-md-3"
                                     x-data="{ field: 'discount_type' }"
                                     x-init="$nextTick(() => {
            const el = $refs.select;
            $(el).select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            $(el).val(form[field]).trigger('change');
            $(el).on('change', function() {
                form[field] = $(this).val();

                // 🔹 Calcula o preço promocional sempre que o tipo muda
                const base = parseFloat(form.base_price_tax) || 0;
                const val  = parseFloat(form.discount_value) || 0;

                if (form.discount_type === 'percent') {
                    form.special_price = (base - (base * val / 100)).toFixed(2);
                } else if (form.discount_type === 'fixed') {
                    form.special_price = (base - val).toFixed(2);
                } else {
                    form.special_price = base.toFixed(2);
                }
            });

            $watch('form[field]', (val) => {
                $(el).val(val).trigger('change.select2');
            });
         })">
                                    <label class="form-label" :for="field">Tipo de Desconto</label>
                                    <select class="form-select select2"
                                            x-ref="select"
                                            :id="field"
                                            :name="field"
                                            x-model="form[field]"
                                            :class="{ 'is-invalid': errors[field] }">
                                        <option value="">-- Selecionar --</option>
                                        <option value="percent">Percentagem (%)</option>
                                        <option value="fixed">Valor Fixo (€)</option>
                                    </select>
                                </div>

                                <!-- Valor do Desconto -->
                                <div class="col-md-3" x-data="{ field: 'discount_value' }">
                                    <label class="form-label" :for="field">Valor do Desconto</label>
                                    <input type="number" step="0.01" class="form-control"
                                           :id="field" :name="field"
                                           x-model="form[field]" placeholder="0.00"
                                           :class="{ 'is-invalid': errors[field] }"
                                           @input="
                    const base = parseFloat(form.base_price_tax) || 0;
                    const val  = parseFloat(form.discount_value) || 0;

                    if (form.discount_type === 'percent') {
                        form.special_price = (base - (base * val / 100)).toFixed(2);
                    } else if (form.discount_type === 'fixed') {
                        form.special_price = (base - val).toFixed(2);
                    } else {
                        form.special_price = base.toFixed(2);
                    }
               ">
                                    <template x-if="errors[field]">
                                        <small class="text-danger" x-text="errors[field]"></small>
                                    </template>
                                </div>

                                <!-- Preço Promocional -->
                                <div class="col-md-3" x-data="{ field: 'special_price' }">
                                    <label class="form-label" :for="field">Preço Promocional</label>
                                    <input type="number" step="0.01" class="form-control"
                                           :id="field" :name="field"
                                           x-model="form[field]"
                                           placeholder="0.00"
                                           :class="{ 'is-invalid': errors[field] }"
                                           disabled>
                                    <template x-if="errors[field]">
                                        <small class="text-danger" x-text="errors[field]"></small>
                                    </template>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab-composicao" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4" x-data="{ field: 'sku' }">
                                    <label class="form-label" :for="field">SKU</label>
                                    <input type="text" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="ex: PROD12345"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                                <div class="col-md-4" x-data="{ field: 'ean' }">
                                    <label class="form-label" :for="field">EAN</label>
                                    <input type="text" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="EAN do produto"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                                <div class="col-md-4" x-data="{ field: 'upc' }">
                                    <label class="form-label" :for="field">UPC</label>
                                    <input type="text" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="UPC do produto"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" x-data="{ field: 'isbn' }">
                                    <label class="form-label" :for="field">ISBN</label>
                                    <input type="text" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="ISBN"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                                <div class="col-md-4" x-data="{ field: 'gtin' }">
                                    <label class="form-label" :for="field">GTIN</label>
                                    <input type="text" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="GTIN do produto"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <!-- CAMPOS DE PRODUTO SIMPLES -->
                                <div x-show="form.type === 'simple'" class="mt-4">
                                    <p class="text-muted">Campos específicos para produto simples...</p>
                                    <!-- adiciona aqui os inputs normais -->
                                </div>
                                <!-- CAMPOS DE PRODUTO CONFIGURÁVEL -->
                                <div x-show="form.type === 'configurable'" class="mt-0 pt-0">
                                    <template x-if="form.productsVariants.length > 0">
                                        <table class="table table-bordered align-middle mt-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="15%">SKU</th>
                                                <th>Preço Custo</th>
                                                <th>Preço Base</th>
                                                <th>Preço + IVA</th>
                                                <th>Stock</th>
                                                <th>Gerir Stock</th>
                                                <th>Default</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <template x-for="(variant, index) in form.productsVariants" :key="variant.id ?? index">
                                                <tr>
                                                    <td>
                                                        <input type="text"
                                                               class="form-control form-control-sm"
                                                               x-model="variant.sku"
                                                               @change="form.updateVariant(variant)">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                               class="form-control form-control-sm"
                                                               x-model="variant.cost_price"
                                                               step="0.01"
                                                               @change="form.updateVariant(variant)">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                               class="form-control form-control-sm"
                                                               x-model="variant.base_price"
                                                               step="0.01"
                                                               @change="form.updateVariant(variant)">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                               class="form-control form-control-sm"
                                                               x-model="variant.base_price_tax"
                                                               step="0.01"
                                                               @change="form.updateVariant(variant)">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                               class="form-control form-control-sm"
                                                               x-model="variant.stock_qty"
                                                               :disabled="variant.manage_stock != 1"
                                                               @change="form.updateVariant(variant)">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <input type="checkbox"
                                                                   class="form-check-input"
                                                                   :id="'manage_'+index"
                                                                   :checked="variant.manage_stock == 1 || variant.manage_stock === '1'"
                                                                   @change="
                                                               variant.manage_stock = $event.target.checked ? 1 : 0;
                                                               form.updateVariant(variant);
                                                           ">
                                                        </div>
                                                    </td>
                                                    <!-- IS DEFAULT -->
                                                    <td class="text-center">
                                                        <input type="radio"
                                                               name="default_variant"
                                                               :id="'default_'+index"
                                                               :value="variant.sku"
                                                               :checked="variant.is_default == 1 || variant.is_default === '1'"
                                                               @change="
                                                           form.defaultVariantSku = variant.sku;
                                                           form.productsVariants.forEach(v => v.is_default = (v.sku === variant.sku ? 1 : 0));
                                                           form.updateVariant(variant);
                                                       ">
                                                    </td>
                                                    <!-- AÇÕES -->
                                                    <td class="text-center">
                                                        <button type="button"
                                                                class="btn btn-primary btn-sm"
                                                                @click="$dispatch('variant-edit', variant)">
                                                            Editar
                                                        </button>

                                                    </td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>
                                    </template>
                                </div>
                                <!-- CAMPOS DE PRODUTO VIRTUAL -->
                                <div x-show="form.type === 'virtual'" class="mt-4 border-top pt-3">
                                    <p class="text-muted">Configurações para produtos virtuais (downloads, links, etc.)</p>
                                </div>
                                <!-- CAMPOS DE PACK -->
                                <div x-show="form.type === 'pack'" class="mt-4 border-top pt-3">
                                    <p class="text-muted">Gestão de produtos que compõem o pack...</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-dimensoes" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3" x-data="{ field: 'weight' }">
                                    <label class="form-label" :for="field">Peso (kg)</label>
                                    <input type="text" step="0.01" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="0.00" x-model="form[field]"
                                           :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                                <div class="col-md-3" x-data="{ field: 'width' }">
                                    <label class="form-label" :for="field">Largura (cm)</label>
                                    <input type="text" step="0.1" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="0.0" x-model="form[field]"
                                           :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                                <div class="col-md-3" x-data="{ field: 'height' }">
                                    <label class="form-label" :for="field">Altura (cm)</label>
                                    <input type="text" step="0.1" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="0.0" x-model="form[field]"
                                           :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                                <div class="col-md-3" x-data="{ field: 'length' }">
                                    <label class="form-label" :for="field">Comprimento (cm)</label>
                                    <input type="text" step="0.1" class="form-control"
                                           :id="field" :name="field"
                                           placeholder="0.0" x-model="form[field]"
                                           :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                                </div>
                            </div>
                        </div>
                        <!-- SortableJS -->
                        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

                        <div class="tab-pane fade" id="tab-multimedia" role="tabpanel"
                             x-data="{
        images: form.images || [],
        productId: form.id,
        uploading: false,
        deleteId: null,
        showDelete: false,

        getCsrf() {
            const match = document.cookie.match(/csrf_cookie_name=([^;]+)/);
            return match ? decodeURIComponent(match[1]) : null;
        },

        async addFiles(event) {
            const files = event.target.files;
            if (!files.length) return;
            const csrf = this.getCsrf();

            for (const file of files) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('owner_type', 'product');
                formData.append('owner_id', this.productId);

                this.uploading = true;

                const res = await fetch('/admin/catalog/products/upload-image', {
                    method: 'POST',
                    headers: csrf ? { 'X-CSRF-TOKEN': csrf } : {},
                    body: formData,
                    credentials: 'include'
                });

                const data = await res.json();
                this.uploading = false;

                if (data?.path) {
                    this.images.push({
                        id: data.id,
                        url: '/' + data.path,
                        alt_text: data.alt_text
                    });
                }
            }

            event.target.value = '';
            form.images = this.images;
        },

        async confirmDelete(id) {
            this.deleteId = id;
            this.showDelete = true;
        },

        async deleteImage() {
            if (!this.deleteId) return;
            const csrf = this.getCsrf();

            await fetch(`/admin/catalog/products/delete-image/${this.deleteId}`, {
                method: 'DELETE',
                headers: csrf ? { 'X-CSRF-TOKEN': csrf } : {},
                credentials: 'include'
            });

            this.images = this.images.filter(i => i.id !== this.deleteId);
            form.images = this.images;
            this.showDelete = false;
            this.deleteId = null;
        },

        async reorderImages() {
            const order = this.images.map(i => i.id);
            const csrf = this.getCsrf();

            await fetch('/admin/catalog/products/reorder-images', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {})
                },
                body: JSON.stringify(order),
                credentials: 'include'
            });
        },

        initSortable() {
            const el = this.$refs.list;
            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                onEnd: async evt => {
                    const moved = this.images.splice(evt.oldIndex, 1)[0];
                    this.images.splice(evt.newIndex, 0, moved);
                    form.images = this.images;
                    await this.reorderImages();
                }
            });
        }
     }"
                             x-init="initSortable()">


                        <div class="card p-3">
                                <h4 class="card-title">Imagens</h4>
                                <p class="card-title-desc">Carregar, ordenar e eliminar imagens.</p>

                                <!-- Upload -->
                                <input type="file"
                                       multiple
                                       accept="image/*"
                                       class="form-control mb-3"
                                       @change="addFiles($event)"
                                       :disabled="uploading">

                                <!-- Lista -->
                                <div class="d-flex flex-wrap gap-3" x-ref="list">
                                    <template x-for="(img, index) in images" :key="img.id">
                                        <div class="position-relative border rounded p-1 bg-light text-center"
                                             style="width: 120px; height: 140px;">
                                            <div class="drag-handle position-absolute top-0 start-0 text-muted ps-1" style="cursor: grab;">☰</div>
                                            <img :src="img.url" class="img-fluid rounded mb-1" style="height: 100px; width: 100%; object-fit: cover;">
                                            <input type="text" class="form-control form-control-sm" placeholder="Alt" x-model="img.alt_text">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 px-2 py-0"
                                                    @click="confirmDelete(img.id)">×</button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Modal de confirmação -->
                            <template x-if="showDelete">
                                <div class="modal fade show d-block bg-dark bg-opacity-50">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Remover Imagem</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tens a certeza que queres eliminar esta imagem?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary btn-sm" @click="showDelete=false">Cancelar</button>
                                                <button class="btn btn-danger btn-sm" @click="deleteImage()">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>


                        <div class="tab-pane fade" id="tab-meta" role="tabpanel"
                             x-data="{
        fieldTitle: 'meta_title',
        fieldDesc: 'meta_description',
        fieldKeys: 'meta_keywords',
        updateMeta() {
            // 🔹 Atualiza sempre o título meta
            this.form[this.fieldTitle] = this.form.name || '';

            // 🔹 Atualiza sempre a descrição meta (primeiros 160 chars, sem HTML)
            const text = (this.form.description || '').replace(/(<([^>]+)>)/gi, '').trim();
            this.form[this.fieldDesc] = text.substring(0, 160);

            // 🔹 Atualiza sempre as keywords
            const raw = (this.form.name || '') + ' ' + (this.form.description || '');
            const words = raw.toLowerCase()
                             .replace(/[^a-zà-ú0-9\s]/gi, '')
                             .split(/\s+/)
                             .filter(w => w.length > 3);
            const uniq = [...new Set(words)].slice(0, 8);
            this.form[this.fieldKeys] = uniq.join(', ');
        }
     }"
                             x-effect="updateMeta()">

                            <div class="row">
                                <div class="col-md-12" x-data="{ field: 'meta_title' }">
                                    <label class="form-label" :for="field">Meta Title</label>
                                    <input type="text" class="form-control" :id="field" :name="field"
                                           x-model="form[field]" placeholder="Título SEO do produto"
                                           :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]">
                                        <small class="text-danger" x-text="errors[field]"></small>
                                    </template>
                                </div>

                                <div class="col-md-12 mt-3" x-data="{ field: 'meta_description' }">
                                    <label class="form-label" :for="field">Meta Description</label>
                                    <textarea class="form-control" :id="field" :name="field" rows="3"
                                              placeholder="Descrição SEO do produto"
                                              x-model="form[field]" :class="{ 'is-invalid': errors[field] }"></textarea>
                                    <template x-if="errors[field]">
                                        <small class="text-danger" x-text="errors[field]"></small>
                                    </template>
                                </div>

                                <div class="col-md-12 mt-3" x-data="{ field: 'meta_keywords' }">
                                    <label class="form-label" :for="field">Meta Keywords</label>
                                    <input type="text" class="form-control" :id="field" :name="field"
                                           placeholder="ex: sapatilhas, running, homem"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                    <template x-if="errors[field]">
                                        <small class="text-danger" x-text="errors[field]"></small>
                                    </template>
                                </div>
                            </div>
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
                        <!-- Estado -->
                        <div class="col-md-6"
                             x-data="{ field: 'status' }"
                             x-init="$nextTick(() => {
            const el = $refs.select;
            $(el).select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            $(el).val(form[field]).trigger('change');
            $(el).on('change', function() {
                form[field] = $(this).val();
            });
            $watch('form[field]', (val) => {
                $(el).val(val).trigger('change.select2');
            });
         })">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :name="field"
                                    x-model="form[field]"
                                    :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                                <option value="draft">Rascunho</option>
                                <option value="archived">Arquivado</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Tipo -->
                        <div class="col-md-6"
                             x-data="{ field: 'type' }"
                             x-init="$nextTick(() => {
            const el = $refs.select;
            $(el).select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            $(el).val(form[field]).trigger('change');
            $(el).on('change', function() {
                form[field] = $(this).val();
            });
            $watch('form[field]', (val) => {
                $(el).val(val).trigger('change.select2');
            });
         })">
                            <label class="form-label" :for="field">Tipo</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    :name="field"
                                    x-model="form[field]"
                                    :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="simple">Simples</option>
                                <option value="configurable">Configurable</option>
                                <option value="virtual">Virtual</option>
                                <option value="pack">Pack</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Visibilidade -->
                        <div class="col-md-6"
                             x-data="{ field: 'visibility' }"
                             x-init="$nextTick(() => {
            const el = $refs.select;
            $(el).select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            $(el).val(form[field]).trigger('change');
            $(el).on('change', function() {
                form[field] = $(this).val();
            });
            $watch('form[field]', (val) => {
                $(el).val(val).trigger('change.select2');
            });
         })">
                            <label class="form-label" :for="field">Visibilidade</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    :name="field"
                                    x-model="form[field]"
                                    :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="both">Catálogo & Pesquisa</option>
                                <option value="catalog">Só Catálogo</option>
                                <option value="search">Só Pesquisa</option>
                                <option value="none">Oculto</option>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <!-- Produto em destaque -->
                        <div class="col-md-6" x-data="{ field: 'is_featured' }">
                            <div class="mb-2">
                                <label class="form-label" :for="field">Produto em Destaque</label>
                                <div>
                                    <input type="checkbox" :id="field" :name="field" value="1"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }" switch="none" />
                                    <label :for="field" data-on-label="Sim" data-off-label="Não"></label>
                                </div>
                                <template x-if="errors[field]">
                                    <small class="text-danger" x-text="errors[field]"></small>
                                </template>
                            </div>
                        </div>
                        <!-- Produto novo -->
                        <div class="col-md-6" x-data="{ field: 'is_new' }">
                            <div class="mb-0">
                                <label class="form-label" :for="field">Produto Novo</label>
                                <div>
                                    <input type="checkbox"
                                           :id="field"
                                           :name="field"
                                           x-model="form[field]"
                                           true-value="1"
                                           false-value="0"
                                           :class="{ 'is-invalid': errors[field] }"
                                           switch="none" />
                                    <label :for="field" data-on-label="Sim" data-off-label="Não"></label>
                                </div>
                                <template x-if="errors[field]">
                                    <small class="text-danger" x-text="errors[field]"></small>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Categorias -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categorias</h4>
                    <p class="card-title-desc">Categorias do produto</p>

                    <div class="row">
                        <div class="col-md-12"
                             x-data="{ field: 'category_id' }"
                             x-init="$nextTick(() => {
                    const el = $refs.select;
                    $(el).select2({
                        width: '100%',
                        minimumResultsForSearch: 0 // 🔹 ativa sempre a pesquisa
                    });
                    $(el).val(form[field]).trigger('change');
                    $(el).on('change', function() {
                        form[field] = $(this).val();
                    });
                    $watch('form[field]', (val) => {
                        $(el).val(val).trigger('change.select2');
                    });
                 })">

                            <label class="form-label" :for="field">Categoria Base</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    :name="field"
                                    x-model="form[field]"
                                    :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($categories ?? [] as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Inventário -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Inventário e Quantidades</h4>
                    <p class="card-title-desc">Gestão de stock</p>
                    <div class="row">
                        <div class="col-md-6" x-data="{ field: 'stock_qty' }">
                            <label class="form-label" :for="field">Qtd. em Stock</label>
                            <input type="number" class="form-control"
                                   :id="field" :name="field" placeholder="0"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>
                        <div class="col-md-6" x-data="{ field: 'manage_stock' }">
                            <div class="mb-2">
                                <label class="form-label" :for="field">Gerir Stock</label>
                                <div>
                                    <input type="checkbox" :id="field" :name="field" value="1"
                                           x-model="form[field]" :class="{ 'is-invalid': errors[field] }" switch="none" />
                                    <label :for="field" data-on-label="Sim" data-off-label="Não"></label>
                                </div>
                                <template x-if="errors[field]">
                                    <small class="text-danger" x-text="errors[field]"></small>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Fornecedores -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Fornecedores</h4>
                    <p class="card-title-desc">Informações de fornecedores e marcas</p>

                    <div class="row">
                        <!-- Fornecedor -->
                        <div class="col-md-6"
                             x-data="{ field: 'supplier_id' }"
                             x-init="$nextTick(() => {
                    const el = $refs.select;
                    $(el).select2({
                        width: '100%',
                        minimumResultsForSearch: 0 // 🔹 ativa pesquisa sempre
                    });
                    $(el).val(form[field]).trigger('change');
                    $(el).on('change', function() {
                        form[field] = $(this).val();
                    });
                    $watch('form[field]', (val) => {
                        $(el).val(val).trigger('change.select2');
                    });
                 })">

                            <label class="form-label" :for="field">Fornecedor</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    :name="field"
                                    x-model="form[field]"
                                    :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($suppliers ?? [] as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>"><?= esc($supplier['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <template x-if="errors[field]">
                                <small class="text-danger" x-text="errors[field]"></small>
                            </template>
                        </div>

                        <!-- Marca -->
                        <div class="col-md-6"
                             x-data="{ field: 'brand_id' }"
                             x-init="$nextTick(() => {
                    const el = $refs.select;
                    $(el).select2({
                        width: '100%',
                        minimumResultsForSearch: 0 // 🔹 ativa pesquisa sempre
                    });
                    $(el).val(form[field]).trigger('change');
                    $(el).on('change', function() {
                        form[field] = $(this).val();
                    });
                    $watch('form[field]', (val) => {
                        $(el).val(val).trigger('change.select2');
                    });
                 })">

                            <label class="form-label" :for="field">Marca</label>
                            <select class="form-select select2"
                                    x-ref="select"
                                    :id="field"
                                    :name="field"
                                    x-model="form[field]"
                                    :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($brands ?? [] as $brand): ?>
                                    <option value="<?= $brand['id'] ?>"><?= esc($brand['name']) ?></option>
                                <?php endforeach; ?>
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

<div x-data="{
        current: {},
        modal: null,
        open(v) {
            this.current = JSON.parse(JSON.stringify(v));
            if (!this.modal) {
                this.modal = new bootstrap.Modal($refs.modal);
            }
            this.modal.show();
        },
        save() {
            form.updateVariant(this.current);
            if (this.modal) this.modal.hide();
        }
    }"
     @variant-edit.window="open($event.detail)">

    <div class="modal fade" tabindex="-1" aria-hidden="true" x-ref="modal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Variante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#labels" role="tab" aria-selected="true">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Etiquetas</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#prices" role="tab" aria-selected="false" tabindex="-1">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Valores de Venda</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transport" role="tab" aria-selected="false" tabindex="-1">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Dimenções</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#multimédia" role="tab" aria-selected="false" tabindex="-1">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Multimédia</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="labels" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">SKU</label>
                                            <input type="text" class="form-control" x-model="current.sku">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label">EAN</label>
                                            <input type="text" class="form-control" x-model="current.ean">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">UPC</label>
                                            <input type="text" class="form-control" x-model="current.upc">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">ISB</label>
                                            <input type="text" class="form-control" x-model="current.isb">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">GTIN</label>
                                            <input type="text" class="form-control" x-model="current.gtin">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="prices" role="tabpanel">
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Preço Custo</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.cost_price">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Preço Base</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.base_price">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Preço + IVA</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.base_price_tax">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Preço Especial</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.special_price">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Tipo Desconto</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.discount_type">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Valor Desconto</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.discount_value">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Desde</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.special_price_start">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Até</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.special_price_end">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="transport" role="tabpanel">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label">Peso (kg)</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.weight">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Largura (cm)</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.width">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Altura (cm)</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.height">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Comprimento (cm)</label>
                                            <input type="number" step="0.01" class="form-control" x-model="current.length">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="multimédia" role="tabpanel">
                                    <div class="row g-3 align-items-end">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div>
                                                    <img src="assets/images/users/avatar-3.jpg" alt="" class="rounded avatar-sm">
                                                    <p class="mt-2 mb-lg-0"><code>.avatar-sm</code></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <img src="assets/images/users/avatar-4.jpg" alt="" class="rounded avatar-md">
                                                    <p class="mt-2  mb-lg-0"><code>.avatar-md</code></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded avatar-lg">
                                                    <p class="mt-2 mb-lg-0"><code>.avatar-lg</code></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select" x-model="current.status">
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label">Stock</label>
                                    <input type="number" class="form-control" x-model="current.stock_qty">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-block">Gerir Stock</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               role="switch"
                                               id="manageStock"
                                               x-model="current.manage_stock"
                                               :true-value="1"
                                               :false-value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" @click="save()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div x-data="{ showDelete: false, deleteId: null }">
    <template x-if="showDelete">
        <div class="modal fade show d-block bg-dark bg-opacity-50" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Remover imagem</h5>
                    </div>
                    <div class="modal-body">
                        <p>Tens a certeza que queres eliminar esta imagem?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" @click="showDelete = false">Cancelar</button>
                        <button class="btn btn-danger btn-sm"
                                @click="
                                    fetch(`/admin/catalog/products/delete-image/${deleteId}`, { method: 'DELETE' })
                                        .then(() => {
                                            form.images = form.images.filter(img => img.id !== deleteId);
                                            showDelete = false;
                                        });
                                ">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>


<?= $this->endSection() ?>
<?= $this->section('content-script') ?>
<!-- Plugins js -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="<?= base_url('assets/js/axs_alp.min.js') ?>"></script>
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
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productForm', () => ({
            form: {},
            errors: {},

            updatePromo() {
                const base = parseFloat(this.form.base_price) || 0;
                const tax  = parseFloat(this.form.tax_rate) || 0;
                const val  = parseFloat(this.form.discount_value) || 0;
                const type = this.form.discount_type;

                // Preço base + imposto
                const priceWithTax = base * (1 + tax / 100);
                this.form.base_price_tax = priceWithTax.toFixed(2);

                // Cálculo do preço promocional
                if (type === 'percent') {
                    this.form.special_price = (priceWithTax - (priceWithTax * val / 100)).toFixed(2);
                } else if (type === 'fixed') {
                    this.form.special_price = (priceWithTax - val).toFixed(2);
                } else {
                    this.form.special_price = priceWithTax.toFixed(2);
                }
            }
        }));
    });
</script>

<?= $this->endSection() ?>
