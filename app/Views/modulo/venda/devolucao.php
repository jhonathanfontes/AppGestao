<?= $this->extend('_layout/venda') ?>

<?= $this->section('content_card') ?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-warning">
        <div class="card-body">
            <div class="form-group col-md-12">
                <form method="post">
                    <div class="row">
                        <div class="form-group col-5">
                            <label for="">CLIENTE</label>
                            <select name="cod_pessoa" class="form-control select2bs4" style="width: 100%;" required="required">
                                <option value="0">TODOS</option>
                                <?php if (!empty($clientes)) : ?>
                                    <?php foreach ($clientes as $row) : ?>
                                        <option value="<?php echo $row->cod_pessoa ?>"><?php echo $row->cad_nome ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label for="">DATA INICIO</label>
                            <input name="data_inicio" id="data_inicio" type="date" value="<?= date("Y-01-01"); ?>" class="form-control">
                        </div>
                        <div class="form-group col-2">
                            <label for="">DATA FIM</label>
                            <input name="data_final" id="data_final" type="date" value="<?= date("Y-m-t", mktime(0, 0, 0, date("m"), '01', date("Y"))); ?>" class="form-control">
                        </div>
                        <div class="form-group col-2">
                            <label for="">VENDA</label>
                            <input name="venda_id" id="venda_id" type="number" class="form-control">
                        </div>
                        <div class="form-group col-1" style="text-align: center;">
                            <label for="">PESQUISAR</label>
                            <button type="submit" class="btn btn-primary float-right"> &nbsp; &nbsp; &nbsp; <i class="fas fa-search"></i> &nbsp; &nbsp; &nbsp;</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</section>
<!-- /.content -->

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