<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <title>Login | Ecommerce</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sistema de Ecommerce" name="description" />
        <meta content="Wolf Dev" name="author" />
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">
        <!-- owl.carousel css -->
        <link rel="stylesheet" href="<?= base_url('assets/libs/owl.carousel/assets/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/libs/owl.carousel/assets/owl.theme.default.min.css') ?>">
        <!-- Bootstrap Css -->
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- App Css -->
        <link href="<?= base_url('assets/css/app.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    </head>
    <body class="auth-body-bg">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-8">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">
                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-4">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="assets/images/logo-dark.png" alt="" height="18" class="auth-logo-dark">
                                        <img src="assets/images/logo-light.png" alt="" height="18" class="auth-logo-light">
                                    </a>
                                </div>
                                <div class="my-auto">
                                    <div>
                                        <h5 class="text-primary">Recuperar Conta</h5>
                                        <p class="text-muted">Introduza o seu email para receber o link de redefinição da palavra-passe.</p>

                                    </div>
                                    <div class="mt-4">
                                        <form
                                                x-data="formHandler(
                                                        '<?= base_url('admin/auth/reset') ?>',
                                                        { token: '<?= esc($token) ?>', password: '', password_confirm: '', <?= $csrf['token'] ?>: '<?= $csrf['hash'] ?>' },
                                                        { redirect: '<?= site_url('admin/auth/login') ?>' }
                                                    )"
                                                @submit.prevent="submit()"
                                        >
                                            <input type="hidden" name="token" x-model="form.token">

                                            <!-- Nova Password -->
                                            <div class="mb-3" x-data="{ field: 'password' }">
                                                <label class="form-label" :for="field">Nova Password</label>
                                                <input type="password"
                                                       class="form-control"
                                                       :id="field"
                                                       :name="field"
                                                       x-model="form[field]"
                                                       :class="{ 'is-invalid': errors[field] }">
                                                <template x-if="errors[field]">
                                                    <small class="text-danger" x-text="errors[field]"></small>
                                                </template>
                                            </div>

                                            <!-- Confirmar Password -->
                                            <div class="mb-3" x-data="{ field: 'password_confirm' }">
                                                <label class="form-label" :for="field">Confirmar Password</label>
                                                <input type="password"
                                                       class="form-control"
                                                       :id="field"
                                                       :name="field"
                                                       x-model="form[field]"
                                                       :class="{ 'is-invalid': errors[field] }">
                                                <template x-if="errors[field]">
                                                    <small class="text-danger" x-text="errors[field]"></small>
                                                </template>
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                                    <span x-show="!loading">Alterar Password</span>
                                                    <span x-show="loading">A alterar...</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Bagg – eCommerce para profissionais  <br> Engineered with <i class="mdi mdi-heart text-danger"></i> by Hugo Digital Studio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- Scripts -->
        <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/owl.carousel/owl.carousel.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/pages/auth-2-carousel.init.js') ?>"></script>
        <script src="<?= base_url('assets/js/app.js') ?>"></script>
        <script src="<?= base_url('assets/js/axs_alp.min.js') ?>" defer></script>
    </body>
</html>
