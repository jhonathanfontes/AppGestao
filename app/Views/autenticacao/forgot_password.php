<?= $this->extend('_layout/login') ?>

<?= $this->section('content') ?>
<!-- /.login-logo -->
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="#" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Você esqueceu sua senha? <br>
            Aqui você pode solicitar uma nova senha.</p>
        <?= form_open(base_url('api/autenticacao/forgot/password'), ['method' => 'post', 'id' => 'formEsqueciSenha']) ?>
        <div class="input-group mb-3">
            <input name="email" type="email" class="form-control" placeholder="E-mail">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary btn-block" id="btnRecuperaSenha" onclick="recuperarSenha()">Enviar</button>
            </div>
            <!-- /.col -->
        </div>
        <?= form_close(); ?>

        <p class="mb-1 mt-3">
            <a href="<?= base_url('/autenticacao'); ?>">Voltar ao login</a>
        </p>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Modulo -->
<script src="<?php echo site_url('dist/js/pages/autenticacao.js'); ?>"></script>
<?= $this->endSection() ?>