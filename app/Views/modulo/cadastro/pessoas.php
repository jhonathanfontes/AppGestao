<?= $this->extend('_layout/cadastro') ?>

<?= $this->section('content_card') ?>

<!-- Main content-header -->
<section class="content-header">
    <div class="container-fluid">
        <h5 class="text-sm font-weight">ADICIONAR NOVO CADASTRO</h5>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <button class="btn btn-app <?= getenv('tema.btn.app1.color'); ?>" data-toggle="modal" data-target="#modalPessoa" onclick="setNewPessoa()">
                <i class="fa fa-male"></i> PESSOA
            </button>
            <button class="btn btn-app <?= getenv('tema.btn.app2.color'); ?>" data-toggle="modal" data-target="#modalProfissao" onclick="setNewProfissao()">
                <i class="fa fa-hammer"></i> PROFISSÃO
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
    <div class="card <?= getenv('tema.card.header.color'); ?>">
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
            <table id="tablePessoas" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th>NOME/RAZÃO</th>
                        <th>APELIDO</th>
                        <th>TIPO</th>
                        <th>DOCUMENTO</th>
                        <th>E-MAIL</th>
                        <th>TELEFONE</th>
                        <th>STATUS</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px;">
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once('componentes/pessoa_modal.php'); ?>
<?php require_once('componentes/profissao_modal.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        getProfissaoOption();
    });
</script>
<?= $this->endSection() ?>