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

            <a href="javascript:void(0);" class="btn btn-primary">
                <i class="bx bx-save align-middle"></i> Guardar
            </a>
        </div>
    </div><!--end col-->
</div><!--end row-->
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informação Geral</h4>
                <p class="card-title-desc">Informação Geral do Produto</p>
                <div class="row">
                    <!-- Nome -->
                    <div class="col-8">
                        <div class="mb-2">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nome do produto">
                        </div>
                    </div>
                    <!-- Slug -->
                    <div class="col-4">
                        <div class="mb-2">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="ex: produto-exemplo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Descrição -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="description">Descrição</label>
                            <textarea id="description" name="description"></textarea>
                        </div>
                    </div>
                    <!-- Descrição curta -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="short_description">Descrição Pequena</label>
                            <textarea id="short_description" name="short_description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Meta Title -->
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Título SEO do produto">
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Descrição SEO do produto"></textarea>
                        </div>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="ex: sapatilhas, running, homem">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Valores de Venda</h4>
                <p class="card-title-desc">Preços e impostos aplicáveis ao produto</p>
                <p class="card-title-desc">Create beautifully simple form labels that float over your input fields.</p>
                <div class="row">
                    <!-- Preço de custo -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="cost_price" class="form-label">Preço de Custo</label>
                            <input type="number" step="0.01" class="form-control" id="cost_price" name="cost_price" placeholder="0.00">
                        </div>
                    </div>
                    <!-- Preço base -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="base_price" class="form-label">Preço Base</label>
                            <input type="number" step="0.01" class="form-control" id="base_price" name="base_price" placeholder="0.00">
                        </div>
                    </div>
                    <!-- Preço base com imposto -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="base_price_tax" class="form-label">Preço Base + Imposto</label>
                            <input type="number" step="0.01" class="form-control" id="base_price_tax" name="base_price_tax" placeholder="0.00">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="m">
                            <label for="tax_class_id" class="form-label">Taxa de Imposto</label>
                            <select id="tax_class_id" name="tax_class_id" class="form-select">
                                <option value="">-- Selecionar --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mt-3">Valores Promocionais</h4>
                <p class="card-title-desc">Definições de descontos e promoções do produto</p>
                <div class="row">
                    <!-- Tipo de desconto -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="discount_type" class="form-label">Tipo de Desconto</label>
                            <select id="discount_type" name="discount_type" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <option value="percent">Percentagem (%)</option>
                                <option value="fixed">Valor Fixo (€)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="discount_value" class="form-label">Valor do Desconto</label>
                            <input type="number" step="0.01" class="form-control" id="discount_value" name="discount_value" placeholder="0.00">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="special_price" class="form-label">Preço Promocional</label>
                            <input type="number" step="0.01" class="form-control" id="special_price" name="special_price" placeholder="0.00">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="special_price_start" class="form-label">Início Promoção</label>
                            <input type="date" class="form-control" id="special_price_start" name="special_price_start">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="special_price_end" class="form-label">Fim Promoção</label>
                            <input type="date" class="form-control" id="special_price_end" name="special_price_end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dimensões</h4>
                <p class="card-title-desc">Medidas físicas do produto para envio e logística</p>
                <div class="row">
                    <!-- Peso -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="weight" class="form-label">Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" placeholder="0.00">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Largura -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="width" class="form-label">Largura (cm)</label>
                            <input type="number" step="0.1" class="form-control" id="width" name="width" placeholder="0.0">
                        </div>
                    </div>
                    <!-- Altura -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="height" class="form-label">Altura (cm)</label>
                            <input type="number" step="0.1" class="form-control" id="height" name="height" placeholder="0.0">
                        </div>
                    </div>
                    <!-- Comprimento -->
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="length" class="form-label">Comprimento (cm)</label>
                            <input type="number" step="0.1" class="form-control" id="length" name="length" placeholder="0.0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Visibilidade</h4>
                <p class="card-title-desc">Informações de Visibilidade</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="type" class="form-label">Estado</label>
                            <select id="type" name="type" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                                <option value="draft">Rascunho</option>
                                <option value="archived">Arquivado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="type" class="form-label">Tipo de Produto</label>
                            <select id="type" name="type" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <option value="simple">Simples</option>
                                <option value="configurable">Configurable</option>
                                <option value="virtual">Virtual</option>
                                <option value="pack">Pack</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="visibility" class="form-label">Visibilidade</label>
                            <select id="visibility" name="visibility" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <option value="both">Catálogo & Pesquisa</option>
                                <option value="catalog">Só Catálogo</option>
                                <option value="search">Só Pesquisa</option>
                                <option value="none">Oculto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Produto em destaque -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="is_featured" class="form-label">Produto em Destaque</label>
                            <div>
                                <input type="checkbox" id="is_featured" name="is_featured" value="1" switch="none" />
                                <label for="is_featured" data-on-label="Sim" data-off-label="Não"></label>
                            </div>
                        </div>
                    </div>

                    <!-- Produto novo -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="is_new" class="form-label">Produto Novo</label>
                            <div>
                                <input type="checkbox" id="is_new" name="is_new" value="1" switch="none" />
                                <label for="is_new" data-on-label="Sim" data-off-label="Não"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Inventário  e quantidades</h4>
                <p class="card-title-desc">Informações de Visibilidade</p>
                <div class="row">
                    <!-- Quantidade em stock -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="stock_qty" class="form-label">Qtd. em Stock</label>
                            <input type="number" class="form-control" id="stock_qty" name="stock_qty" placeholder="0">
                        </div>
                    </div>

                    <!-- Gestão de stock -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="manage_stock" class="form-label">Gerir Stock</label>
                            <div>
                                <input type="checkbox" id="manage_stock" name="manage_stock" value="1" switch="none">
                                <label for="manage_stock" data-on-label="Sim" data-off-label="Não"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Etiquetas</h4>
                <p class="card-title-desc">Etiquetas e identificadaores unicos</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="ex: PROD12345">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="ean" class="form-label">EAN</label>
                            <input type="text" class="form-control" id="ean" name="ean" placeholder="EAN do produto">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="upc" class="form-label">UPC</label>
                            <input type="text" class="form-control" id="upc" name="upc" placeholder="UPC do produto">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" placeholder="ISBN (para livros)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="gtin" class="form-label">GTIN</label>
                            <input type="text" class="form-control" id="gtin" name="gtin" placeholder="GTIN do produto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Fornecedores</h4>
                <p class="card-title-desc">Informações de fornecedores e marcas</p>
                <div class="row">
                    <!-- Fornecedor -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="supplier_id" class="form-label">Fornecedor</label>
                            <select id="supplier_id" name="supplier_id" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <?php if (!empty($suppliers)): ?>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <option value="<?= $supplier['id'] ?>"><?= esc($supplier['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Marca -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="brand_id" class="form-label">Marca</label>
                            <select id="brand_id" name="brand_id" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <?php if (!empty($brands)): ?>
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?= $brand['id'] ?>"><?= esc($brand['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Categorias</h4>
                <p class="card-title-desc">Informações de fornecedores e marcas</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="category_id" class="form-label">Categoria Base</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">-- Selecionar --</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
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
