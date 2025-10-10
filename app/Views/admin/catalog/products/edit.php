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
                    <h4 class="card-title">Informação Geral</h4>
                    <p class="card-title-desc">Informação Geral do Produto</p>
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
                        <div class="col-md-6" x-data="{ field: 'description' }">
                            <label :for="field">Descrição</label>
                            <textarea class="form-control" :id="field" :name="field"
                                      x-model="form[field]" :class="{ 'is-invalid': errors[field] }"></textarea>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-6" x-data="{ field: 'short_description' }">
                            <label :for="field">Descrição Pequena</label>
                            <textarea class="form-control" :id="field" :name="field"
                                      x-model="form[field]" :class="{ 'is-invalid': errors[field] }"></textarea>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>

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

            <!-- Valores de Venda -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Valores de Venda</h4>
                    <p class="card-title-desc">Preços e impostos aplicáveis ao produto</p>
                    <div class="row">
                        <div class="col-md-3" x-data="{ field: 'cost_price' }">
                            <label class="form-label" :for="field">Preço de Custo</label>
                            <input type="number" step="0.01" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" placeholder="0.00"
                                   :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'base_price' }">
                            <label class="form-label" :for="field">Preço Base</label>
                            <input type="number" step="0.01" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" placeholder="0.00"
                                   :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'base_price_tax' }">
                            <label class="form-label" :for="field">Preço Base + Imposto</label>
                            <input type="number" step="0.01" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" placeholder="0.00"
                                   :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'tax_class_id' }">
                            <label class="form-label" :for="field">Taxa de Imposto</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                            </select>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Valores Promocionais -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Valores Promocionais</h4>
                    <p class="card-title-desc">Definições de descontos e promoções do produto</p>
                    <div class="row">
                        <div class="col-md-3" x-data="{ field: 'discount_type' }">
                            <label class="form-label" :for="field">Tipo de Desconto</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <option value="percent">Percentagem (%)</option>
                                <option value="fixed">Valor Fixo (€)</option>
                            </select>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'discount_value' }">
                            <label class="form-label" :for="field">Valor do Desconto</label>
                            <input type="number" step="0.01" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" placeholder="0.00"
                                   :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'special_price' }">
                            <label class="form-label" :for="field">Preço Promocional</label>
                            <input type="number" step="0.01" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" placeholder="0.00"
                                   :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'special_price_start' }">
                            <label class="form-label" :for="field">Início Promoção</label>
                            <input type="date" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-3" x-data="{ field: 'special_price_end' }">
                            <label class="form-label" :for="field">Fim Promoção</label>
                            <input type="date" class="form-control"
                                   :id="field" :name="field"
                                   x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dimensões -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Variações de Produto</h4>
                    <p class="card-title-desc">Medidas físicas do produto para envio e logística</p>
                    <div class="row">
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
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dimensões</h4>
                    <p class="card-title-desc">Medidas físicas do produto para envio e logística</p>
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
                        <div class="col-md-6" x-data="{ field: 'status' }">
                            <label class="form-label" :for="field">Estado</label>
                            <select class="form-select"  :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
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
                        <div class="col-md-6">
                            <label class="form-label" for="type">Tipo</label>
                            <select class="form-select"
                                    id="type"
                                    name="type"
                                    x-model="form.type"
                                    :class="{ 'is-invalid': errors.type }">
                                <option value="">-- Selecionar --</option>
                                <option value="simple">Simples</option>
                                <option value="configurable">Configurable</option>
                                <option value="virtual">Virtual</option>
                                <option value="pack">Pack</option>
                            </select>
                            <template x-if="errors.type">
                                <small class="text-danger" x-text="errors.type"></small>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="visibility">Visibilidade</label>
                            <select class="form-select"
                                    id="visibility"
                                    name="visibility"
                                    x-model="form.visibility"
                                    :class="{ 'is-invalid': errors.visibility }">
                                <option value="">-- Selecionar --</option>
                                <option value="both">Catálogo & Pesquisa</option>
                                <option value="catalog">Só Catálogo</option>
                                <option value="search">Só Pesquisa</option>
                                <option value="none">Oculto</option>
                            </select>
                            <template x-if="errors.visibility">
                                <small class="text-danger" x-text="errors.visibility"></small>
                            </template>
                        </div>
                    </div>

                    <div class="row">
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
                            <div class="mb-2">
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
            <!-- Etiquetas -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Etiquetas</h4>
                    <p class="card-title-desc">Identificadores únicos</p>
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
                </div>
            </div>
            <!-- Fornecedores -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Fornecedores</h4>
                    <p class="card-title-desc">Informações de fornecedores e marcas</p>
                    <div class="row">
                        <div class="col-md-6" x-data="{ field: 'supplier_id' }">
                            <label class="form-label" :for="field">Fornecedor</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($suppliers ?? [] as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>"><?= esc($supplier['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                        <div class="col-md-6" x-data="{ field: 'brand_id' }">
                            <label class="form-label" :for="field">Marca</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($brands ?? [] as $brand): ?>
                                    <option value="<?= $brand['id'] ?>"><?= esc($brand['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
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
                        <div class="col-md-12" x-data="{ field: 'category_id' }">
                            <label class="form-label" :for="field">Categoria Base</label>
                            <select class="form-select" :id="field" :name="field"
                                    x-model="form[field]" :class="{ 'is-invalid': errors[field] }">
                                <option value="">-- Selecionar --</option>
                                <?php foreach ($categories ?? [] as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <template x-if="errors[field]"><small class="text-danger" x-text="errors[field]"></small></template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Botão submit -->
    <div class="mt-3 d-grid">
        <button type="submit" class="btn btn-primary" :disabled="loading">
            <span x-show="!loading">Guardar Produto</span>
            <span x-show="loading">A guardar...</span>
        </button>
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
