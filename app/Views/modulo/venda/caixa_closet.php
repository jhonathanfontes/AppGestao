<?= $this->extend('_layout/venda') ?>

<?= $this->section('content_card') ?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card no-print">
        <div class="card-body">
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalAbrirCaixa" onclick="buscaCaixaAnterior()">
                <i class="fa fa-credit-card"></i> ABRIR CAIXA
            </button>
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalReabrirCaixa">
                <i class="fa fa-compress"></i> REABRIR CAIXA
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
            <table id="tableCaixaCloset" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th>CODIGO</th>
                        <th>DATA ABERTURA</th>
                        <th>VALOR ABERTURA</th>
                        <th>USUARIO</th>
                        <th>DATA FECHAMENTO</th>
                        <th>VALOR FECHAMENTO</th>
                        <th>USUARIO</th>
                        <th class="no-print">ACÕES</th>
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
<?php require_once('componentes/caixa_closet_modal.php');
?>
<?= $this->endSection() ?>