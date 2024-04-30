<?= $this->extend('_layout/financeiro') ?>

<?= $this->section('content_card') ?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card no-print">
        <div class="card-body">
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalReceber" onclick="setNewReceber()">
                <i class="fa fa-credit-card"></i> CADASTRAR
            </button>
            <!-- <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalReceber" onclick="setNewReceber()">
                <i class="fa fa-compress"></i> AGRUPAR
            </button> -->
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalReceber" onclick="setNewReceber()">
                <i class="fa fa-search-plus"></i> PESQUISAR
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
            <table id="tableContaReceber" class="table table-sm table-bordered table-striped">
                <thead>
                    <!-- <tr style="text-align: center;">
                        <th>VENCIMENTO</th>
                        <th>VALOR</th>
                        <th>CANCELADO</th>
                        <th>RECEBIDO</th>
                        <th>RESTANTE</th>
                        <th>CLIENTE</th>
                        <th style="width: 15%;">REFERENCIA</th>
                        <th>PARCELAS</th>
                        <th class="no-print">EDITAR</th>
                        <th class="no-print">GERENCIAR</th>
                    </tr> -->
                    <tr style="text-align: center;">
                        <th>CLIENTE</th>
                        <th>VALOR</th>
                        <th>CANCELADO</th>
                        <th>RECEBIDO</th>
                        <th>RESTANTE</th>
                        <th>VENCIDO</th>
                        <th>-</th>
                        <th>A VENCER</th>
                        <th>-</th>
                        <th class="no-print">GERENCIAR</th>
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
<?php require_once('componentes/contasareceber_modal.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        getClientesOption();
        getContasReceitaOption();
    });
</script>
<?= $this->endSection() ?>