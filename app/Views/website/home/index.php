<?= $this->extend('layout/main_website') ?>
<?= $this->section('content') ?>
<?= $this->include('layout/partials_website/modules/slider_01') ?>
<?= $this->include('layout/partials_website/modules/box_icons') ?>
<?= $this->include('layout/partials_website/modules/category_loop_01') ?>
<?php if ($leftBlock): ?>
    <?= view('layout/partials_website/modules/banner_product_left', ['block' => $leftBlock]) ?>
<?php endif; ?>

<?php if ($rightBlock): ?>
    <?= view('layout/partials_website/modules/banner_product_right', ['block' => $rightBlock]) ?>
<?php endif; ?>
<?= $this->include('layout/partials_website/modules/product_loop_link') ?>
<?= $this->endSection() ?>
