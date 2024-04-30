<?= $this->extend('_layout/login') ?>

<?= $this->section('content') ?>
<!-- /.login-logo -->
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="#" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Você está a apenas um passo de sua nova senha, recupere sua senha agora.</p>
        <?= form_open(base_url('api/autenticacao/recover/password'), ['method' => 'post', 'id' => 'formRedefinirSenha']) ?>
        <div class="input-group mb-3">
            <input name="password" type="password" class="form-control" placeholder="Senha" autocomplete="FALSE">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input name="confirm_password" type="password" class="form-control" placeholder="Confirme a Senha" autocomplete="FALSE">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary btn-block" id="btnLogin" onclick="login()">Entrar</button>
            </div>
            <!-- /.col -->
        </div>
        <?= form_close(); ?>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Modulo -->
<script src="<?php echo site_url('dist/js/pages/autenticacao.js'); ?>"></script>
<?= $this->endSection() ?>