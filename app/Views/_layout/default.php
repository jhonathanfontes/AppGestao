<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= isset(dadosEmpresa()->emp_fantasia) ? setTitle(dadosEmpresa()->emp_fantasia) : setTitle('JB System'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="<?php echo site_url('dist/css/fontsgoogleapis.css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'); ?>">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="<?php echo site_url('plugins/fontawesome-free/css/all.min.css'); ?>"> -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/fontawesome-free-5.15.4/css/all.min.css'); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/toastr/toastr.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('plugins/toastr/jquery.toast.min.css'); ?>">
    <!-- jquery-ui  -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/jquery-ui/jquery-ui.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('dist/css/adminlte.min.css'); ?>">
    <?= $this->renderSection('head') ?>
</head>

<body
    class="hold-transition sidebar-mini text-sm <?= url_is('app/dashboard') ? 'layout-fixed' : 'sidebar-collapse'; ?> "
    style="height: auto;">

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= site_url('dist/img/' . dadosEmpresa()->emp_icone); ?>"
                alt="<?= dadosEmpresa()->emp_fantasia; ?>" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark <?= getenv('tema.navbar.color'); ?> font-weight">
            <?= $this->renderSection('navbar') ?>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar <?= getenv('tema.sidebar.color'); ?>  elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('app/dashboard'); ?>" class="brand-link <?= getenv('tema.navbar.color'); ?>">
                <img src="<?= site_url('dist/img/' . dadosEmpresa()->emp_icone); ?>"
                    alt="<?= dadosEmpresa()->emp_fantasia; ?>" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light"><?= dadosEmpresa()->emp_fantasia; ?>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo site_url('dist/img/avatar/avatar.png'); ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= // getUsuarioLogado()->use_apelido
                            'ADMINISTRADOR'; ?> </a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <?= $this->renderSection('asidebar') ?>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Main content Container -->
        <div class="content-wrapper">

            <?= $this->renderSection('content') ?>

            <?= $this->renderSection('modal') ?>

        </div>
        <!-- /.content -->

        <!-- Main Footer Container -->
        <footer class="main-footer no-print">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <b>Versão APP: </b> 3.0.2.1
                <b>Versão BD: </b> 2.0.1.16
            </div>
            <!-- Default to the left -->
            <strong><?= CodeIgniter\CodeIgniter::CI_VERSION ?> - Copyright &copy; 2019 - <?php echo DATE('Y'); ?> <a
                    href=""><?= dadosEmpresa()->emp_fantasia; ?></a>.</strong> Todos os direitos
            reservados.
        </footer>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
</body>
<!-- jQuery -->
<script src="<?php echo site_url('plugins/jquery/jquery.min.js'); ?>"></script>

<!-- jQuery UI -->
<script src="<?php echo site_url('plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo site_url('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- SweetAlert2 -->
<script src="<?php echo site_url('plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
<!-- Toastr -->
<script src="<?php echo site_url('plugins/toastr/toastr.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/toastr/jquery.toast.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo site_url('dist/js/adminlte.min.js'); ?>"></script>
<!-- Iconify Icon -->
<!-- <script src="https://code.iconify.design/iconify-icon/1.0.3/iconify-icon.min.js"></script> -->

<!-- Mascaras -->
<script src="<?php echo site_url('dist/js/jquery.mask.min.js'); ?>"></script>
<script src="<?php echo site_url('plugins/chart.js/Chart.min.js'); ?>"></script>
<?= $this->renderSection('script') ?>

<?php if (session()->has('MsnAtencao')): ?>
    <script>
        $(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            toastr.warning("<?= session('MsnAtencao') ?>");
        });
    </script>
<?php endif ?>

<?php if (session()->has('MsnError')): ?>
    <script>
        $(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            toastr.error("<?= session('MsnError') ?>")
        });
    </script>
<?php endif ?>

<?php if (session()->has('MsnSucesso')): ?>
    <script>
        $(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            toastr.success("<?= session('MsnSucesso') ?>")
        });
    </script>
<?php endif ?>

</html>