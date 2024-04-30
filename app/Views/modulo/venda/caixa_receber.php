<?= $this->extend('_layout/venda') ?>

<?= $this->section('view_content') ?>

<section class="content">
    <?php if (!empty($pontuacao)) : ?>
        <div class="content">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Olá, <?= $this->session->userdata('jb_apelido'); ?>!</strong> <?= $pontuacao->pes_nome; ?> POSSUI
                <strong><?= $pontuacao->pontos - $pontuacao->utilizados; ?> PONTOS</strong> NO PROGRAMA DE FIDELIDADE!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php //var_dump($caixas) 
    ?>
    <!-- Main content -->
    <section class="content">
        <!-- Card Body - Formulario -->
        <div class="card card-warning">
            <div class="card-body">
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-6">
                            <h4>
                                <i class="fas fa-globe"></i> <?= dadosEmpresa()->emp_fantasia; ?>
                            </h4>
                        </div>
                        <div class="col-3">
                            <h4>
                                <small class="float-right"><?= 'ORÇAMENTO Nº ' . $orcamento->cod_orcamento . '/' . date("Y", strtotime($orcamento->orc_data)); ?></small>
                            </h4>
                        </div>
                        <div class="col-3">
                            <h4>
                                <small class="float-right"><?= 'VENDA Nº ' . $venda->cod_venda . '/' . date("Y", strtotime($venda->data_compra)); ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                CLIENTE: <strong><?php echo $venda->pessoa; ?></strong><br>
                                DATA VENDA:
                                <strong><?php echo date("d/m/Y H:i", strtotime($venda->data_compra)); ?></strong><br>
                            </address>
                        </div>
                        <!-- /.col -->
                        <?php if ($venda->situacao != 2) { ?>

                            <div class="col-sm-6 invoice-col">
                                <address>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?php if (!empty($creditofinanceiro) &&  $venda->ven_saldo <> 0) : ?>
                                                <address>
                                                    <button class="btn btn-warning" data-toggle="modal" data-target="#telaCredito"><i class="far fa-credit-card"></i> USAR
                                                        CREDITO</button>
                                                </address>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-sm-4">

                                        </div>
                                        <div class="col-sm-4">

                                            <?php if ($venda->ven_saldo <= 0) { ?>
                                                <?= form_open(base_url('/api/venda/finaliza/venda'), ['method' => 'post', 'id' => 'formFinalizaVenda']) ?>
                                                <div class="col-md-12">
                                                    <select name="cod_caixa" id="cod_caixa" class="form-control select2bs4" style="width: 100%;">
                                                        <?php foreach ($caixas as $row) : ?>
                                                            <option value="<?= $row->id_caixa ?>">CAIXA Nº <?= $row->id_caixa ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            <?php } else { ?>
                                                <?= form_open(base_url('/api/venda/retorna/orcamento'), ['method' => 'post', 'id' => 'formRetornaOrcamento']) ?>
                                            <?php } ?>

                                            <?php if (!empty($fidelidade) & $venda->situacao != 2) : ?>
                                                <select name="cod_fidelidade" class="form-control select2bs4" style="width: 100%;" required="">
                                                    <?php foreach ($fidelidade as $row) : ?>
                                                        <option value="<?php echo $row->id_fidelidade ?>">
                                                            <?php echo $row->fid_descricao ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 invoice-col">
                                <div class="row">
                                    <div class="col-sm-12">

                                        <address>

                                            <input name="cod_venda" id="cod_venda" value="<?php echo $venda->cod_venda; ?>" hidden="hidden">
                                            <input name="cod_orcamento" id="cod_orcamento" value="<?php echo $venda->cod_orcamento; ?>" hidden="hidden">
                                            <input name="serial" id="serial" value="<?php echo $venda->serial; ?>" hidden="hidden">

                                            <?php if ($venda->ven_saldo <= 0) { ?>

                                                <button type="submit" class="form-control btn btn-warning" onclick="salvarFinalizaVenda()" id="submitFinalizaVenda"> <i class="fa fa-check fa-sm"> FINALIZAR</i> </button>
                                            <?php } else { ?>
                                                <button type="submit" class="form-control btn btn-primary" onclick="salvarRetornaOrcamento()" id="submitRetornaOrcamento"> <i class="fa fa-undo-alt fa-sm"> ALTERAR VENDA</i> </button>
                                            <?php } ?>

                                        </address>

                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        <?php } ?>
                    </div>

                    <?php if ($venda->situacao != 2) { ?>
                        <?= form_open(base_url('/api/venda/atualiza/pagamento/venda'), ['method' => 'post', 'id' => 'formPaymentVenda']) ?>
                        <div class="col-md-12">
                            <div class="form-group row" <?= ($venda->ven_saldo <= 0) ? 'hidden="hidden"' : ''; ?>>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <div class="icheck-success d-inline">
                                                <label for="radioForma"> FORMA </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="pag_forma" class="pag_forma" id="radioDinheiro" value="1">
                                                <label for="radioDinheiro"> DINHEIRO </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="pag_forma" class="pag_forma" id="radioTransferencia" value="2">
                                                <label for="radioTransferencia"> TRANSFERENCIA </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="pag_forma" class="pag_forma" id="radioDebito" value="3">
                                                <label for="radioDebito"> CARTÃO DEBITO</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="pag_forma" class="pag_forma" id="radioCredito" value="4">
                                                <label for="radioCredito"> CARTÃO CREDITO</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="icheck-success d-inline">
                                                <input type="radio" name="pag_forma" class="pag_forma" id="radioBoleto" value="5">
                                                <label for="radioBoleto"> BOLETO </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select name="serial_caixa" id="serial_caixa" class="form-control select2bs4" style="width: 100%;">
                                        <?php foreach ($caixas as $row) : ?>
                                            <option value="<?= $row->serial ?>">CAIXA Nº <?= $row->id_caixa ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 invoice-info" <?= ($venda->ven_saldo <= 0) ? 'hidden="hidden"' : ''; ?>>
                            <input name="cod_orcamento" value="<?php echo $venda->cod_orcamento; ?>" hidden="hidden">
                            <input name="cod_venda" value="<?php echo $venda->cod_venda; ?>" hidden="hidden">
                            <input name="cod_cliente" value="<?php echo $venda->cod_pessoa; ?>" hidden="hidden">
                            <input name="serial" value="<?php echo $venda->serial; ?>" hidden="hidden">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="formaValor">VALOR</label>
                                    <input name="pag_valor" id="pag_valor" value="<?php echo number_format($venda->ven_saldo, 2, ',', '.')  ?>" class="valorbr form-control" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="formaConta">CONTA</label>
                                    <select name="pag_conta" id="pag_conta" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label for="formaBandeira">BANDEIRA</label>
                                    <select name="pag_bandeira" id="pag_bandeira" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <label for="formaParcela">PARCELA </label>
                                    <select name="pag_parcela" id="pag_parcela" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label for="formaDocumento">DOCUMENTO</label>
                                    <input type="text" name="pag_documento" id="pag_documento" class="form-control">
                                </div>
                                <!-- FIM PAG BOLETO -->
                                <div class="col-sm-2" style="text-align: center;">
                                    <label for="formaPagamento"> PAGAMENTO </label>
                                    <button type="submit" id="ReceberSubmit" class="form-control btn btn-success" disabled="disabled" onclick="salvarPaymentVenda()">
                                        <i class="fas fa-hand-holding-usd"> ADICIONAR </i> </button>
                                </div>
                            </div>
                            <div class="form-group row" id="div_troco" hidden>
                                <div class="col-sm-3">
                                    <label>PAGAMENTO</label>
                                    <input name="dinheiro_valor" id="dinheiro_valor" class="valorbr form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>TROCO</label>
                                    <input name="dinheiro_troco" id="dinheiro_troco" class="valorbr form-control" disabled>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    <?php } ?>

                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table id="tablePagamentosVendaAReceber" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>FORMA DE PAGAMENTO</th>
                                        <th>REFERENCIA</th>
                                        <th>PARCELA</th>
                                        <th>VALOR</th>
                                        <th>VENCIMENTO</th>
                                        <?php if ($venda->situacao != 2) { ?>
                                            <th>ACÕES</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rec_c)) : ?>
                                        <?php foreach ($rec_c as $detalhe) : ?>
                                            <tr>
                                                <td><?= convertFormarPagamento($detalhe->mov_formapagamento) ?> </td>
                                                <td><?php echo $detalhe->mov_descricao ?></td>
                                                <?php if ($detalhe->mov_formapagamento == 4) { ?>
                                                    <td><?php echo $detalhe->mov_parcela . '/' . $detalhe->mov_parcela_total ?></td>
                                                <?php } else { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <td><?php echo number_format($detalhe->mov_valor, 2, ',', '.')  ?></td>
                                                <?php if ($detalhe->mov_formapagamento == 3 or $detalhe->mov_formapagamento == 4) { ?>
                                                    <td><?php echo date("d/m/Y", strtotime($detalhe->concilia_data)) ?></td>
                                                <?php } else { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <?php if ($venda->situacao != 2) { ?>
                                                    <td width="200">
                                                        <button class="btn btn-sm btn-danger" onclick="DeletarPagamento('movimento',<?php echo $detalhe->codigo ?>);"> <samp class="fas fa-trash-alt"></samp> Excluir</button>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($rec_o)) : ?>
                                        <?php foreach ($rec_o as $detalhe) : ?>
                                            <tr>
                                                <td><?php echo convertFormarPagamento($detalhe->forma_id) ?></td>
                                                <td><?php echo $detalhe->rec_referencia ?></td>
                                                <td><?php echo $detalhe->rec_parcela . '/' . $detalhe->rec_parcela_total ?></td>
                                                <td><?php echo number_format($detalhe->rec_valor, 2, ',', '.')  ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($detalhe->rec_vencimento)) ?></td>
                                                <?php if ($venda->situacao != 2) { ?>
                                                    <td width="200">
                                                        <button class="btn btn-sm btn-danger" onclick="DeletarPagamento('areceber',<?php echo $detalhe->id_receber ?>);"> <samp class="fas fa-trash-alt"></samp> Excluir</button>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-5">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr>
                                        <th style="width:50%">TOTAL</th>
                                        <td>R$ <?= number_format($venda->valor_bruto, 2, ',', '.')  ?> </td>
                                    </tr>
                                    <tr>
                                        <th><?= ($venda->valor_desconto >= 0) ? 'DESCONTO' : 'ACRÉSCIMO'; ?></th>
                                        <td>R$ <?= number_format(($venda->valor_desconto * -1), 2, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL A PAGAR</th>
                                        <td>R$ <?= number_format($venda->valor_total, 2, ',', '.')  ?> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-2">
                        </div>
                        <!-- /.col -->
                        <div class="col-5">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr>
                                        <th>TOTAL RECEBIDO</th>
                                        <td>R$
                                            <?php echo number_format(($venda->ven_pagamento + $venda->ven_boleto), 2, ',', '.')  ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>VALOR RESTANTE</th>
                                        <td>R$ <?php echo number_format($venda->ven_saldo, 2, ',', '.')  ?> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->

                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- Card Body - Tabela -->
    </section>
    <!-- /.content -->

</section>
<!-- /.content -->

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once('componentes/orcamento_selling_modal.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>