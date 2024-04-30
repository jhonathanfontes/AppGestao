<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= 'Autenticação - JB System'; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/toastr/toastr.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('plugins/toastr/jquery.toast.min.css'); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo site_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('dist/css/adminlte.min.css'); ?>">

    <?= $this->renderSection('head') ?>
</head>

<body class="hold-transition login-page">
    <!-- Site login-box -->
    <div class="login-box">
        <?= $this->renderSection('content') ?>
    </div>
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?php echo site_url('plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo site_url('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo site_url('plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <!-- Toastr -->
    <script src="<?php echo site_url('plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?php echo site_url('plugins/toastr/jquery.toast.min.js'); ?>"></script>
    <!-- jquery-validation -->
    <script src="<?php echo site_url('plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo site_url('plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url('dist/js/adminlte.min.js'); ?>"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>