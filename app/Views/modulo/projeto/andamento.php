<?= $this->extend('_layout/projeto') ?>

<?= $this->section('view_content') ?>
<!-- /.content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-pink">

        <div class="card-header">
            <h3 class="card-title"><?= isset($card_title) ? $card_title : ''; ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                    title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <table id="tableObrasAndamento" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th style="width: 10%;">CODIGO</th>
                        <th>DESCRICÃO</th>
                        <th>DATA PREVISTA</th>
                        <th>CLIENTE</th>
                        <th style="width: 20%;">AÇÕES</th>
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
<?php require_once ('componentes/obra_modal.php'); ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function () {
        getClientesOption();
    });
</script>
<?= $this->endSection() ?>