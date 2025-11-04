<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Regras de Carrinho
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div
    x-data="{
        form: {
            id: <?= (int) $rule['id'] ?>,
            name: '<?= addslashes($rule['name']) ?>',
            description: `<?= addslashes($rule['description'] ?? '') ?>`,
            discount_type: '<?= $rule['discount_type'] ?>',
            discount_value: '<?= $rule['discount_value'] ?>',
            start_date: '<?= $rule['start_date'] ?>',
            end_date: '<?= $rule['end_date'] ?>',
            priority: '<?= $rule['priority'] ?>',
            status: <?= $rule['status'] ? 1 : 0 ?>,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        loading: false,
        async submit() {
            if (!this._formHandler) {
                this._formHandler = formHandler(
                    '<?= base_url('admin/marketing/cart-rules/update') ?>',
                    {},
                    { resetOnSuccess: false }
                );
            }
            this._formHandler.form = JSON.parse(JSON.stringify(this.form));
            this._formHandler.form.id = this.form.id ?? <?= (int) $rule['id'] ?>;
            this.loading = true;
            try {
                await this._formHandler.submit();
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
                <h5 class="mb-2 card-title">Editar Regra de Carrinho</h5>
                <p class="text-muted mb-0">Atualiza as definições desta regra de desconto.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('admin/marketing/cart-rules') ?>" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Voltar à Lista
                </a>
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
        <!-- Coluna principal -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-2">Informação Geral</h4>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Nome da Regra</label>
                            <input type="text" class="form-control" x-model="form.name">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Tipo de Desconto</label>
                            <select class="form-select" x-model="form.discount_type">
                                <option value="percent">Percentagem</option>
                                <option value="fixed">Valor Fixo</option>
                                <option value="free_shipping">Envio Grátis</option>
                                <option value="buy_x_get_y">Leve X, Pague Y</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Valor</label>
                            <input type="number" step="0.01" class="form-control" x-model="form.discount_value">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">Início</label>
                            <input type="date" class="form-control" x-model="form.start_date">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">Fim</label>
                            <input type="date" class="form-control" x-model="form.end_date">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Prioridade</label>
                            <input type="number" class="form-control" x-model="form.priority">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" rows="3" x-model="form.description"
                                      placeholder="Descrição da regra..."></textarea>
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
                                        const res = await fetch('<?= base_url('admin/marketing/cart-rules/addCategory') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                rule_id: <?= (int) $rule['id'] ?>,
                                                category_id: newCat.id,
                                                include: newCat.include ? 1 : 0
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status === 'success') showToast('Categoria adicionada.', 'success');
                                        else showToast(data.message || 'Erro ao adicionar categoria.', 'error');
                                    } catch (err) {
                                        console.error(err);
                                        showToast('Erro de rede.', 'error');
                                    }
                                },
                                async toggleInclude(cat) {
                                    const oldState = cat.include;
                                    cat.include = !cat.include;
                                    try {
                                        const res = await fetch('<?= base_url('admin/marketing/cart-rules/updateCategoryInclude') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                rule_id: <?= (int) $rule['id'] ?>,
                                                category_id: cat.id,
                                                include: cat.include ? 1 : 0
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status !== 'success') {
                                            cat.include = oldState;
                                            showToast(data.message || 'Erro ao atualizar.', 'error');
                                        }
                                    } catch (err) {
                                        cat.include = oldState;
                                        showToast('Falha de comunicação.', 'error');
                                    }
                                },
                                async removeCategory(cat) {
                                    this.categories = this.categories.filter(c => c.id !== cat.id);
                                    try {
                                        await fetch('<?= base_url('admin/marketing/cart-rules/deleteCategory') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                rule_id: <?= (int) $rule['id'] ?>,
                                                category_id: cat.id
                                            })
                                        });
                                        showToast('Categoria removida.', 'success');
                                    } catch {
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
                            <p class="text-muted mb-2">Associe categorias específicas a esta regra.</p>
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
                                                <input class="form-check-input" type="checkbox"
                                                       x-model="cat.include" @input="toggleInclude(cat)">
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
                                        const res = await fetch('<?= base_url('admin/marketing/cart-rules/addProduct') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                rule_id: <?= (int) $rule['id'] ?>,
                                                product_id: newProd.id,
                                                include: newProd.include ? 1 : 0
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status === 'success') showToast('Produto adicionado.', 'success');
                                        else showToast(data.message || 'Erro ao adicionar.', 'error');
                                    } catch {
                                        showToast('Erro de rede.', 'error');
                                    }
                                },
                                async toggleInclude(prod) {
                                    const oldState = prod.include;
                                    prod.include = !prod.include;
                                    try {
                                        const res = await fetch('<?= base_url('admin/marketing/cart-rules/updateProductInclude') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                rule_id: <?= (int) $rule['id'] ?>,
                                                product_id: prod.id,
                                                include: prod.include ? 1 : 0
                                            })
                                        });
                                        const data = await res.json();
                                        if (data.status !== 'success') {
                                            prod.include = oldState;
                                            showToast(data.message || 'Erro ao atualizar.', 'error');
                                        }
                                    } catch {
                                        prod.include = oldState;
                                        showToast('Falha de comunicação.', 'error');
                                    }
                                },
                                async removeProduct(prod) {
                                    this.products = this.products.filter(p => p.id !== prod.id);
                                    try {
                                        await fetch('<?= base_url('admin/marketing/cart-rules/deleteProduct') ?>', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({
                                                rule_id: <?= (int) $rule['id'] ?>,
                                                product_id: prod.id
                                            })
                                        });
                                        showToast('Produto removido.', 'success');
                                    } catch {
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
                            <p class="text-muted mb-2">Associe produtos específicos a esta regra.</p>
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
                                                <input class="form-check-input" type="checkbox"
                                                       x-model="prod.include" @input="toggleInclude(prod)">
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
                <!-- Grupos de Clientes -->
                <div class="col-md-6 mt-4">
                    <div class="card h-100">
                        <div class="card-body"
                             x-data="{
                selectedGroup: '',
                groups: <?= $groupsJSON ?>,
                async addGroup() {
                    if (!this.selectedGroup || this.groups.find(g => g.id === this.selectedGroup)) return;
                    const selectedText = $(this.$refs.select).find('option:selected').text();
                    const newGroup = {
                        id: this.selectedGroup,
                        name: selectedText,
                        include: true
                    };
                    this.groups.push(newGroup);
                    $(this.$refs.select).val(null).trigger('change');
                    this.selectedGroup = '';
                    try {
                        const res = await fetch('<?= base_url('admin/marketing/cart-rules/addGroup') ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                rule_id: <?= (int) $rule['id'] ?>,
                                customer_group_id: newGroup.id,
                                include: newGroup.include ? 1 : 0
                            })
                        });
                        const data = await res.json();
                        if (data.status === 'success') showToast('Grupo adicionado à regra.', 'success');
                        else showToast(data.message || 'Erro ao adicionar grupo.', 'error');
                    } catch (err) {
                        console.error(err);
                        showToast('Erro de rede ao adicionar grupo.', 'error');
                    }
                },
                async toggleInclude(group) {
                    const oldState = group.include;
                    group.include = !group.include;
                    try {
                        const res = await fetch('<?= base_url('admin/marketing/cart-rules/updateGroupInclude') ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                rule_id: <?= (int) $rule['id'] ?>,
                                customer_group_id: group.id,
                                include: group.include ? 1 : 0
                            })
                        });
                        const data = await res.json();
                        if (data.status !== 'success') {
                            group.include = oldState;
                            showToast(data.message || 'Erro ao atualizar estado.', 'error');
                        }
                    } catch (err) {
                        group.include = oldState;
                        console.error(err);
                        showToast('Falha de comunicação com o servidor.', 'error');
                    }
                },
                async removeGroup(group) {
                    this.groups = this.groups.filter(g => g.id !== group.id);
                    try {
                        await fetch('<?= base_url('admin/marketing/cart-rules/deleteGroup') ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                rule_id: <?= (int) $rule['id'] ?>,
                                customer_group_id: group.id
                            })
                        });
                        showToast('Grupo removido da regra.', 'success');
                    } catch (err) {
                        console.error(err);
                        showToast('Erro ao remover grupo.', 'error');
                    }
                }
             }"
                             x-init="
                $nextTick(() => {
                    const el = $refs.select;
                    $(el).select2({
                        width: '100%',
                        placeholder: 'Selecionar grupo...',
                    }).on('change', function() {
                        selectedGroup = $(this).val();
                    });
                });
             ">

                            <h5 class="card-title">Grupos de Clientes</h5>
                            <p class="text-muted mb-2">Associe grupos de clientes específicos a esta regra.</p>
                            <div class="d-flex align-items-center mb-3 gap-2">
                                <select x-ref="select" class="form-select select2 flex-grow-1">
                                    <option></option>
                                    <?php foreach ($groups as $grp): ?>
                                        <option value="<?= $grp['customer_group_id'] ?>">
                                            <?= htmlspecialchars($grp['name'] ?? 'Grupo #' . $grp['customer_group_id']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary" @click="addGroup()">Adicionar</button>
                            </div>
                            <table class="table table-sm table-bordered align-middle m-0">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Grupo</th>
                                    <th class="text-center">Incluir</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template x-if="groups.length === 0">
                                    <tr><td colspan="4" class="text-center text-muted small">Nenhum grupo associado.</td></tr>
                                </template>
                                <template x-for="(group, index) in groups" :key="group.id">
                                    <tr>
                                        <td x-text="index + 1"></td>
                                        <td x-text="group.name"></td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox"
                                                       x-model="group.include" @input="toggleInclude(group)">
                                                <label class="form-check-label small">
                                                    <span x-text="group.include ? 'Incluir' : 'Excluir'"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-light text-danger" @click="removeGroup(group)">
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

        <!-- Coluna lateral -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estado</h4>
                    <p class="card-title-desc">Defina o estado e visibilidade.</p>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <label class="form-label">Estado</label>
                            <select class="form-select select2" x-model="form.status">
                                <option value="1">Ativa</option>
                                <option value="0">Inativa</option>
                            </select>
                        </div>
                        <div class="col-6 text-center mt-4">
                            <span class="badge w-100 fs-6 py-2"
                                  :class="form.status == 1 ? 'bg-success' : 'bg-secondary'"
                                  x-text="form.status == 1 ? 'Ativa' : 'Inativa'">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
