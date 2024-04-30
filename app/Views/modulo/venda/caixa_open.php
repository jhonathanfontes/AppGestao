<?= $this->extend('_layout/venda') ?>

<?= $this->section('content_card') ?>
<?php var_dump($hostname) ?>
<?php print_r(count($caixas)) ?>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card no-print">
        <div class="card-body">
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalCaixaSuplmento">
                <i class="fa fa-plus-square"></i> SUPLEMENTO CAIXA
            </button>
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalCaixaSangria">
                <i class="fa fa-minus-square"></i> SANGRIA CAIXA
            </button>
            <button class="btn btn-app bg-danger" data-toggle="modal" data-target="#modalCaixaFechar">
                <i class="fa fa-times"></i> FECHAR CAIXA
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
            <table id="tableContaPagar" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th>VENCIMENTO</th>
                        <th>VALOR</th>
                        <th>CANCELADO</th>
                        <th>PAGO</th>
                        <th>RESTANTE</th>
                        <th>FORNECERDOR</th>
                        <th>REFERENCIA</th>
                        <th>PARCELAS</th>
                        <th class="no-print">ACÕES</th>
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
<?php require_once('componentes/caixa_open_modal.php');
?>
<?= $this->endSection() ?>