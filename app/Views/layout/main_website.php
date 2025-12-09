<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title><?= esc($title ?? 'Loja') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/website/fonts/fonts.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/website/icon/icomoon/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/website/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/website/css/swiper-bundle.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/website/css/animate.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/website/css/styles.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/website/images/logo/favicon.svg') ?>">
    <link rel="apple-touch-icon-precomposed" href="<?= base_url('assets/website/images/logo/favicon.svg') ?>">
</head>
    <body>
        <button id="goTop">
            <span class="border-progress"></span>
            <span class="icon icon-caret-up"></span>
        </button>
        <div class="preload preload-container" id="preload">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>
        <div id="wrapper">
            <?= $this->include('layout/partials_website/top_bar') ?>
            <?= $this->include('layout/partials_website/tf_header') ?>
            <?= $this->include('layout/partials_website/tf_header_fixed') ?>
            <?= $this->renderSection('content') ?>
            <?= $this->include('layout/partials_website/modules/footer') ?>
        </div>
        <?= $this->include('layout/partials_website/mobile_menu') ?>
        <?= $this->include('layout/partials_website/toolbar_bottom') ?>
        <?= $this->include('layout/partials_website/modal/quick_view') ?>
        <?= $this->include('layout/partials_website/modal/search') ?>
        <?= $this->include('layout/partials_website/modal/cart') ?>
        <script src="<?= base_url('assets/website/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/swiper-bundle.min.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/carousel.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/bootstrap-select.min.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/lazysize.min.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/wow.min.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/parallaxie.js') ?>"></script>
        <script src="<?= base_url('assets/website/js/main.js') ?>"></script>
    </body>
</html>