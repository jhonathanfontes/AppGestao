<?= $this->extend('_layout/venda') ?>

<?= $this->section('content_card') ?>
<!-- Main content -->
<section class="content">
    <!-- Card Body - Formulario -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= $card_title; ?></h3>
        </div>
        <div class="card-body">
            <?= form_open(base_url('/api/venda/orcamento/novo'), ['method' => 'post', 'id' => 'formNovoOrcamento']) ?>
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <input name="cod_tipo" value="1" hidden="hidden">
                        <select name="cod_pessoa" id="cod_pessoa" class="form-control select2bs4" style="width: 100%;">
                            <?php if (!empty($clientes)) : ?>
                                <?php foreach ($clientes as $row) : ?>
                                    <option value="<?php echo $row->cod_pessoa ?>" <?php if ($row->cad_padrao == 'S') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>
                                        <?php echo $row->cad_nome ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary" id="GerarNovoOrcamento" onclick="NovoOrcamento()">Selecionar</button>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- Card Body - Tabela -->
    </div>
    <!-- /.card -->
</section>
<?= $this->endSection() ?>

<?= $this->section('view_content') ?>

<section class="content">
    <!-- Card Body - Formulario -->
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= $card_title_orcamento; ?></h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableOrcamentoOpem" class="table table-bordered table-striped table-sm">
                    <thead style="text-align: center;">
                        <tr>
                            <th>ORÇAMENTO</th>
                            <th>CLIENTE</th>
                            <th>VENDEDOR</th>
                            <th>DATA</th>
                            <th style="width: 15%;">ACÕES</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                       
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card Body - Tabela -->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php // require_once('componentes/contasapagar_modal.php'); 
?>
<?= $this->endSection() ?>