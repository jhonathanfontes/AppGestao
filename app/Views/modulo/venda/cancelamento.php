<?= $this->extend('_layout/venda') ?>

<?= $this->section('content_card') ?>

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
                    <tr>
                        <th>VENDA</th>
                        <th>CLIENTE</th>
                        <th>PEÇAS</th>
                        <th>VALOR</th>
                        <th>DATA</th>
                        <th>VENDEDOR</th>
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
<?php // require_once('componentes/contasapagar_modal.php'); 
?>
<?= $this->endSection() ?>