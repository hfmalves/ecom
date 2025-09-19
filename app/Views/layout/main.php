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
        <link href="<?= base_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

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
        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

        <!-- jQuery (mantém só 1 versão, não duas) -->
        <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>

        <!-- Bootstrap, plugins -->
        <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>

        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- DataTables -->
        <script src="<?= base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/pages/datatables.init.js') ?>"></script>
        <!-- Buttons examples -->
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/jszip/jszip.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/pdfmake/build/pdfmake.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/pdfmake/build/vfs_fonts.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') ?>"></script>


        <!-- O teu app.js (que tem showToast) -->
        <script src="<?= base_url('assets/js/app.js') ?>"></script>

        <!-- Alpine -->
        <script src="<?= base_url('assets/js/axs_alp.min.js') ?>" defer></script>

        <!-- Summernote -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

        <?= $this->renderSection('content-script') ?>

    </body>
</html>
