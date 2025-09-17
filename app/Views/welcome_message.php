<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<h1>Bem-vindo à loja!</h1>
<p>Aqui vai o conteúdo da página.</p>
<div x-data="{ msg: 'Olá Alpine!' }">
    <h1 x-text="msg"></h1>
</div>
<?= $this->endSection() ?>
