<?= $this->extend('layout/main_website') ?>

<?= $this->section('content') ?>

<?php foreach ($blocks as $block): ?>
    <?= view('layout/partials_website/blocks/' . $block['block_type'], [
        'block' => $block
    ]) ?>
<?php endforeach; ?>

<?= $this->endSection() ?>
