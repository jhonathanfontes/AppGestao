<?= $this->extend('_layout/default') ?>

<!-- Head -->
<?= $this->section('head') ?>

<?= $this->endSection() ?>
<!-- Nav Bar -->

<?= $this->section('navbar') ?>
<!-- Left navbar links -->
<?php require_once ('includes/navbar.php'); ?>
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

        <?php require_once ('includes/top_navbar.php'); ?>

        <div class="user-panel d-flex">
        </div>

        <li class="nav-item has-treeview <?= (url_is('appprestador/servico*')) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?= (url_is('appprestador/servico*')) ? 'active' : ''; ?>">
                <i class="nav-icon fa fa-th"></i>
                <p>SERVIÇOS<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('appprestador/servico/andamento'); ?>"
                        class="nav-link <?= (url_is('appprestador/servico/andamento*')) ? 'active' : ''; ?>">
                        <i
                            class="far <?= (url_is('appprestador/servico/andamento*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>EM ANDAMENTO</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('appprestador/servico/finalizado'); ?>"
                        class="nav-link <?= (url_is('appprestador/servico/finalizado*')) ? 'active' : ''; ?>">
                        <i
                            class="far <?= (url_is('appprestador/servico/finalizado*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>FINALIZADO</p>
                    </a>
                </li>
            </ul>
        </li>

        <div class="user-panel d-flex">
        </div>

        <li class="nav-item has-treeview <?= (url_is('appprestador/relatorio*')) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?= (url_is('appprestador/relatorio*')) ? 'active' : ''; ?>">
                <i class="nav-icon fa fa-file"></i>
                <p>RELATÓRIOS<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('appprestador/relatorio/servico'); ?>"
                        class="nav-link <?= (url_is('appprestador/relatorio/servico*')) ? 'active' : ''; ?>">
                        <i
                            class="far <?= (url_is('appprestador/relatorio/servico*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>SERVIÇOS</p>
                    </a>
                </li>

            </ul>
        </li>

</nav>
<?= $this->endSection() ?>

<!-- Modulo Principal -->
<?= $this->section('content') ?>
<?= $this->renderSection('content') ?>
<?= $this->endSection() ?>

<!-- Footer -->
<?= $this->section('footer') ?>
<?= $this->endSection() ?>

<!-- Scritp -->
<?= $this->section('script') ?>

<?= $this->endSection() ?>