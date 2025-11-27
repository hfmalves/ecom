<?= $this->extend('layout/main_website') ?>
<?= $this->section('content') ?>

<?php foreach ($modules as $m): ?>
    <?php
    $file = 'layout/partials_website/modules/' . $m['type'];

    $params = [
        'data' => $m['data'] ?? [],
        'title' => $m['title'] ?? null,
        'subtitle' => $m['subtitle'] ?? null,
    ];
    ?>

    <?php if (is_file(APPPATH . 'Views/' . $file . '.php')): ?>
        <?= view($file, $params) ?>
    <?php endif; ?>
<?php endforeach; ?>

<?= $this->endSection() ?>
