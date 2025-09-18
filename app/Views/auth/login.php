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
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p class="text-muted">Sign in to continue to Skote.</p>
                                    </div>
                                    <div class="mt-4">
                                        <form
                                                x-data="formHandler(
                                                    '<?= site_url('auth/login') ?>',
                                                    { email: '', password: '', remember: false, code: '', <?= csrf_token() ?>: '<?= csrf_hash() ?>' }
                                                )"
                                                @submit.prevent="step === 'login'
                                                ? submit()
                                                : submit2FA('<?= site_url('auth/verify2FA') ?>')">

                                            <!-- STEP LOGIN -->
                                            <div x-show="step === 'login'">
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="email"
                                                           name="email"
                                                           placeholder="Enter your email address"
                                                           x-model="form.email"
                                                           :class="{ 'is-invalid': errors.email }">

                                                    <template x-if="errors.email">
                                                        <small class="text-danger" x-text="errors.email"></small>
                                                    </template>
                                                </div>

                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="<?= base_url('auth/recovery') ?>" class="text-muted">Esqueceu-se da password?</a>
                                                    </div>

                                                    <label class="form-label" for="password">Password</label>
                                                    <div class="input-group auth-pass-inputgroup">
                                                        <input type="password"
                                                               class="form-control"
                                                               id="password"
                                                               name="password"
                                                               placeholder="Enter password"
                                                               x-model="form.password"
                                                               :class="{ 'is-invalid': errors.password }">

                                                        <button class="btn btn-light" type="button" id="password-addon">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                        </button>
                                                    </div>

                                                    <template x-if="errors.password">
                                                        <small class="text-danger" x-text="errors.password"></small>
                                                    </template>
                                                </div>

                                                <!-- Remember -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remember" x-model="form.remember">
                                                    <label class="form-check-label" for="remember">Remember me</label>
                                                </div>
                                            </div>
                                            <!-- STEP 2FA -->
                                            <div x-show="step === '2fa'">
                                                <div class="mb-3">
                                                    <label for="code" class="form-label">Código de Validação</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="code"
                                                           name="code"
                                                           placeholder="Introduza o código"
                                                           x-model="form.code"
                                                           :class="{ 'is-invalid': errors.code }">
                                                    <template x-if="errors.code">
                                                        <small class="text-danger" x-text="errors.code"></small>
                                                    </template>
                                                </div>
                                            </div>
                                            <!-- Botão único -->
                                            <div class="mt-3 d-grid">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                        :disabled="loading">
                                                    <span x-show="!loading" x-text="step === 'login' ? 'Log In' : 'Validar Código'"></span>
                                                    <span x-show="loading">A validar...</span>
                                                </button>
                                            </div>
                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Don't have an account ?
                                                <a href="auth-register-2.html" class="fw-medium text-primary"> Signup now </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
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
