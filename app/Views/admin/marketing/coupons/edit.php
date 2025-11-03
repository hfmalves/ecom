<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Cupões
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div
        x-data="{
            form: {
                id: <?= (int) $coupon['id'] ?>,
                code: '<?= addslashes($coupon['code']) ?>',
                type: '<?= $coupon['type'] ?>',
                value: '<?= $coupon['value'] ?>',
                max_uses: '<?= $coupon['max_uses'] ?>',
                max_uses_per_customer: '<?= $coupon['max_uses_per_customer'] ?>',
                min_order_value: '<?= $coupon['min_order_value'] ?>',
                max_order_value: '<?= $coupon['max_order_value'] ?>',
                scope: '<?= $coupon['scope'] ?>',
                stackable: <?= $coupon['stackable'] ? 1 : 0 ?>,
                is_active: <?= $coupon['is_active'] ? 1 : 0 ?>,
                description: `<?= addslashes($coupon['description'] ?? '') ?>`,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            loading: false,
            async submit() {
                if (!this._formHandler) {
                    this._formHandler = formHandler(
                        '<?= base_url('admin/marketing/coupons/update') ?>',
                        {},
                        { resetOnSuccess: false }
                    );
                }
                this._formHandler.form = JSON.parse(JSON.stringify(this.form));
                this._formHandler.form.id = this.form.id ?? <?= (int) $coupon['id'] ?>;
                this.loading = true;
                try {
                    await this._formHandler.submit(); // sem argumentos — formHandler já mostra toast
                } catch (e) {
                    console.error(e);
                    showToast('Falha de comunicação com o servidor.', 'error');
                } finally {
                    this.loading = false;
                }
            }
        }"
    >
    <div class="row mb-4">
        <div class="col-lg-12 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-2 card-title">Editar Cupão</h5>
                <p class="text-muted mb-0">Atualiza as informações deste cupão de desconto.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('admin/marketing/coupons') ?>" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Voltar à Lista
                </a>

                <!-- Botão Guardar -->
                <button type="button"
                        class="btn btn-primary"
                        @click="submit()"
                        :disabled="loading">
                    <template x-if="!loading">
                        <span><i class="mdi mdi-content-save-outline me-1"></i> Guardar</span>
                    </template>
                    <template x-if="loading">
                        <span><i class="fa fa-spinner fa-spin me-1"></i> A guardar...</span>
                    </template>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-2">Informação Geral</h4>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Código</label>
                            <input type="text" class="form-control" x-model="form.code">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2"
                             x-data="{ field: 'type' }"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.select;
                                    $(el).select2({
                                        width: '100%',
                                        placeholder: '-- Selecionar Tipo --',
                                        minimumResultsForSearch: Infinity
                                    });
                                    $(el).val(form[field]).trigger('change');
                                    $(el).on('change', () => form[field] = $(el).val());
                                    $watch('form[field]', val => $(el).val(val).trigger('change'));
                                });
                             ">
                            <label class="form-label" :for="field">Tipo</label>
                            <select class="form-select" x-ref="select" :id="field">
                                <option value="percent">Percentagem</option>
                                <option value="fixed">Valor Fixo</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label">Valor (€)</label>
                            <input type="number" step="0.01" class="form-control" x-model="form.value">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Limite Global</label>
                            <input type="number" class="form-control" x-model="form.max_uses">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Limite por Cliente</label>
                            <input type="number" class="form-control" x-model="form.max_uses_per_customer">
                        </div>

                        <div class="col-md-4 mb-2"
                             x-data="{ field: 'scope' }"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.select;
                                    $(el).select2({
                                        width: '100%',
                                        placeholder: '-- Selecionar Aplicação --',
                                        minimumResultsForSearch: Infinity
                                    });
                                    $(el).val(form[field]).trigger('change');
                                    $(el).on('change', () => form[field] = $(el).val());
                                    $watch('form[field]', val => $(el).val(val).trigger('change'));
                                });
                             ">
                            <label class="form-label" :for="field">Aplicação</label>
                            <select class="form-select" x-ref="select" :id="field">
                                <option value="global">Global</option>
                                <option value="category">Categoria</option>
                                <option value="product">Produto</option>
                                <option value="shipping">Envio</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Pedido Mínimo (€)</label>
                            <input type="number" step="0.01" class="form-control" x-model="form.min_order_value">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Pedido Máximo (€)</label>
                            <input type="number" step="0.01" class="form-control" x-model="form.max_order_value">
                        </div>

                        <div class="col-md-4 mb-2"
                             x-data="{ field: 'stackable' }"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.select;
                                    $(el).select2({
                                        width: '100%',
                                        placeholder: '-- Acumulável --',
                                        minimumResultsForSearch: Infinity
                                    });
                                    $(el).val(form[field]).trigger('change');
                                    $(el).on('change', () => form[field] = $(el).val());
                                    $watch('form[field]', val => $(el).val(val).trigger('change'));
                                });
                             ">
                            <label class="form-label" :for="field">Acumulável</label>
                            <select class="form-select" x-ref="select" :id="field">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associações -->
            <div class="row mt-4">
                <!-- Categorias -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body"
                             x-data="{
                                selectedCategory: '',
                                categories: <?= $categoriesJSON ?>,
                                async addCategory() {
                                    if (!this.selectedCategory || this.categories.find(c => c.id === this.selectedCategory)) return;
                                    const selectedText = $(this.$refs.select).find('option:selected').text();
                                    const newCat = {
                                        id: this.selectedCategory,
                                        name: selectedText,
                                        include: true
                                    };
                                    this.categories.push(newCat);
                                    $(this.$refs.select).val(null).trigger('change');
                                    this.selectedCategory = '';
                                    try {
                                        const res = await fetch('<?= base_url('admin/marketing/coupons/addCategory') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                coupon_id: <?= (int) $coupon['id'] ?>,
                                                category_id: newCat.id,
                                                include: newCat.include ? 1 : 0
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status === 'success') showToast('Categoria adicionada ao cupão.', 'success');
                                        else showToast(data.message || 'Erro ao adicionar categoria.', 'error');
                                    } catch (err) {
                                        console.error(err);
                                        showToast('Erro de rede ao adicionar categoria.', 'error');
                                    }
                                },
                                async toggleInclude(cat) {
                                    const oldState = cat.include;
                                    cat.include = !cat.include;

                                    try {
                                        const res = await fetch('<?= base_url('admin/marketing/coupons/updateCategoryInclude') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                coupon_id: <?= (int) $coupon['id'] ?>,
                                                category_id: cat.id,
                                                include: cat.include ? 1 : 0
                                            })
                                        });

                                        const data = await res.json();

                                        if (data.status === 'success') {
                                            showToast('Estado atualizado com sucesso.', 'success');
                                        } else {
                                            cat.include = oldState; // reverte o estado se der erro
                                            showToast(data.message || 'Erro ao atualizar estado.', 'error');
                                        }

                                    } catch (err) {
                                        cat.include = oldState; // reverte
                                        console.error(err);
                                        showToast('Falha de comunicação com o servidor.', 'error');
                                    }
                                },
                                async removeCategory(cat) {
                                    this.categories = this.categories.filter(c => c.id !== cat.id);
                                    try {
                                        await fetch('<?= base_url('admin/marketing/coupons/deleteCategory') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                coupon_id: <?= (int) $coupon['id'] ?>,
                                                category_id: cat.id
                                            })
                                        });
                                        showToast('Categoria removida.', 'success');
                                    } catch (err) {
                                        console.error(err);
                                        showToast('Erro ao remover categoria.', 'error');
                                    }
                                }
                            }"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.select;
                                    $(el).select2({
                                        width: '100%',
                                        placeholder: 'Selecionar categoria...',
                                    }).on('change', function() {
                                        selectedCategory = $(this).val();
                                    });
                                });
                             ">

                            <h5 class="card-title">Categorias</h5>
                            <p class="text-muted mb-2">Associe categorias específicas a este cupão.</p>
                            <div class="d-flex align-items-center mb-3 gap-2">
                                <select x-ref="select" class="form-select select2 flex-grow-1">
                                    <option></option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['category_id'] ?>">
                                            <?= htmlspecialchars($cat['name'] ?? 'Categoria #' . $cat['category_id']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary" @click="addCategory()">Adicionar</button>
                            </div>
                            <table class="table table-sm table-bordered align-middle m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Categoria</th>
                                        <th class="text-center">Incluir</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="categories.length === 0">
                                        <tr><td colspan="4" class="text-center text-muted small">Nenhuma categoria associada.</td></tr>
                                    </template>
                                    <template x-for="(cat, index) in categories" :key="cat.id">
                                        <tr>
                                            <td x-text="index + 1"></td>
                                            <td x-text="cat.name"></td>
                                            <td class="text-center">
                                                <div class="form-check form-switch d-inline-block">
                                                    <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            x-model="cat.include"
                                                            @input="toggleInclude(cat)">
                                                    <label class="form-check-label small">
                                                        <span x-text="cat.include ? 'Incluir' : 'Excluir'"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-light text-danger" @click="removeCategory(cat)">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Produtos -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body"
                             x-data="{
                                selectedProduct: '',
                                products: <?= $productsJSON ?>,
                                async addProduct() {
                                    if (!this.selectedProduct || this.products.find(p => p.id === this.selectedProduct)) return;
                                    const selectedText = $(this.$refs.select).find('option:selected').text();
                                    const newProd = {
                                        id: this.selectedProduct,
                                        name: selectedText,
                                        include: true
                                    };
                                    this.products.push(newProd);
                                    $(this.$refs.select).val(null).trigger('change');
                                    this.selectedProduct = '';
                                    try {
                                        const res = await fetch('<?= base_url('admin/marketing/coupons/addProduct') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                coupon_id: <?= (int) $coupon['id'] ?>,
                                                product_id: newProd.id,
                                                include: newProd.include ? 1 : 0
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status === 'success') showToast('Produto adicionado ao cupão.', 'success');
                                        else showToast(data.message || 'Erro ao adicionar produto.', 'error');
                                    } catch (err) {
                                        console.error(err);
                                        showToast('Erro de rede ao adicionar produto.', 'error');
                                    }
                                },
                               async toggleInclude(prod) {
                                    prod.include = !prod.include;
                                    const newValue = prod.include ? 1 : 0;
                                    try {
                                        const res = await fetch('<?= base_url('admin/marketing/coupons/updateProductInclude') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                coupon_id: <?= (int) $coupon['id'] ?>,
                                                product_id: prod.id,
                                                include: newValue
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status === 'success') {
                                            showToast('Estado do produto atualizado com sucesso.', 'success');
                                        } else {
                                            prod.include = !prod.include;
                                            showToast(data.message || 'Erro ao atualizar estado.', 'error');
                                        }
                                    } catch (err) {
                                        prod.include = !prod.include;
                                        console.error(err);
                                        showToast('Falha de comunicação com o servidor.', 'error');
                                    }
                                },
                                async removeProduct(prod) {
                                    this.products = this.products.filter(p => p.id !== prod.id);
                                    try {
                                        await fetch('<?= base_url('admin/marketing/coupons/deleteProduct') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                coupon_id: <?= (int) $coupon['id'] ?>,
                                                product_id: prod.id
                                            })
                                        });
                                        showToast('Produto removido.', 'success');
                                    } catch (err) {
                                        console.error(err);
                                        showToast('Erro ao remover produto.', 'error');
                                    }
                                }
                            }"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.select;
                                    $(el).select2({
                                        width: '100%',
                                        placeholder: 'Selecionar produto...',
                                    }).on('change', function() {
                                        selectedProduct = $(this).val();
                                    });
                                });
                             ">
                            <h5 class="card-title">Produtos</h5>
                            <p class="text-muted mb-2">Associe produtos específicos a este cupão.</p>
                            <div class="d-flex align-items-center mb-3 gap-2">
                                <select x-ref="select" class="form-select select2 flex-grow-1">
                                    <option></option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= $p['product_id'] ?>">
                                            <?= htmlspecialchars($p['name'] ?? 'Produto #' . $p['product_id']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary" @click="addProduct()">Adicionar</button>
                            </div>
                            <table class="table table-sm table-bordered align-middle m-0">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th class="text-center">Incluir</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template x-if="products.length === 0">
                                    <tr><td colspan="4" class="text-center text-muted small">Nenhum produto associado.</td></tr>
                                </template>
                                <template x-for="(prod, index) in products" :key="prod.id">
                                    <tr>
                                        <td x-text="index + 1"></td>
                                        <td x-text="prod.name"></td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        x-model="prod.include"
                                                        @input="toggleInclude(prod)">
                                                <label class="form-check-label small">
                                                    <span x-text="prod.include ? 'Incluir' : 'Excluir'"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-light text-danger" @click="removeProduct(prod)">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Coluna Lateral -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estado</h4>
                    <p class="card-title-desc">Defina o estado e visibilidade</p>
                    <div class="row align-items-center">
                        <div class="col-6"
                             x-init="
                                $nextTick(() => {
                                    const el = $refs.estadoSelect;
                                    $(el).select2({
                                        width: '100%',
                                        minimumResultsForSearch: Infinity
                                    }).on('change', function() {
                                        form.is_active = $(this).val();
                                    });
                                    $(el).val(form.is_active).trigger('change');
                                });
                             ">
                            <label class="form-label">Estado</label>
                            <select class="form-select select2" x-ref="estadoSelect" x-model="form.is_active">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                        <div class="col-6 text-center mt-4">
                            <span class="badge w-100 fs-6 py-2"
                                  :class="form.is_active == 1 ? 'bg-success' : 'bg-secondary'"
                                  x-text="form.is_active == 1 ? 'Ativo' : 'Inativo'">
                            </span>
                        </div>
                        <div class="col-12 mt-4">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" rows="3" x-model="form.description"
                                      placeholder="Descrição do cupão..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
