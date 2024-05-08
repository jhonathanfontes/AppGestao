<?= $this->extend('_layout/projeto') ?>

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
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalLocal"
                onclick="setNewLocal(<?= isset($obra->cod_obra) ? $obra->cod_obra : ''; ?>)" <?= !isset($obra->cod_obra) ? 'disabled' : ''; ?>>
                <i class="fas fa-warehouse"></i></i> LOCAL
            </button>
        </div>
    </div>
    <!-- /.card -->
</section>

<?= $this->endSection() ?>

<?= $this->section('view_content') ?>

<!-- Main content -->
<section class="content">
    <!-- Card Body - Formulario -->
    <div class="card card-warning">
        <div class="card-body">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> <?= dadosEmpresa()->emp_fantasia; ?>
                            <small class="float-right"><?php echo $card_title; ?></small>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <table>
                                <tr style="width: 40px;">
                                    <th>OBRA</th>
                                    <td><?= isset($obra->cad_obra) ? $obra->cod_obra . ' - ' . $obra->cad_obra : 'CADASTRO NÃO LOCALIZADO!'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>PREVISÃO INICIO</th>
                                    <td><?= isset($obra->cad_datainicio) ? date("d/m/Y", strtotime($obra->cad_datainicio)) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <table>
                                <tr>
                                    <th style="width: 30px;">ENDEREÇO</th>
                                    <td>
                                        <?= isset($obra->cad_endereco) ? $obra->cad_endereco : ''; ?>
                                        <?= (isset($obra->cad_endereco) && !empty($obra->cad_numero)) ? ', Nº ' . $obra->cad_numero : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>BAIRO/SETOR</th>
                                    <td><?= isset($obra->cad_setor) ? $obra->cad_cep : ''; ?></td>
                                </tr>

                                <!-- <tr>
                                <th>SITUAÇÃO</th>
                                <td><?= isset($obra->status) ? convertStatus($obra->status) : ''; ?></td>
                            </tr> -->
                            </table>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <table>
                                <tr>
                                    <th>CIDADE</th>
                                    <td>
                                        <?= isset($obra->cad_cidade) ? $obra->cad_cidade : ''; ?>
                                        <?= (isset($obra->cad_cidade) && !empty($obra->cad_estado)) ? ' - ' . $obra->cad_estado : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>CEP</th>
                                    <td><?= isset($obra->cad_cep) ? $obra->cad_cep : ''; ?></td>
                                </tr>
                                <!-- <tr>
                                <th>SITUAÇÃO</th>
                                <td><?= isset($obra->status) ? convertStatus($obra->status) : ''; ?></td>
                            </tr> -->
                            </table>
                        </address>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <h5>
                            <samp id="setLocalSeleiconado">
                                <div class="alert alert-warning alert-dismissible">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> ATENÇÃO!</h5>
                                    SELECIONE O LOCAL PARA LANÇAR O ORÇAMENTO
                                </div>
                            </samp>
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="col-sm-12 invoice-info no-print">
                            <?= form_open(base_url('/api/projeto/orcamento/inclui/produto'), ['method' => 'post', 'id' => 'formAddProduto']) ?>
                            <div class="row">
                                <div class="hidden">
                                    <input type="text" name="cod_obra" id="cod_obra" hidden="hidden">
                                    <input type="text" name="cod_local" id="cod_local" hidden="hidden">
                                    <input type="text" name="cod_produto" id="cod_produto" class="form-control" hidden
                                        required>
                                </div>
                                <div class="col-sm-5">
                                    <label>CODIGO DE BARRA / PRODUTO / SERVIÇO</label>
                                    <input type="text" name="searchProduto" id="searchProduto" class="form-control"
                                        autofocus required disabled>
                                </div>
                                <div class="col-sm-2">
                                    <label>ESTOQUE</label>
                                    <input type="text" name="est_produto" id="est_produto" value="" class="form-control"
                                        disabled="disabled" style="text-align: center;">
                                </div>
                                <div class="col-sm-2">
                                    <label>VALOR</label>
                                    <input type="text" id="val_avista" class="form-control" disabled="disabled"
                                        style="text-align: center;">
                                    <input type="text" name="valor_avista" id="valor_avista" class="form-control"
                                        hidden>
                                </div>
                                <div class="col-sm-2">
                                    <label>QUANTIDADE</label>
                                    <input type="text" name="quantidade" id="quantidade" class="form-control" disabled>
                                </div>
                                <div class="col-sm-1" style="text-align: center;">
                                    <label>ADICIONAR</label>
                                    <button type="submit" id="submitAdicionar" class="form-control btn btn-success"
                                        disabled onclick="addProdutoOrcamento()"><i class="fas fa-cart-plus">
                                        </i></button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                        <!-- /.row -->
                        <!-- Table row -->
                        <div class="row mt-2">
                           
                            <div class="col-12 table-responsive">
                                <table id="tableProdutoOrcamento" class="table table-sm table-striped"
                                    style="text-align: center;">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>CODIGO</th>
                                            <th>DESCRIÇÃO / TAMANHO</th>
                                            <th>QUANTIDADE</th>
                                            <th>VALOR</th>
                                            <th>TOTAL</th>
                                            <th class="no-print">ACÕES</th>
                                            <th class="no-print"> <a onclick="MarcarDesmarcar();">EXCLUIR</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfooter>

                                    </tfooter>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-8">
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <?php
                                        $total = 0;
                                        $apagar = 0;
                                        ?>
                                        <thead>
                                            <tr>
                                                <th style="width:50%">TOTAL</th>
                                                <td>R$ <?php echo number_format($total, 2, ',', '.') ?></td>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>TOTAL A PAGAR</th>
                                                <td>R$ <?php echo number_format($apagar, 2, ',', '.') ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="col-4">
                        <div class="col-sm-12 invoice-info no-print">
                            <div class="col-12 table-responsive">
                                <table class="table table-sm table-striped" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: justify;">LOCAL</th>
                                            <th style="text-align: justify;">DATA PREVISTA</th>
                                            <th class="no-print">ACÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($locais)): ?>
                                            <?php foreach ($locais as $row): ?>
                                                <tr style="text-align: center;">
                                                    <td><?= esc($row->cad_local) ?></td>
                                                    <td><?= esc($row->cad_datainicio) ? date("d/m/Y", strtotime($row->cad_datainicio)) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>' ?>
                                                    </td>
                                                    <td class="text-right no-print">
                                                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal"
                                                            data-target="#modalLocal"
                                                            onclick="getEditLocal(<?= $row->cod_local ?>)"><samp
                                                                class="far fa-edit"></samp> EDITAR</button>
                                                        <button type="button" class="btn btn-xs btn-success"
                                                            onclick="getCarregaLocal(<?= $row->cod_local ?>)"><samp
                                                                class="fas fa-tasks"></samp> GERENCIAR</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <?= form_open(base_url('/api/venda/finaliza/orcamento'), ['method' => 'post', 'id' => 'formfinishOrcamento']) ?>
                        <input name="venda_serial" value="" hidden="hidden">
                        <input name="venda_id" value="" hidden="hidden">
                        <input name="venda_val" value="" hidden="hidden">
                        <button type="submit" id="submitFinalizar" class="btn btn-success float-right"
                            style="margin-right: 5px;" onclick="finishOrcamento()" <?= (empty($detalhes)) ? 'disabled' : ''; ?>><i class="far fa-credit-card"></i> FINALIZAR VENDA </button>
                        <?= form_close() ?>
                        <?php if (1 == 1) { ?>
                            <button type="button" class="btn btn-danger float-right" id="buttonDescVista"
                                data-toggle="modal" data-target="#alterarDesconto" style="margin-right: 5px;"
                                <?= (empty($detalhes)) ? 'disabled' : ''; ?>>
                                DESCONTO</button>
                        <?php }
                        if (1 == 2) { ?>
                            <button type="button" class="btn btn-danger float-right" id="buttonDescPrazo"
                                data-toggle="modal" data-target="#alterarDesconto" style="margin-right: 5px;"
                                <?= (empty($detalhes)) ? 'disabled' : ''; ?>>
                                DESCONTO</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Body - Tabela -->
    </div>

</section>
<!-- /.content -->

<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once ('componentes/local_modal.php'); ?>
<?= $this->endSection() ?>