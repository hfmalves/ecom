<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <title><?= $this->renderSection('title') ?> | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">
        <!-- Plugin CSS (ordem importa!) -->
        <link href="<?= base_url('assets/libs/select2/css/select2.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/libs/spectrum-colorpicker2/spectrum.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
        <!-- CSS base do tema -->
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
                <!-- Modal Global -->
                <div class="modal fade" id="globalModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" id="globalModalDialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="globalModalTitle">Título</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body" id="globalModalBody">Conteúdo inicial...</div>
                            <div class="modal-footer" id="globalModalFooter"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="rightbar-overlay"></div>

        <!-- Core JS -->
        <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>
        <!-- Plugins -->
        <script src="<?= base_url('assets/libs/select2/js/select2.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/spectrum-colorpicker2/spectrum.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') ?>"></script>
        <!-- DataTables -->
        <script src="<?= base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/jszip/jszip.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/pdfmake/build/pdfmake.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/pdfmake/build/vfs_fonts.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
        <script src="<?= base_url('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/pages/datatables.init.js') ?>"></script>
        <!-- Form advanced init -->
        <script src="<?= base_url('assets/js/pages/form-advanced.init.js') ?>"></script>
        <!-- Summernote -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
        <!-- Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- App principal -->
        <script src="<?= base_url('assets/js/app.js') ?>"></script>
        <!-- Alpine -->
        <script src="<?= base_url('assets/js/axs_alp.min.js') ?>" defer></script>
        <?= $this->renderSection('content-script') ?>
    </body>
</html>
