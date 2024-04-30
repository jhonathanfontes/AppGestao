<?= $this->extend('_layout/login') ?>

<?= $this->section('content') ?>
<!-- /.login-logo -->
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="#" class="h1"><b><?= getenv('autenticacao.cardHeader'); ?></b><?= getenv('autenticacao.subCardHeader'); ?></a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Identifique-se para acessar o sistema!</p>
        <?= form_open(base_url('api/autenticacao/login'), ['method' => 'post', 'id' => 'formLogin']) ?>
        <div class="input-group mb-3">
            <input name="credencial" type="email" class="form-control" placeholder="INFORME SEU E-MAIL">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input name="password" id="txtSenha" type="password" class="form-control" placeholder="INFORME A SUA SENHA" autocomplete="off" minlength="6" maxlength="12">
                <div class="input-group-append">
                    <button class="btn btn-outline-info" type="button" onclick="mostrarPassword()"><i class="fa fa-eye-slash" id="btnEyePassword"></i></button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 ">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Lembre de mim
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary btn-block" id="submitFormLogin" onclick="login()">Entrar</button>

            </div>
            <!-- /.col -->
        </div>
        <?= form_close(); ?>

        <p class="mb-1 mt-3">
            <a href="<?= base_url('/autenticacao/forgot/password'); ?>">Esqueci a minha senha</a>
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