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
                <i class="far fa-save me-1"></i> Guardar
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
                                            $('#description').summernote('code', form.description);
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
                            <div x-show="form.type != 'configurable'">
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

                            <!-- Caso o produto seja CONFIGURÁVEL -->
                            <div x-show="form.type === 'configurable'" class="alert alert-info text-center p-4 mt-3">
                                <i class="mdi mdi-information-outline fs-4 d-block mb-2"></i>
                                Este produto é <strong>configurável</strong>. <br>
                                Os preços, promoções e impostos são definidos individualmente em cada <strong>variante</strong>.
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-composicao" role="tabpanel">
                            <!-- Campos de Identificação (só para produtos simples) -->
                            <div x-show="form.type != 'configurable' ">
                                <div class="row">
                                    <div class="col-md-4" x-data="{ field: 'sku' }">
                                        <label class="form-label" :for="field">SKU</label>
                                        <input type="text" class="form-control"
                                               :id="field" :name="field"
                                               placeholder="ex: PROD12345"
                                               x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                        <template x-if="errors[field]">
                                            <small class="text-danger" x-text="errors[field]"></small>
                                        </template>
                                    </div>

                                    <div class="col-md-4" x-data="{ field: 'ean' }">
                                        <label class="form-label" :for="field">EAN</label>
                                        <input type="text" class="form-control"
                                               :id="field" :name="field"
                                               placeholder="EAN do produto"
                                               x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                        <template x-if="errors[field]">
                                            <small class="text-danger" x-text="errors[field]"></small>
                                        </template>
                                    </div>

                                    <div class="col-md-4" x-data="{ field: 'upc' }">
                                        <label class="form-label" :for="field">UPC</label>
                                        <input type="text" class="form-control"
                                               :id="field" :name="field"
                                               placeholder="UPC do produto"
                                               x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                        <template x-if="errors[field]">
                                            <small class="text-danger" x-text="errors[field]"></small>
                                        </template>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-4" x-data="{ field: 'isbn' }">
                                        <label class="form-label" :for="field">ISBN</label>
                                        <input type="text" class="form-control"
                                               :id="field" :name="field"
                                               placeholder="ISBN"
                                               x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                        <template x-if="errors[field]">
                                            <small class="text-danger" x-text="errors[field]"></small>
                                        </template>
                                    </div>

                                    <div class="col-md-4" x-data="{ field: 'gtin' }">
                                        <label class="form-label" :for="field">GTIN</label>
                                        <input type="text" class="form-control"
                                               :id="field" :name="field"
                                               placeholder="GTIN do produto"
                                               x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                        <template x-if="errors[field]">
                                            <small class="text-danger" x-text="errors[field]"></small>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <!-- Mensagem caso seja configurável -->
                            <div x-show="form.type === 'configurable'" class="alert alert-info text-center mt-3">
                                <i class="mdi mdi-information-outline"></i>
                                Os identificadores (SKU, EAN, UPC, ISBN, GTIN) são definidos individualmente em cada variante.
                            </div>
                            <div class="row mt-3">
                                <div x-show="form.type === 'configurable'" class="mt-0 pt-0"
                                     x-data="{
                                        showDeleteVariant: false,
                                        showEditVariant: false,
                                        variantToDelete: null,
                                        current: {},
                                        confirmDeleteVariant(variant) {
                                            this.variantToDelete = variant;
                                            this.showDeleteVariant = true;
                                        },
                                        async deleteVariant() {
                                            if (!this.variantToDelete?.id) return;
                                            const csrfMatch = document.cookie.match(/csrf_cookie_name=([^;]+)/);
                                            const csrf = csrfMatch ? decodeURIComponent(csrfMatch[1]) : null;
                                            await fetch(`/admin/catalog/products/variants/delete/${this.variantToDelete.id}`, {
                                                method: 'DELETE',
                                                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                                                credentials: 'include'
                                            });
                                            form.productsVariants = form.productsVariants.filter(v => v.id !== this.variantToDelete.id);
                                            this.showDeleteVariant = false;
                                            this.variantToDelete = null;
                                        },
                                        openEditVariant(variant) {
                                            this.current = JSON.parse(JSON.stringify(variant));
                                            this.showEditVariant = true;
                                            this.$nextTick(() => {
                                                this.$watch('current', (newVal) => {
                                                    if (!newVal || !newVal.id) return;
                                                    const v = form.productsVariants.find(v => v.id == newVal.id);
                                                    if (v) Object.assign(v, JSON.parse(JSON.stringify(newVal)));
                                                }, { deep: true });
                                            });
                                        },
                                        saveVariant() {
                                            this.updateVariant(this.current);
                                            this.showEditVariant = false;
                                        },
                                       updateVariant(variant) {
                                            if (!variant?.id) {
                                                console.warn('⚠️ Variante sem ID, não pode ser atualizada:', variant);
                                                showToast('Erro: ID da variante em falta.', 'error', '⚠️ Erro');
                                                return;
                                            }
                                            const csrfName = '<?= csrf_token() ?>';
                                            const csrfValue = this[csrfName];
                                            const payload = JSON.parse(JSON.stringify(variant));
                                            payload[csrfName] = csrfValue;

                                            fetch('<?= base_url('admin/catalog/products/variants/update') ?>', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'X-CSRF-TOKEN': csrfValue
                                                },
                                                body: JSON.stringify(payload)
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    showToast(`Variante ${variant.sku} atualizada com sucesso`, 'success', 'Sucesso');
                                                } else {
                                                    showToast(data.message || 'Erro ao atualizar variante.', 'error', '❌ Falha');
                                                }
                                            })
                                            .catch(err => {
                                                console.error('Erro de rede:', err);
                                                showToast('Erro de rede ao atualizar variante.', 'error', '⚠️ Erro');
                                            });
                                        },
                                        showCreateVariant: false,
                                        productAttributes: JSON.parse(`<?= htmlspecialchars($attributes, ENT_QUOTES, 'UTF-8') ?>`),
                                        selectedAttributes: {},
                                        newVariantSkuBase: '',
                                        async createVariantFromAttributes() {
                                            const csrfName = '<?= csrf_token() ?>';
                                            const csrfValue = this[csrfName];

                                            if (Object.keys(this.selectedAttributes).length === 0) {
                                                showToast('Selecione pelo menos um atributo.', 'error', '❌ Falha');
                                                return;
                                            }
                                        const selectedCombo = Object.values(this.selectedAttributes).sort().join('-');
                                        const duplicate = form.productsVariants.some(v => {
                                            if (!Array.isArray(v.attributes)) return false;
                                            const combo = [...v.attributes].sort().join('-');
                                            return combo === selectedCombo;
                                        });

                                        if (duplicate) {
                                            showToast('Já existe uma variante com esta combinação de atributos.', 'warning', '⚠️ Duplicado');
                                            return;
                                        }
                                            const payload = {
                                                [csrfName]: csrfValue,
                                                product_id: form.id,
                                                attributes: this.selectedAttributes,
                                                sku_base: this.newVariantSkuBase
                                            };
                                            try {
                                                const res = await fetch('<?= base_url('admin/catalog/products/variants/create') ?>', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-Requested-With': 'XMLHttpRequest',
                                                        'X-CSRF-TOKEN': csrfValue
                                                    },
                                                    body: JSON.stringify(payload)
                                                });
                                                const data = await res.json();
                                                if (data.success) {
                                                    form.productsVariants.push(data.variant);
                                                    showToast('Variante criada com sucesso!', 'success', '✅ Sucesso');
                                                    this.showCreateVariant = false;
                                                    this.selectedAttributes = {};
                                                    this.openEditVariant(data.variant);
                                                } else {
                                                    showToast(data.message || 'Erro ao criar variante.', 'error', '❌ Falha');
                                                }
                                            } catch (err) {
                                                console.error(err);
                                                showToast('Erro de rede ao criar variante.', 'error', '⚠️ Erro');
                                            }
                                        },
                                        updateManageStock(event) {
                                            this.current.manage_stock = event.target.checked ? 1 : 0;
                                            const v = form.productsVariants.find(v => v.id == this.current.id);
                                            if (v) v.manage_stock = this.current.manage_stock;
                                        },

                                        updateStockQty() {
                                            const v = form.productsVariants.find(v => v.id == this.current.id);
                                            if (v) v.stock_qty = this.current.stock_qty;
                                        },
                                    }">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Variantes</h5>
                                        <button type="button" class="btn btn-success btn-sm" @click="showCreateVariant = true">
                                            <i class="mdi mdi-plus"></i> Nova Variante
                                        </button>
                                    </div>
                                    <template x-if="form.productsVariants.length > 0">
                                        <table class="table table-bordered align-middle mt-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="15%">SKU222</th>
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
                                                        <input type="text" class="form-control form-control-sm"
                                                               x-model="variant.sku" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                                               x-model="variant.cost_price" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                                               x-model="variant.base_price" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                                               x-model="variant.base_price_tax" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm"
                                                               x-model="variant.stock_qty"
                                                               :disabled="variant.manage_stock != 1"
                                                               @change="updateVariant(variant)">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <input type="checkbox" class="form-check-input"
                                                                   :id="'manage_'+index"
                                                                   :checked="variant.manage_stock == 1 || variant.manage_stock === '1'"
                                                                   @change="variant.manage_stock = $event.target.checked ? 1 : 0; updateVariant(variant)">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="default_variant"
                                                               :id="'default_'+index" :value="variant.sku"
                                                               :checked="variant.is_default == 1 || variant.is_default === '1'"
                                                               @change="form.defaultVariantSku = variant.sku; form.productsVariants.forEach(v => v.is_default = (v.sku === variant.sku ? 1 : 0)); updateVariant(variant)">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button type="button" class="btn btn-primary" @click="openEditVariant(variant)">Editar</button>
                                                            <button type="button" class="btn btn-danger" @click="confirmDeleteVariant(variant)">Eliminar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>
                                    </template>
                                    <!-- modal inline -->
                                    <template x-if="showEditVariant">
                                        <div class="modal fade show d-block bg-dark bg-opacity-50">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <!-- MODAL INLINE COMPLETO -->
                                                <template x-if="showEditVariant">
                                                    <div class="modal fade show d-block bg-dark bg-opacity-50">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Editar Variante</h5>
                                                                    <button type="button" class="btn-close" @click="showEditVariant=false"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-8">
                                                                            <!-- Nav tabs -->
                                                                            <ul class="nav nav-tabs" role="tablist">
                                                                                <li class="nav-item" role="presentation">
                                                                                    <a class="nav-link active" data-bs-toggle="tab" href="#labels" role="tab" aria-selected="true">
                                                                                        <span class="d-none d-sm-block">Composição</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item" role="presentation">
                                                                                    <a class="nav-link" data-bs-toggle="tab" href="#prices" role="tab">Valores</a>
                                                                                </li>
                                                                                <li class="nav-item" role="presentation">
                                                                                    <a class="nav-link" data-bs-toggle="tab" href="#transport" role="tab">Dimensões</a>
                                                                                </li>
                                                                                <li class="nav-item" role="presentation">
                                                                                    <a class="nav-link" data-bs-toggle="tab" href="#multimédia" role="tab">Multimédia</a>
                                                                                </li>
                                                                            </ul>
                                                                            <!-- Tab panes -->
                                                                            <div class="tab-content p-3 text-muted">
                                                                                <!-- COMPOSIÇÃO -->
                                                                                <div class="tab-pane active" id="labels" role="tabpanel">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label">SKU</label>
                                                                                            <input type="text" class="form-control" x-model="current.sku">
                                                                                        </div>
                                                                                        <div class="col-md-4"><label class="form-label">EAN</label><input type="text" class="form-control" x-model="current.ean"></div>
                                                                                        <div class="col-md-4"><label class="form-label">UPC</label><input type="text" class="form-control" x-model="current.upc"></div>
                                                                                        <div class="col-md-4 mt-2"><label class="form-label">ISBN</label><input type="text" class="form-control" x-model="current.isbn"></div>
                                                                                        <div class="col-md-4 mt-2"><label class="form-label">GTIN</label><input type="text" class="form-control" x-model="current.gtin"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- VALORES -->
                                                                                <div class="tab-pane fade show" id="prices" role="tabpanel"
                                                                                     x-init="
                                                                                        $nextTick(() => {
                                                                                            const start = $refs.startDate;
                                                                                            const end = $refs.endDate;

                                                                                            $.fn.datepicker.defaults.zIndexOffset = 99999;
                                                                                            $(end).prop('disabled', true);

                                                                                            // === Início Promoção ===
                                                                                            $(start).datepicker({
                                                                                                format: 'dd-mm-yyyy',
                                                                                                autoclose: true,
                                                                                                todayHighlight: true,
                                                                                                container: $(start).closest('.modal-content'),
                                                                                                orientation: 'bottom',
                                                                                                startDate: new Date() // 🔹 mínimo = hoje
                                                                                            }).on('changeDate', function () {
                                                                                                const startDate = $(start).datepicker('getDate');
                                                                                                current.special_price_start = $(start).val();

                                                                                                if (startDate) {
                                                                                                    // Calcula o mínimo do fim = início + 1 dia
                                                                                                    const minEndDate = new Date(startDate);
                                                                                                    minEndDate.setDate(minEndDate.getDate() + 1);

                                                                                                    // Ativa e reconfigura o campo fim
                                                                                                    $(end).prop('disabled', false);
                                                                                                    $(end).datepicker('setStartDate', minEndDate);

                                                                                                    // Se a data atual do fim for inválida ou nula → substitui automaticamente
                                                                                                    const endDate = $(end).datepicker('getDate');
                                                                                                    if (!endDate || endDate < minEndDate) {
                                                                                                        $(end).datepicker('update', minEndDate);
                                                                                                        current.special_price_end = $(end).val();
                                                                                                    }
                                                                                                } else {
                                                                                                    // Se o início for apagado → limpa e desativa o fim
                                                                                                    $(end).prop('disabled', true);
                                                                                                    $(end).datepicker('clearDates');
                                                                                                    current.special_price_end = '';
                                                                                                }
                                                                                            });

                                                                                            // === Fim Promoção ===
                                                                                            $(end).datepicker({
                                                                                                format: 'dd-mm-yyyy',
                                                                                                autoclose: true,
                                                                                                todayHighlight: true,
                                                                                                container: $(end).closest('.modal-content'),
                                                                                                orientation: 'bottom'
                                                                                            }).on('changeDate', function () {
                                                                                                current.special_price_end = $(end).val();
                                                                                            });
                                                                                        });
                                                                                        ">
                                                                                    <div class="row mt-2">
                                                                                        <!-- Preço Custo -->
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label" for="current_cost_price">Preço de Custo</label>
                                                                                            <input type="number" step="0.01" class="form-control"
                                                                                                   id="current_cost_price" x-model="current.cost_price" placeholder="0.00">
                                                                                        </div>
                                                                                        <!-- Preço Base -->
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label" for="current_base_price">Preço Base</label>
                                                                                            <input type="number" step="0.01" class="form-control"
                                                                                                   id="current_base_price" x-model="current.base_price" placeholder="0.00"
                                                                                                   @input="
                                                                                                    const base = parseFloat(current.base_price) || 0;
                                                                                                    const tax = parseFloat(current.tax_rate) || 0;
                                                                                                    current.base_price_tax = (base * (1 + tax / 100)).toFixed(2);

                                                                                                    if (current.discount_type && current.discount_value) {
                                                                                                        const val = parseFloat(current.discount_value) || 0;
                                                                                                        if (current.discount_type === 'percent') {
                                                                                                            current.special_price = (current.base_price_tax - (current.base_price_tax * val / 100)).toFixed(2);
                                                                                                        } else if (current.discount_type === 'fixed') {
                                                                                                            current.special_price = (current.base_price_tax - val).toFixed(2);
                                                                                                        }
                                                                                                    }
                                                                                               ">
                                                                                        </div>
                                                                                        <!-- IVA -->
                                                                                        <div class="col-md-4"
                                                                                             x-data="{ field: 'tax_class_id' }"
                                                                                             x-init="$nextTick(() => {
                                                                                                const el = $refs.select;
                                                                                                $(el).select2({
                                                                                                    width: '100%',
                                                                                                    placeholder: '-- Selecionar --',
                                                                                                    minimumResultsForSearch: Infinity,
                                                                                                    dropdownParent: $(el).closest('.modal-content')
                                                                                                });
                                                                                                $(el).val(current[field]).trigger('change.select2');
                                                                                                $(el).on('change', function () {
                                                                                                    const val = $(this).val();
                                                                                                    current[field] = val;
                                                                                                    const selected = $(this).find(':selected');
                                                                                                    const tax = parseFloat(selected.data('rate')) || 0;
                                                                                                    current.tax_rate = tax;
                                                                                                    const base = parseFloat(current.base_price) || 0;
                                                                                                    current.base_price_tax = (base * (1 + tax / 100)).toFixed(2);
                                                                                                    if (current.discount_type && current.discount_value) {
                                                                                                        const discVal = parseFloat(current.discount_value) || 0;
                                                                                                        if (current.discount_type === 'percent') {
                                                                                                            current.special_price = (current.base_price_tax - (current.base_price_tax * discVal / 100)).toFixed(2);
                                                                                                        } else if (current.discount_type === 'fixed') {
                                                                                                            current.special_price = (current.base_price_tax - discVal).toFixed(2);
                                                                                                        }
                                                                                                    }
                                                                                                });
                                                                                                $watch('current[field]', (val) => {
                                                                                                    setTimeout(() => {
                                                                                                        $(el).val(val).trigger('change.select2');
                                                                                                    }, 10);
                                                                                                });
                                                                                             })">
                                                                                            <label class="form-label" :for="field">Taxa (IVA)</label>
                                                                                            <select class="form-select select2"
                                                                                                    x-ref="select"
                                                                                                    :id="field"
                                                                                                    name="tax_class_id">
                                                                                                <option value="">-- Selecionar --</option>
                                                                                                <?php foreach ($product_tax ?? [] as $tax): ?>
                                                                                                    <option value="<?= $tax['id'] ?>"
                                                                                                            data-rate="<?= esc($tax['rate']) ?>"
                                                                                                            <?= ($product['tax_class_id'] ?? '') == $tax['id'] ? 'selected' : '' ?>>
                                                                                                        <?= esc($tax['name']) ?> — <?= esc($tax['rate']) ?>%
                                                                                                    </option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </div>

                                                                                    </div>
                                                                                    <!-- Preço + IVA -->
                                                                                    <div class="col-md-4">
                                                                                        <label class="form-label" for="current_base_price_tax">Preço Base + Imposto</label>
                                                                                        <input type="number" step="0.01" class="form-control"
                                                                                               id="current_base_price_tax" x-model="current.base_price_tax"
                                                                                               placeholder="0.00" disabled>
                                                                                    </div>

                                                                                    <div class="row mt-3">
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label">Início Promoção</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control"
                                                                                                       placeholder="dd-mm-yyyy"
                                                                                                       x-ref="startDate"
                                                                                                       x-model="current.special_price_start">
                                                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label">Fim Promoção</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control"
                                                                                                       placeholder="dd-mm-yyyy"
                                                                                                       x-ref="endDate"
                                                                                                       x-model="current.special_price_end">
                                                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="row mt-3">
                                                                                        <!-- Tipo de Desconto -->
                                                                                        <div class="col-md-4"
                                                                                             x-data="{ field: 'discount_type' }"
                                                                                             x-init="$nextTick(() => {
                                                                                                const el = $refs.select;
                                                                                                $(el).select2({
                                                                                                    width: '100%',
                                                                                                    placeholder: '-- Selecionar --',
                                                                                                    minimumResultsForSearch: Infinity,
                                                                                                    dropdownParent: $(el).closest('.modal-content')
                                                                                                });
                                                                                                $(el).val(current[field]).trigger('change.select2');
                                                                                                $(el).on('change', function () {
                                                                                                    const val = $(this).val();
                                                                                                    current[field] = val;
                                                                                                    const base = parseFloat(current.base_price_tax) || 0;
                                                                                                    const discVal = parseFloat(current.discount_value) || 0;
                                                                                                    if (val === 'percent') {
                                                                                                        current.special_price = (base - (base * discVal / 100)).toFixed(2);
                                                                                                    } else if (val === 'fixed') {
                                                                                                        current.special_price = (base - discVal).toFixed(2);
                                                                                                    } else {
                                                                                                        current.special_price = base.toFixed(2);
                                                                                                    }
                                                                                                });
                                                                                                $watch('current[field]', (val) => {
                                                                                                    setTimeout(() => {
                                                                                                        $(el).val(val).trigger('change.select2');
                                                                                                    }, 10);
                                                                                                });
                                                                                             })">
                                                                                            <label class="form-label" :for="field">Tipo de Desconto</label>
                                                                                            <select class="form-select select2"
                                                                                                    x-ref="select"
                                                                                                    :id="field"
                                                                                                    name="discount_type">
                                                                                                <option value="">-- Selecionar --</option>
                                                                                                <option value="percent">Percentagem (%)</option>
                                                                                                <option value="fixed">Valor Fixo (€)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- Valor Desconto -->
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label">Valor Desconto</label>
                                                                                            <input type="number" step="0.01" class="form-control"
                                                                                                   x-model="current.discount_value" placeholder="0.00"
                                                                                                   @input="
                                                                                                    const base = parseFloat(current.base_price_tax) || 0;
                                                                                                    const val  = parseFloat(current.discount_value) || 0;
                                                                                                    if (current.discount_type === 'percent') {
                                                                                                        current.special_price = (base - (base * val / 100)).toFixed(2);
                                                                                                    } else if (current.discount_type === 'fixed') {
                                                                                                        current.special_price = (base - val).toFixed(2);
                                                                                                    } else {
                                                                                                        current.special_price = base.toFixed(2);
                                                                                                    }
                                                                                               ">
                                                                                        </div>
                                                                                        <!-- Preço Promocional -->
                                                                                        <div class="col-md-4">
                                                                                            <label class="form-label">Preço Promocional</label>
                                                                                            <input type="number" step="0.01" class="form-control"
                                                                                                   x-model="current.special_price" placeholder="0.00" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- TRANSPORTE -->
                                                                                <div class="tab-pane" id="transport" role="tabpanel">
                                                                                    <div class="row g-3 align-items-end">
                                                                                        <div class="col-md-3"><label class="form-label">Peso (kg)</label><input type="number" step="0.01" class="form-control" x-model="current.weight"></div>
                                                                                        <div class="col-md-3"><label class="form-label">Largura (cm)</label><input type="number" step="0.01" class="form-control" x-model="current.width"></div>
                                                                                        <div class="col-md-3"><label class="form-label">Altura (cm)</label><input type="number" step="0.01" class="form-control" x-model="current.height"></div>
                                                                                        <div class="col-md-3"><label class="form-label">Comprimento (cm)</label><input type="number" step="0.01" class="form-control" x-model="current.length"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- MULTIMÉDIA -->
                                                                                <div class="tab-pane fade" id="multimédia" role="tabpanel"
                                                                                     x-data="{
                                                                                         images: current.images || [],
                                                                                         variantId: current.id,
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
                                                                                                 formData.append('owner_type', 'variant');
                                                                                                 formData.append('owner_id', this.variantId);
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
                                                                                                     await this.reorderImages();
                                                                                                 }
                                                                                             });
                                                                                         }
                                                                                     }"
                                                                                                                                                                     x-init="initSortable()">

                                                                                    <h4 class="card-title">Imagens da Variante</h4>
                                                                                    <p class="card-title-desc">Carregar, ordenar e eliminar imagens.</p>

                                                                                    <input type="file" multiple accept="image/*" class="form-control mb-3"
                                                                                           @change="addFiles($event)" :disabled="uploading">

                                                                                    <div class="d-flex flex-wrap gap-3" x-ref="list">
                                                                                        <template x-for="(img, index) in images" :key="img.id">
                                                                                            <div class="position-relative border rounded p-1 bg-light text-center"
                                                                                                 style="width: 120px; height: 140px;">
                                                                                                <div class="drag-handle position-absolute top-0 start-0 text-muted ps-1"
                                                                                                     style="cursor: grab;">☰</div>
                                                                                                <img :src="img.url" class="img-fluid rounded mb-1"
                                                                                                     style="height: 100px; width: 100%; object-fit: cover;">
                                                                                                <input type="text" class="form-control form-control-sm"
                                                                                                       placeholder="Alt" x-model="img.alt_text">
                                                                                                <button type="button"
                                                                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 px-2 py-0"
                                                                                                        @click="confirmDelete(img.id)">×</button>
                                                                                            </div>
                                                                                        </template>
                                                                                    </div>

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

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <div class="row">
                                                                                <div class="col-md-12"
                                                                                     x-data="{ field: 'status' }"
                                                                                     x-init="$nextTick(() => {
                                                                                        const el = $refs.select;
                                                                                        $(el).select2({
                                                                                            width: '100%',
                                                                                            placeholder: '-- Selecionar --',
                                                                                            minimumResultsForSearch: Infinity,
                                                                                            dropdownParent: $(el).closest('.modal-content')
                                                                                        });
                                                                                        $(el).val(current[field]).trigger('change.select2');
                                                                                        $(el).on('change', function () {
                                                                                            current[field] = $(this).val();
                                                                                        });
                                                                                        $watch('current[field]', (val) => {
                                                                                            setTimeout(() => {
                                                                                                $(el).val(val).trigger('change.select2');
                                                                                            }, 10);
                                                                                        });
                                                                                     })">
                                                                                    <label class="form-label" :for="field">Estado</label>
                                                                                    <select class="form-select select2"
                                                                                            x-ref="select"
                                                                                            :id="field"
                                                                                            name="status">
                                                                                        <option value="1">Ativo</option>
                                                                                        <option value="0">Inativo</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mt-2 align-items-center">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label d-block">Gerir Stock</label>
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input"
                                                                                               type="checkbox"
                                                                                               :checked="current.manage_stock == 1 || current.manage_stock === '1'"
                                                                                               @change="updateManageStock">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Stock</label>
                                                                                    <input type="number"
                                                                                           class="form-control"
                                                                                           x-model="current.stock_qty"
                                                                                           :disabled="Number(current.manage_stock) !== 1"
                                                                                           @input="updateStockQty">
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" @click="showEditVariant=false">Fechar</button>
                                                                    <button type="button" class="btn btn-success" @click="updateVariant(current); showEditVariant=false">Guardar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="showDeleteVariant">
                                        <div class="modal fade show d-block bg-dark bg-opacity-50">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Eliminar Variante</h5>
                                                        <button type="button" class="btn-close" @click="showDeleteVariant=false"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Tem a certeza que quer eliminar a variante <strong x-text="variantToDelete?.sku"></strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" @click="showDeleteVariant=false">Cancelar</button>
                                                        <button type="button" class="btn btn-danger" @click="deleteVariant()">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <!-- MODAL CRIAR VARIANTE -->
                                    <template x-if="showCreateVariant">
                                        <div class="modal fade show d-block bg-dark bg-opacity-50">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Nova Variante — Selecionar Atributos</h5>
                                                        <button type="button" class="btn-close" @click="showCreateVariant = false"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-info mb-3">
                                                            Escolha os atributos que compõem esta variante.
                                                        </div>
                                                        <div class="row g-3">
                                                            <template x-for="attr in productAttributes" :key="attr.id">
                                                                <div class="col-md-4">
                                                                    <label class="form-label" x-text="attr.name"></label>
                                                                    <select class="form-select form-select-sm"
                                                                            x-model="selectedAttributes[attr.id]">
                                                                        <option value="">-- Selecionar --</option>
                                                                        <template x-for="val in attr.values" :key="val.id">
                                                                            <option :value="val.id" x-text="val.value"></option>
                                                                        </template>
                                                                    </select>
                                                                </div>
                                                            </template>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">SKU base</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                       placeholder="ex: P1-OA030"
                                                                       x-model="newVariantSkuBase">
                                                                <small class="text-muted">Será usado como prefixo do SKU final.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" @click="showCreateVariant = false">Cancelar</button>
                                                        <button type="button" class="btn btn-success" @click="createVariantFromAttributes()">Criar Variante</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <!-- CAMPOS DE PRODUTO VIRTUAL -->
                                <div x-show="form.type === 'virtual'">
                                    <div x-data="{
            form: {
                id: '<?= esc($product['id']) ?>',
                type: '<?= esc($product['type']) ?>',
                virtual_type: '<?= esc($product['virtual_type'] ?? '') ?>',
                virtual_file: '<?= esc($product['virtual_file'] ?? '') ?>',
                virtual_url: '<?= esc($product['virtual_url'] ?? '') ?>',
                virtual_expiry_days: '<?= esc($product['virtual_expiry_days'] ?? 0) ?>'
            },
            uploading: false,

            get productId() {
                return this.form.id || null;
            },

            async uploadVirtualFile(event) {
                const file = event.target.files[0];
                if (!file || !this.productId) return;

                const formData = new FormData();
                formData.append('file', file);

                this.uploading = true;

                try {
                    const res = await fetch(`/admin/catalog/products/virtuals/upload/${this.productId}`, {
                        method: 'POST',
                        body: formData,
                        credentials: 'include'
                    });

                    const data = await res.json();
                    console.log('Resposta upload:', data);

     if (data?.path) {
        // Usa exatamente o URL devolvido pelo servidor, apenas limpa barras extra
        this.form.virtual_file = data.path.replace(/^\/+/, '');
        await this.saveVirtualConfig();
    } else {
        console.warn('Upload falhou:', data);
    }


                } catch (err) {
                    console.error('Erro ao enviar ficheiro virtual:', err);
                } finally {
                    this.uploading = false;
                    event.target.value = '';
                }
            },

            async saveVirtualConfig() {
                if (!this.productId) return;

                const payload = {
                    virtual_type: this.form.virtual_type,
                    virtual_url: this.form.virtual_url,
                    virtual_expiry_days: this.form.virtual_expiry_days,
                    virtual_file: this.form.virtual_file
                };

                try {
                    const res = await fetch(`/admin/catalog/products/virtuals/save/${this.productId}`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload),
                        credentials: 'include'
                    });

                    const data = await res.json();
                    console.log('Resposta save:', data);

                    if (data?.success) {
                        console.log('✅ Configurações virtuais guardadas com sucesso.');
                    } else {
                        console.warn('⚠️ Falha ao guardar produto virtual.', data);
                    }
                } catch (err) {
                    console.error('Erro no saveVirtualConfig:', err);
                }
            }
        }">
                                    <h5 class="mb-3">Configurações do Produto Virtual</h5>

                                    <div class="row g-3">
                                        <!-- Tipo de Entrega -->
                                        <div class="col-md-4" x-data="{ field: 'virtual_type' }">
                                            <label class="form-label" :for="field">Tipo de Conteúdo</label>
                                            <select class="form-select" :id="field" x-model="form[field]" @change="saveVirtualConfig()">
                                                <option value="">-- Selecionar --</option>
                                                <option value="download">Download Digital</option>
                                                <option value="service">Serviço / Subscrição</option>
                                                <option value="license">Licença Digital</option>
                                            </select>
                                        </div>

                                        <!-- Upload de Ficheiro -->
                                        <div class="col-md-8" x-show="form.virtual_type === 'download'">
                                            <label class="form-label">Ficheiro Digital</label>
                                            <input type="file" class="form-control" @change="uploadVirtualFile($event)">
                                            <small class="text-muted">Formatos permitidos: PDF, ZIP, MP3, JPG, etc.</small>

                                            <template x-if="form.virtual_file">
                                                <div class="mt-2">
                                                    <a :href="form.virtual_file" target="_blank" class="text-success">
                                                        <i class="mdi mdi-file"></i> Ver ficheiro atual
                                                    </a>
                                                </div>
                                            </template>

                                            <template x-if="uploading">
                                                <div class="mt-2 text-info">
                                                    <i class="mdi mdi-loading mdi-spin"></i> A enviar ficheiro...
                                                </div>
                                            </template>
                                        </div>

                                        <!-- URL -->
                                        <div class="col-md-8" x-show="form.virtual_type === 'service' || form.virtual_type === 'license'">
                                            <label class="form-label">Link de Acesso / Ativação</label>
                                            <input type="url" class="form-control"
                                                   placeholder="https://exemplo.com/servico"
                                                   x-model="form.virtual_url"
                                                   @blur="saveVirtualConfig()">
                                        </div>

                                        <!-- Expiração -->
                                        <div class="col-md-4">
                                            <label class="form-label">Validade (dias)</label>
                                            <input type="number" min="0" step="1" class="form-control"
                                                   placeholder="ex: 30"
                                                   x-model="form.virtual_expiry_days"
                                                   @blur="saveVirtualConfig()">
                                            <small class="text-muted">Deixa a 0 para ilimitado.</small>
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <!-- CAMPOS DE PACK -->
                                <div x-show="form.type === 'pack'"
                                     class="mt-4 border-top pt-3"
                                     x-data="{
                                        products: <?= $availableProducts ?? '[]' ?>,
                                        items: [],
                                        newQty: 1,
                                        totalCost: 0,
                                        totalPrice: 0,

                                        async init() {
                                            if (form.id) {
                                                await this.reloadItems();
                                            }
                                        },

                                        async addItem() {
                                            const sku = this.$refs.selectProduct.value;
                                            if (!sku) return;
                                            const product = this.products.find(p => p.sku === sku);
                                            if (!product) return;
                                            const existing = this.items.find(i => i.sku === sku);
                                            if (existing) {
                                                existing.qty += this.newQty;
                                                this.calcTotals();
                                                this.$refs.selectProduct.value = '';
                                                this.newQty = 1;
                                                return;
                                            }
                                            const newItem = {
                                                sku: product.sku,
                                                name: product.name,
                                                type: product.type,
                                                qty: this.newQty,
                                                cost: product.cost,
                                                price: product.price,
                                            };
                                            this.items.push(newItem);
                                            this.calcTotals();
                                            if (form.id) {
                                                try {
                                                    const res = await fetch(`/admin/catalog/products/packs/items/save/${form.id}`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-Requested-With': 'XMLHttpRequest'
                                                        },
                                                        body: JSON.stringify([newItem]) // envia só o item adicionado
                                                    });
                                                    const data = await res.json();
                                                    if (data.success) {
                                                        console.log('✅ Item adicionado com sucesso ao pack');
                                                    } else {
                                                        console.warn('❌ Falha ao adicionar item:', data.message);
                                                    }
                                                } catch (err) {
                                                    console.error('Erro de rede ao adicionar item:', err);
                                                }
                                            }
                                            this.$refs.selectProduct.value = '';
                                            this.newQty = 1;
                                        },
                                        async updateQty(item) {
                                            if (!item || !form.id) return;
                                            this.calcTotals();
                                            try {
                                                const res = await fetch(`/admin/catalog/products/packs/items/update-qty/${item.id}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-Requested-With': 'XMLHttpRequest'
                                                    },
                                                    body: JSON.stringify({ qty: item.qty })
                                                });
                                                const data = await res.json();
                                                if (data.success) {
                                                    console.log(`✅ Quantidade atualizada para SKU ${item.sku}: ${item.qty}`);
                                                } else {
                                                    console.warn(`❌ Falha ao atualizar quantidade: ${data.message}`);
                                                }
                                            } catch (err) {
                                                console.error('Erro de rede ao atualizar quantidade:', err);
                                            }
                                        },
                                        async removeItem(index) {
                                            const item = this.items[index];
                                            if (!item) return;
                                            this.items.splice(index, 1);
                                            this.calcTotals();
                                            if (item.id) {
                                                try {
                                                    const res = await fetch(`/admin/catalog/products/packs/items/delete/${item.id}`, {
                                                        method: 'DELETE',
                                                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                                    });
                                                    const data = await res.json();
                                                    if (data.success) {
                                                        console.log(`✅ Item ${item.sku} removido do pack`);
                                                    } else {
                                                        console.warn(`⚠️ Erro ao remover item: ${data.message}`);
                                                    }
                                                } catch (err) {
                                                    console.error('Erro de rede ao remover item', err);
                                                }
                                            }
                                            form.pack_items = JSON.parse(JSON.stringify(this.items));
                                        },
                                        async syncWithServer() {
                                            const payload = this.items.map(i => ({
                                                sku: i.sku,
                                                type: i.type,
                                                qty: i.qty,
                                                cost: i.cost,
                                                price: i.price
                                            }));
                                            await fetch(`/admin/catalog/products/packs/items/save/${form.id}`, {
                                                method: 'POST',
                                                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                                                body: JSON.stringify(payload)
                                            });
                                            await this.reloadItems();
                                        },
                                        async reloadItems() {
                                            if (!form.id) return;
                                            const res = await fetch(`/admin/catalog/products/packs/items/${form.id}`, {
                                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                            });
                                            const data = await res.json();
                                            if (data.success && Array.isArray(data.items)) {
                                                this.items = data.items.map(i => ({
                                                    id: i.id,
                                                    sku: i.product_sku,
                                                    name: i.name || '', // opcional
                                                    type: i.product_type,
                                                    qty: Number(i.qty) || 0,
                                                    cost: parseFloat(i.cost_price) || 0,
                                                    price: parseFloat(i.base_price) || 0,
                                                }));
                                                this.calcTotals();
                                            }
                                        },
                                        calcTotals() {
                                            this.totalCost = this.items.reduce((sum, i) => sum + ((parseFloat(i.cost) || 0) * (parseFloat(i.qty) || 0)), 0);
                                            this.totalPrice = this.items.reduce((sum, i) => sum + ((parseFloat(i.price) || 0) * (parseFloat(i.qty) || 0)), 0);
                                        }
                                     }"
                                     x-init="init()"
                                >
                                <h5 class="mb-3">Gestão de Produtos do Pack</h5>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Selecionar Produto / Variante</label>
                                            <select x-ref="selectProduct" class="form-select">
                                                <option value="">-- Selecionar --</option>
                                                <template x-for="item in products" :key="item.sku">
                                                    <option :value="item.sku" x-text="item.label"></option>
                                                </template>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Quantidade</label>
                                            <input type="number" min="1" class="form-control" x-model.number="newQty" placeholder="1">
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" @click="addItem()">Adicionar</button>
                                        </div>
                                    </div>

                                    <table class="table table-sm table-bordered align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th>SKU</th>
                                            <th>Nome</th>
                                            <th class="text-center" style="width:100px;">Qtd</th>
                                            <th class="text-end" style="width:120px;">Custo (€)</th>
                                            <th class="text-end" style="width:120px;">Venda (€)</th>
                                            <th class="text-center" style="width:50px;">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template x-for="(row, index) in items" :key="row.id ?? row.sku">
                                            <tr>
                                                <td x-text="row.sku"></td>
                                                <td x-text="row.name"></td>
                                                <td class="text-center">
                                                    <input type="number" min="1"
                                                           class="form-control form-control-sm text-center"
                                                           x-model.number="row.qty"
                                                           @input="updateQty(row)">
                                                </td>
                                                <td class="text-end" x-text="(row.cost * row.qty).toFixed(2)"></td>
                                                <td class="text-end" x-text="(row.price * row.qty).toFixed(2)"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger" @click="removeItem(index)">×</button>
                                                </td>
                                            </tr>
                                        </template>

                                        <tr class="fw-bold table-secondary">
                                            <td colspan="3" class="text-end">Totais:</td>
                                            <td class="text-end" x-text="totalCost.toFixed(2)"></td>
                                            <td class="text-end" x-text="totalPrice.toFixed(2)"></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-dimensoes" role="tabpanel">
                            <div x-show="form.type === 'simple' || form.type === 'pack' ">
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
                            <div x-show="form.type === 'configurable'" class="alert alert-info text-center p-4 mt-3">
                                <i class="mdi mdi-ruler"></i>
                                As dimensões são definidas individualmente em cada <strong>variante</strong>.
                            </div>
                            <div x-show="form.type === 'virtual'" class="alert alert-info text-center p-4 mt-3">
                                <i class="mdi mdi-ruler"></i>
                                As dimensões não são definidas no  <strong>produto virtual</strong>.
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-multimedia" role="tabpanel">
                            <!-- Só mostra upload se NÃO for configurável -->
                            <div x-show="form.type !== 'configurable'"
                                 x-data="{
             images: <?= $productImages ?>,
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

                                <h4 class="card-title">Imagens</h4>
                                <p class="card-title-desc">Carregar, ordenar e eliminar imagens.</p>

                                <input type="file" multiple accept="image/*" class="form-control mb-3"
                                       @change="addFiles($event)" :disabled="uploading">

                                <div class="d-flex flex-wrap gap-3" x-ref="list">
                                    <template x-for="(img, index) in images" :key="img.id">
                                        <div class="position-relative border rounded p-1 bg-light text-center"
                                             style="width: 120px; height: 140px;">
                                            <div class="drag-handle position-absolute top-0 start-0 text-muted ps-1"
                                                 style="cursor: grab;">☰</div>
                                            <img :src="img.url" class="img-fluid rounded mb-1"
                                                 style="height: 100px; width: 100%; object-fit: cover;">
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Alt" x-model="img.alt_text">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 px-2 py-0"
                                                    @click="confirmDelete(img.id)">×</button>
                                        </div>
                                    </template>
                                </div>

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

                            <!-- Aviso para produtos configuráveis -->
                            <div x-show="form.type === 'configurable'" class="alert alert-info text-center p-4 mt-3">
                                <i class="mdi mdi-image-multiple-outline"></i>
                                As imagens são geridas individualmente em cada <strong>variante</strong>.
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-meta" role="tabpanel"
                             x-data="{
                                    fieldTitle: 'meta_title',
                                    fieldDesc: 'meta_description',
                                    fieldKeys: 'meta_keywords',
                                    updateMeta() {
                                        this.form[this.fieldTitle] = this.form.name || '';
                                        const text = (this.form.description || '').replace(/(<([^>]+)>)/gi, '').trim();
                                        this.form[this.fieldDesc] = text.substring(0, 160);
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
                                <option value="configurable">Variações</option>
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
                                   x-model="form[field]" :disabled="!form.manage_stock"
                                   :class="{ 'is-invalid': errors[field] }">
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
<?= $this->endSection() ?>
<?= $this->section('content-script') ?>
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
    document.addEventListener('alpine:init', () => {
        Alpine.data('productForm', () => ({
            form: {},
            errors: {},
            updatePromo() {
                const base = parseFloat(this.form.base_price) || 0;
                const tax  = parseFloat(this.form.tax_rate) || 0;
                const val  = parseFloat(this.form.discount_value) || 0;
                const type = this.form.discount_type;
                const priceWithTax = base * (1 + tax / 100);
                this.form.base_price_tax = priceWithTax.toFixed(2);
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
