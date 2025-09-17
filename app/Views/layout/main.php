<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <title><?= $this->renderSection('title') ?> | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">
        <!-- Bootstrap Css -->
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/app.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body data-sidebar="dark" data-layout-mode="light">
        <div id="layout-wrapper">
            <!-- Header -->
            <?= $this->include('layout/partials/header') ?>
            <!-- Sidebar -->
            <?= $this->include('layout/partials/sidebar') ?>
            <!-- Main Content -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>

                <!-- Footer -->
                <?= $this->include('layout/partials/footer') ?>
            </div>
        </div>
        <div class="rightbar-overlay"></div>
        <!-- JS -->
        <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/app.js') ?>"></script>
        <script src="<?= base_url('assets/js/axs_alp.min.js') ?>" defer></script>

    </body>
</html>
