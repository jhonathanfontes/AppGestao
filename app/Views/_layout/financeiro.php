<?= $this->extend('_layout/default') ?>

<!-- Head -->
<?= $this->section('head') ?>

<!-- select2 -->
<link rel="stylesheet" href="<?php echo site_url('plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<!-- DataTables -->
<link rel="stylesheet" href="<?php echo site_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

<?= $this->endSection() ?>
<!-- Nav Bar -->

<?= $this->section('navbar') ?>
<!-- Left navbar links -->
<?php require_once('includes/navbar.php'); ?>
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
</ul>
<?= $this->endSection() ?>

<!-- Aside Bar -->
<?= $this->section('asidebar') ?>
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
        
        <?php require_once('includes/top_navbar.php'); ?>
        
        <li class="nav-item has-treeview  menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-calculator"></i>
                <p>FINANCEIRO<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('app/financeiro/contapagar'); ?>" class="nav-link <?= (url_is('app/financeiro/contapagar*')) ? 'active' : ''; ?>">
                        <i class="far <?= (url_is('app/financeiro/contapagar*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>CONTAS A PAGAR</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('app/financeiro/contareceber'); ?>" class="nav-link <?= (url_is('app/financeiro/contareceber*')) ? 'active' : ''; ?>">
                        <i class="far <?= (url_is('app/financeiro/contareceber*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>CONTAS A RECEBER</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item <?= (url_is('app/financeiro/auxiliar*')) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (url_is('app/financeiro/auxiliar*')) ? 'active' : ''; ?>">
                        <i class="fab fa-buysellads text-primary"> </i>
                        <p> &nbsp; AUXILIAR FINANCEIRO</p> <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="<?= base_url('app/financeiro/auxiliar/grupo'); ?>" class="nav-link <?= (url_is('app/financeiro/auxiliar/grupo')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/financeiro/auxiliar/grupo')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>GRUPO</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('app/financeiro/auxiliar/subgrupo'); ?>" class="nav-link <?= (url_is('app/financeiro/auxiliar/subgrupo')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/financeiro/auxiliar/subgrupo')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>SUBGRUPO</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <div class="user-panel d-flex">
        </div>
    </ul>
</nav>
<?= $this->endSection() ?>

<!-- Modulo Principal -->
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
</section>

<?= $this->renderSection('content_card') ?>

<?= $this->renderSection('view_content') ?>

<?= $this->endSection() ?>

<!-- Modal -->
<?= $this->section('modal') ?>
<?= $this->renderSection('modal_content') ?>
<?= $this->endSection() ?>

<!-- Footer -->
<?= $this->section('footer') ?>
<?= $this->endSection() ?>

<!-- Scritp -->
<?= $this->section('script') ?>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>

<!-- jquery-validation -->
<script src="<?php echo site_url('plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/jquery-validation/additional-methods.min.js'); ?>"></script>

<!-- InputMask -->
<script src="<?php echo site_url('plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/inputmask/jquery.inputmask.min.js'); ?>"></script>

<!-- select2 -->
<script src="<?php echo site_url('plugins/select2/js/select2.full.min.js'); ?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo site_url('plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/jszip/jszip.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/pdfmake/pdfmake.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/pdfmake/vfs_fonts.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
<!-- JBsystem -->
<script src="<?php echo site_url('dist/js/pages/jbsystem.js'); ?>"></script>
<!-- Modulo -->
<script src="<?php echo site_url('dist/js/pages/financeiro.js'); ?>"></script>

<!-- Scritp -->
<?= $this->renderSection('script') ?>

<?= $this->endSection() ?>