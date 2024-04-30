<?= $this->extend('_layout/financeiro') ?>

<?= $this->section('content_card') ?>

<!-- Main content -->
<section class="content no-print">
    <div class="container-fluid">
        <h5 class="text-sm font-weight">CADASTRAR NOVO</h5>
    </div><!-- /.container-fluid -->
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalGrupo" onclick="setNewGrupo()">
                <i class="fa fa-tag"></i> GRUPO
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
            <table id="tableGrupos" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th>DESCRIÇÃO</th>
                        <th>TIPO</th>
                        <th>CLASSIFICAÇÃO</th>
                        <th style="width: 10%;">SITUAÇÃO</th>
                        <th style="width: 20%;" class="no-print">ACÕES</th>
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
<?php require_once('componentes/grupo_modal.php'); ?>
<?= $this->endSection() ?>