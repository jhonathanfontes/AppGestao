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

<!-- summernote -->
<link rel="stylesheet" href="<?php echo site_url('plugins/summernote/summernote-bs4.min.css'); ?>">

<?= $this->renderSection('stylesheet_css') ?>

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
        <li class="nav-item">
            <a href="<?= base_url('/autenticacao/logout'); ?>" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                <p> DESLOGAR</p>
            </a>
        </li>
        <div class="user-panel d-flex">
        </div>
        <!-- Menu Dashboard -->
        <li class="nav-item">
            <a href="<?= base_url('app/dashboard'); ?>" class="nav-link <?= (url_is('app/dashboard')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-laptop"></i>
                <p>DASHBOARD</p>
            </a>
        </li>
        <li class="nav-item has-treeview <?= (!url_is('app/caixa*')) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?= (!url_is('app/caixa*')) ? 'active' : ''; ?>">
                <i class="nav-icon fa fa-cart-arrow-down"></i>
                <p>PROJETO<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('app/projeto/obra'); ?>" class="nav-link <?= (url_is('app/projeto/obra*')) ? 'active' : ''; ?>">
                        <i class="far <?= (url_is('app/projeto/obra*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>OBRA</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item <?= (url_is('app/projeto/gerenciar/obra*')) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (url_is('app/projeto/gerenciar/obra*')) ? 'active' : ''; ?>">
                        <i class="fab fa-buysellads text-primary"> </i>
                        <p> &nbsp; GERENCIAR OBRAS</p> <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('app/projeto/gerenciar/obra/andamento'); ?>" class="nav-link <?= (url_is('app/projeto/gerenciar/obra/andamento*')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/projeto/gerenciar/obra/andamento')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>OBRAS EM ANDAMENTO</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('app/projeto/gerenciar/obra/finalizada'); ?>" class="nav-link <?= (url_is('app/projeto/gerenciar/obra/finalizada*')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/projeto/gerenciar/obra/finalizada')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>OBRAS FINALIZADAS</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> 
            <!-- <ul class="nav nav-treeview">
                <li class="nav-item <?= (url_is('app/cadastro/auxiliar/produtos*')) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos*')) ? 'active' : ''; ?>">
                        <i class="fab fa-buysellads text-primary"> </i>
                        <p> &nbsp; Auxiliar Produtos</p> <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/produtos/categorias'); ?>" class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos/categorias')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/cadastro/auxiliar/produtos/categorias')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/produtos/subcategorias'); ?>" class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos/subcategorias')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/cadastro/auxiliar/produtos/subcategorias')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>Subcategorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/produtos/fabricantes'); ?>" class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos/fabricantes')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/cadastro/auxiliar/produtos/fabricantes')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>Fabricantes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/produtos/tamanhos'); ?>" class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos/tamanhos')) ? 'active' : ''; ?>">
                                <i class="far <?= (url_is('app/cadastro/auxiliar/produtos/tamanhos')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>Tamanhos</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> -->
        </li>
        <!-- <li class="nav-item">
            <a href="<?= base_url('app/caixa'); ?>" class="nav-link <?= (url_is('app/caixa')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-cash-register"></i>
                <p>CAIXA</p>
            </a>
        </li> -->
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

<!-- jQuery UI -->
<script src="<?php echo site_url('plugins/jquery-ui/jquery.ui.autocomplete.scroll.min.js'); ?>"></script>

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
<script src="<?php echo site_url('plugins/summernote/summernote-bs4.min.js'); ?>"></script>
<!-- JBsystem -->
<script src="<?php echo site_url('dist/js/pages/jbsystem.js'); ?>"></script>
<!-- Modulo -->
<script src="<?php echo site_url('dist/js/pages/projeto.js'); ?>"></script>

<!-- Scritp -->
<?= $this->renderSection('script') ?>

<?= $this->endSection() ?>