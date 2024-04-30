<?= $this->extend('_layout/configuracao') ?>

<?= $this->section('content_card') ?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-pink">
        <div class="card-body">
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalUsuario" onclick="setNewUsuario()">
                <i class="fas fa-plus-circle"></i>
                CADASTRAR
            </button>
        </div>
    </div>
    <!-- /.card -->
</section>

<?= $this->endSection() ?>

<?= $this->section('view_content') ?>
<!-- /.content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= isset($card_title) ? $card_title : ''; ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <table id="tableUsuarios" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>APELIDO</th>
                        <th>USERNAME</th>
                        <th>E-MAIL</th>
                        <th>TELEFONE</th>
                        <th>AVATAR</th>
                        <th>STATUS</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px; text-align: center;">

                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once('componentes/usuarios_modal.php');
?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        getPermissaoUsuarioOption();
    });
</script>
<?= $this->endSection() ?>