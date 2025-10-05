<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Configurações SEO
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">

    <div class="col-12">
        <form id="securityForm"
              x-ref="form"
              x-data="formHandler(
          '<?= base_url('admin/settings/security/update') ?>',
          {
              id: '<?= esc($settings['id'] ?? '') ?>',
              password_min_length: '<?= esc($settings['password_min_length'] ?? 8) ?>',
              session_timeout: '<?= esc($settings['session_timeout'] ?? 30) ?>',
              login_attempts_limit: '<?= esc($settings['login_attempts_limit'] ?? 5) ?>',
              enable_2fa: '<?= esc($settings['enable_2fa'] ?? 0) ?>',
              lockout_duration: '<?= esc($settings['lockout_duration'] ?? 15) ?>',
              password_expiry_days: '<?= esc($settings['password_expiry_days'] ?? 90) ?>',
              require_uppercase: '<?= esc($settings['require_uppercase'] ?? 1) ?>',
              require_numbers: '<?= esc($settings['require_numbers'] ?? 1) ?>',
              require_specials: '<?= esc($settings['require_specials'] ?? 1) ?>',
              ip_block_enabled: '<?= esc($settings['ip_block_enabled'] ?? 0) ?>',
              allowed_ip_ranges: `<?= esc($settings['allowed_ip_ranges'] ?? '') ?>`,
              <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          }
      )"
              @submit.prevent="submit"
              class="card">

            <div class="card-body">
                <h4 class="card-title">Configurações de Segurança</h4>
                <p class="card-title-desc">Ajuste os parâmetros de segurança do sistema</p>

                <div class="row">
                    <!-- Comprimento mínimo da password -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Comprimento mínimo da password</label>
                        <input type="number" class="form-control"
                               x-model="form.password_min_length"
                               :class="{ 'is-invalid': errors.password_min_length }">
                        <template x-if="errors.password_min_length">
                            <small class="text-danger" x-text="errors.password_min_length"></small>
                        </template>
                    </div>

                    <!-- Tempo máximo de sessão -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tempo máximo de sessão (minutos)</label>
                        <input type="number" class="form-control"
                               x-model="form.session_timeout"
                               :class="{ 'is-invalid': errors.session_timeout }">
                        <template x-if="errors.session_timeout">
                            <small class="text-danger" x-text="errors.session_timeout"></small>
                        </template>
                    </div>

                    <!-- Limite de tentativas de login -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Limite de tentativas de login</label>
                        <input type="number" class="form-control"
                               x-model="form.login_attempts_limit"
                               :class="{ 'is-invalid': errors.login_attempts_limit }">
                        <template x-if="errors.login_attempts_limit">
                            <small class="text-danger" x-text="errors.login_attempts_limit"></small>
                        </template>
                    </div>

                    <!-- Autenticação de dois fatores -->
                    <div class="mb-3 col-md-6 d-flex align-items-center">
                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="enable_2fa"
                                   x-model="form.enable_2fa" true-value="1" false-value="0">
                            <label class="form-check-label" for="enable_2fa">Autenticação de 2 fatores</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Duração do bloqueio -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Duração do bloqueio (minutos)</label>
                        <input type="number" class="form-control"
                               x-model="form.lockout_duration"
                               :class="{ 'is-invalid': errors.lockout_duration }">
                        <template x-if="errors.lockout_duration">
                            <small class="text-danger" x-text="errors.lockout_duration"></small>
                        </template>
                    </div>

                    <!-- Expiração de password -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Dias até expiração da password</label>
                        <input type="number" class="form-control"
                               x-model="form.password_expiry_days"
                               :class="{ 'is-invalid': errors.password_expiry_days }">
                        <template x-if="errors.password_expiry_days">
                            <small class="text-danger" x-text="errors.password_expiry_days"></small>
                        </template>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="require_uppercase"
                                   x-model="form.require_uppercase" true-value="1" false-value="0">
                            <label class="form-check-label" for="require_uppercase">Exigir letras maiúsculas</label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="require_numbers"
                                   x-model="form.require_numbers" true-value="1" false-value="0">
                            <label class="form-check-label" for="require_numbers">Exigir números</label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="require_specials"
                                   x-model="form.require_specials" true-value="1" false-value="0">
                            <label class="form-check-label" for="require_specials">Exigir caracteres especiais</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Bloqueio por IP -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="ip_block_enabled"
                                       x-model="form.ip_block_enabled" true-value="1" false-value="0">
                                <label class="form-check-label" for="ip_block_enabled">Bloquear acessos por IP</label>
                            </div>
                        </div>

                        <!-- Faixas de IP permitidas -->
                        <div class="mb-3">
                            <label class="form-label">Faixas de IP permitidas</label>
                            <textarea class="form-control font-monospace" rows="3"
                                      x-model="form.allowed_ip_ranges"
                                      :class="{ 'is-invalid': errors.allowed_ip_ranges }"
                                      placeholder="Ex: 192.168.0.1-192.168.0.255, 10.0.0.1"></textarea>
                            <template x-if="errors.allowed_ip_ranges">
                                <small class="text-danger" x-text="errors.allowed_ip_ranges"></small>
                            </template>
                        </div>
                    </div>
                </div>


                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>
        </form>

    </div>
</div>
<?= $this->endSection() ?>
