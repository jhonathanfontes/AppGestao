<?= $this->extend('_layout/configuracao') ?>

<?= $this->section('view_content') ?>
<section class="content">
    <div class="card-body">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">

            <?php // var_dump($formapagamento); 
            ?>

            <!-- title row -->
            <div class="row">
                <div class="col-8">
                    <h4>
                        <i class="fas fa-globe"></i> <?php // echo $empresa['emp_fantasia']; 
                                                        ?>
                        <small class="float-right"><?php // echo $pessoa->codigo 
                                                    ?></small>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-2">
                    <?php
                    if (isset($formapagamento->status)) {
                        if ($formapagamento->status == 1 or $formapagamento->status == 2) { ?>
                            <button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar( 'formapagamento' , <?= isset($formapagamento->cod_forma) ? $formapagamento->cod_forma : null;  ?>)"><samp class="fa fa-archive"></samp> ARQUIVAR</button>
                        <?php } ?>
                    <?php } ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th>CODIGO INTERNO</th>
                                <td><?= isset($formapagamento->cod_forma) ? $formapagamento->cod_forma : '';  ?></td>
                            </tr>
                            <tr>
                                <th>DESCRIÇÃO</th>
                                <td><?= isset($formapagamento->cad_descricao) ? $formapagamento->cad_descricao : 'CADASTRO NÃO LOCALIZADO!';  ?></td>
                            </tr>
                            <tr>
                                <th>FORMA DE PAGAMENTO</th>
                                <td><?= isset($formapagamento->cad_forma) ? convertFormarPagamento($formapagamento->cad_forma) : '';  ?></td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <address>
                        <table>
                            <?php if (isset($formapagamento->cad_forma) && ($formapagamento->cad_forma == 3 || $formapagamento->cad_forma == 4)) : ?>
                                <tr>
                                    <th>MAQUINA DE CARTÃO</th>
                                    <td><?= isset($formapagamento->maq_descricao) ? $formapagamento->maq_descricao : 'CADASTRO NÃO LOCALIZADO!';  ?></td>
                                </tr>
                                <tr>
                                    <th>PARCELA PAGAMENTO</th>
                                    <td><?= isset($formapagamento->cad_parcela) ? convertSimNao($formapagamento->cad_parcela) : '';  ?></td>
                                </tr>
                                <tr>
                                    <th>ANTECIPA PARCELA</th>
                                    <td><?= isset($formapagamento->cad_antecipa) ? convertSimNao($formapagamento->cad_antecipa) : '';  ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </address>
                </div>
                <div class="col-sm-3 invoice-col">
                    <address>
                        <table>
                            <?php if (isset($formapagamento->cad_forma) && ($formapagamento->cad_forma == 3 || $formapagamento->cad_forma == 4)) : ?>
                                <tr>
                                    <th>AGENCIA</th>
                                    <td><?= isset($formapagamento->con_agencia) ? $formapagamento->con_agencia : 'CADASTRO NÃO LOCALIZADO!';  ?></td>
                                </tr>
                                <tr>
                                    <th>CONTA <?= (isset($formapagamento->con_tipo) && $formapagamento->con_tipo == 'C') ? 'CORRENTE' : 'POUPANÇA';  ?></th>
                                    <td><?= isset($formapagamento->con_conta) ? $formapagamento->con_conta : '';  ?></td>
                                </tr>
                                <tr>
                                    <th>CONTA BANCARIA</th>
                                    <td><?= isset($formapagamento->con_descricao) ? $formapagamento->con_descricao : '';  ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th>SITUAÇÃO</th>
                                <td><?= isset($formapagamento->status) ? convertStatus($formapagamento->status) : '';  ?></td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</section>
<?php
if (isset($formapagamento->cad_forma) && ($formapagamento->cad_forma == 3 || $formapagamento->cad_forma == 4)) { ?>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-pink">
            <div class="card-header">
                <h3 class="card-title">PARCELAMENTOS PARA : <?= isset($formapagamento->cad_descricao) ? $formapagamento->cad_descricao : 'CADASTRO NÃO LOCALIZADO!';  ?></h3>
                <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modalFormaParcelamento"><samp class="fas fa-plus"> PARCELAS</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <table id="tableFormaParcelamento" class="table table-sm table-bordered table-striped" style="text-align: center;">
                            <thead>
                                <th>BANDEIRA</th>
                                <th>AÇÃO</th>
                            </thead>
                            <tbody>
                                <?php if (!empty($bandeiras)) : ?>
                                    <?php foreach ($bandeiras as $row) : ?>
                                        <tr>
                                            <td style="text-align: left;"><?= isset($row->cad_bandeira) ? $row->cad_bandeira : '';  ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-outline-info mr-2" onclick="carregaParcelamentoBandeira(<?= isset($formapagamento->cod_forma) ? $formapagamento->cod_forma : '';  ?>,<?= isset($row->cod_bandeira) ? $row->cod_bandeira : '';  ?>)"><span class="fas fa-sync-alt"></span> CARREGAR</button>
                                                <button class="btn btn-xs btn-outline-success" data-toggle="modal" data-target="#modalFormasParcelamentos" onclick="gerenciarParcelamentoBandeira(<?= isset($formapagamento->cod_forma) ? $formapagamento->cod_forma : '';  ?>,<?= isset($row->cod_bandeira) ? $row->cod_bandeira : '';  ?>)"><span class="fas fa-tasks"></span> GERENCIAR</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        <table id="tableFormaPagamentoParcelamento" class="table table-sm table-bordered table-striped" style="text-align: center;">
                            <thead>
                                <th>PARCELA</th>
                                <th>PRAZO</th>
                                <th>TAXA</th>
                                <th style="width: 15%;">STATUS</th>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
<?php
}

?>
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once('componentes/formapagamento_modal.php');
?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
       
    });
</script>
<?= $this->endSection() ?>