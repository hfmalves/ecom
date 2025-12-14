<?= $this->extend('layout/main_website') ?>

<?= $this->section('content') ?>

<?php foreach ($blocks as $block): ?>
    <?= $this->include('layout/partials_website/blocks/' . $block) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>