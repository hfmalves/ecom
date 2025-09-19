<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('admin/dashboard/components/grid_8_financial') ?>
<?= $this->include('admin/dashboard/components/table_3_view') ?>
<?= $this->endSection() ?>
