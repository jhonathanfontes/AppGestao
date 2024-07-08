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
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-archive"></i>
                <p>CADASTROS<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('app/cadastro/pessoas'); ?>"
                        class="nav-link <?= (url_is('app/cadastro/pessoas*')) ? 'active' : ''; ?>">
                        <i
                            class="far <?= (url_is('app/cadastro/pessoas*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>PESSOAS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('app/cadastro/produtos'); ?>"
                        class="nav-link <?= (url_is('app/cadastro/produtos*')) ? 'active' : ''; ?>">
                        <i
                            class="far <?= (url_is('app/cadastro/produtos*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>PRODUTOS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('app/cadastro/servicos'); ?>"
                        class="nav-link <?= (url_is('app/cadastro/servicos*')) ? 'active' : ''; ?>">
                        <i
                            class="far <?= (url_is('app/cadastro/servicos*')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                        <p>SERVIÇOS</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item <?= (url_is('app/cadastro/auxiliar/pessoas*')) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (url_is('app/cadastro/auxiliar/pessoas*')) ? 'active' : ''; ?>">
                        <i class="fab fa-buysellads text-primary"> </i>
                        <p> &nbsp; AUXILIAR PESSOAS</p> <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/pessoas/profissoes'); ?>"
                                class="nav-link <?= (url_is('app/cadastro/auxiliar/pessoas/profissoes')) ? 'active' : ''; ?>">
                                <i
                                    class="far <?= (url_is('app/cadastro/auxiliar/pessoas/profissoes')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>PROFISSÕES</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item <?= (url_is('app/cadastro/auxiliar/produtos*')) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos*')) ? 'active' : ''; ?>">
                        <i class="fab fa-buysellads text-primary"> </i>
                        <p> &nbsp; AUXILIAR PRODUTOS</p> <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/produtos/categorias'); ?>"
                                class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos/categorias')) ? 'active' : ''; ?>">
                                <i
                                    class="far <?= (url_is('app/cadastro/auxiliar/produtos/categorias')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>CATEGORIAS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/produtos/tamanhos'); ?>"
                                class="nav-link <?= (url_is('app/cadastro/auxiliar/produtos/tamanhos')) ? 'active' : ''; ?>">
                                <i
                                    class="far <?= (url_is('app/cadastro/auxiliar/produtos/tamanhos')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>TAMANHOS</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item <?= (url_is('app/cadastro/auxiliar/servicos*')) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (url_is('app/cadastro/auxiliar/servicos*')) ? 'active' : ''; ?>">
                        <i class="fab fa-buysellads text-primary"> </i>
                        <p> &nbsp; AUXILIAR SERVIÇOS</p> <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/servicos/categorias'); ?>"
                                class="nav-link <?= (url_is('app/cadastro/auxiliar/servicos/categorias')) ? 'active' : ''; ?>">
                                <i
                                    class="far <?= (url_is('app/cadastro/auxiliar/servicos/categorias')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>CATEGORIAS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('app/cadastro/auxiliar/servicos/unidade'); ?>"
                                class="nav-link <?= (url_is('app/cadastro/auxiliar/servicos/unidade')) ? 'active' : ''; ?>">
                                <i
                                    class="far <?= (url_is('app/cadastro/auxiliar/servicos/unidade')) ? 'fa-dot-circle text-warning' : ''; ?> nav-icon"></i>
                                <p>UNIDADE MEDIDA</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <!-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Simple Link
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li> -->
    </ul>
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