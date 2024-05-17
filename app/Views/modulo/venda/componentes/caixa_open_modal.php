<div class="modal fade" id="modalCaixaFechar" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
           <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title">FECHAMENTO DO CAIXA <?= isset($caixa) ? 'Nº ' . $caixa->id : ''; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/caixa/processar/fechamento'), ['method' => 'post', 'id' => 'formFechamentoCaixa']) ?>
            <input name="caixa_codigo" value="<?= isset($caixa) ? $caixa->id : ''; ?>" hidden="hidden">
            <input name="caixa_serial" value="<?= isset($caixa) ? $caixa->serial : ''; ?>" hidden="hidden">
            <div class="modal-body">
                <div class="form-group col-12">
                    <label for="">MOEDAS</label>
                    <hr>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="">R$ 0,01</label>
                            <input name="moeda_01" id="moeda_01" type="number" class="moeda form-control" placeholder="R$ 0,01" onblur="">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,05</label>
                            <input name="moeda_05" id="moeda_05" type="number" class="moeda form-control" placeholder="R$ 0,05">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,10</label>
                            <input name="moeda_10" id="moeda_10" type="number" class="moeda form-control" placeholder="R$ 0,10">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,25</label>
                            <input name="moeda_25" id="moeda_25" type="number" class="moeda form-control" placeholder="R$ 0,25">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,50</label>
                            <input name="moeda_50" id="moeda_50" type="number" class="moeda form-control" placeholder="R$ 0,50">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 1,00</label>
                            <input name="moeda_1" id="moeda_1" type="number" class="moeda form-control" placeholder="R$ 1,00">
                        </div>
                    </div>
                    <label for="">CEDULAS</label>
                    <hr>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="">R$ 2,00</label>
                            <input name="cedula_2" id="cedula_2" class="cedula form-control" placeholder="R$ 2,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 5,00</label>
                            <input name="cedula_5" id="cedula_5" class="cedula form-control" placeholder="R$ 5,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 10,00</label>
                            <input name="cedula_10" id="cedula_10" class="cedula form-control" placeholder="R$ 10,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 20,00</label>
                            <input name="cedula_20" id="cedula_20" class="cedula form-control" placeholder="R$ 20,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 50,00</label>
                            <input name="cedula_50" id="cedula_50" class="cedula form-control" placeholder="R$ 50,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 100,00</label>
                            <input name="cedula_100" id="cedula_100" class="cedula form-control" placeholder="R$ 100,00">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">TOTAL MOEDAS</label>
                            <input name="total_moeda" id="total_moeda1" class="form-control" placeholder="R$ 0,00" hidden>
                            <input name="total_moeda" id="total_moeda2" class="form-control" placeholder="R$ 0,00" disabled>
                        </div>
                        <div class="form-group col-3">
                            <label for="">TOTAL CEDULAS</label>
                            <input name="total_cedula" id="total_cedula1" class="form-control" placeholder="R$ 0,00" hidden>
                            <input name="total_cedula" id="total_cedula2" class="form-control" placeholder="R$ 0,00" disabled>
                        </div>
                        <div class="form-group col-3">
                            <label for="">TOTAL</label>
                            <input name="fecha_valor" id="abrir_valor1" class="form-control" placeholder="R$ 0,00" hidden>
                            <input name="fecha_valor" id="abrir_valor2" class="form-control" placeholder="R$ 0,00" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitFechamento" class="btn btn-success" onclick="salvarFechamentoCaixa()">FECHAR CAIXA</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- FIM FECHAR CAIXA -->

<div class="modal fade" id="modalCaixaSuplmento" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">SUPLEMENTAR O CAIXA <?= isset($caixa) ? 'Nº ' . $caixa->id : ''; ?></h4>
            </div>
            <div class="modal-body">
                <?= form_open(base_url('/api/caixa/incluir/suplemento'), ['method' => 'post', 'id' => 'formIncluirSuplemento']) ?>
                <div class="form-group col-12">
                    <input name="caixa_codigo" id="caixa_codigo" value="<?= isset($caixa) ? $caixa->id : ''; ?>" hidden="hidden">
                    <input name="caixa_serial" value="<?= isset($caixa) ? $caixa->serial : ''; ?>" hidden="hidden">
                    <hr>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">FORMA</label>
                            <select name="sup_forma" class="form-control" required="required">
                                <?php if (!empty($formaPagmento)) : ?>
                                    <?php foreach ($formaPagmento as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->for_descricao ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label for="">VALOR</label>
                            <input name="sup_valor" class="valorbr form-control" placeholder="R$ 0,00" required="required">
                        </div>
                        <div class="form-group col-4">
                            <label for="">DESCRIÇÃO</label>
                            <input name="sup_documento" type="text" class="form-control" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    <button type="submit" id="submitSuplemento" class="btn btn-success" onclick="salvarSuplemento()">SUPLEMENTAR</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- FIM SUPLEMENTAÇÃO -->

<div class="modal fade" id="modalCaixaSangria" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">SANGRIA DO CAIXA <?= isset($caixa) ? 'Nº ' . $caixa->id : ''; ?></h4>
            </div>
            <div class="modal-body">
                <?= form_open(base_url('/api/caixa/incluir/sangria'), ['method' => 'post', 'id' => 'formIncluirSangria']) ?>
                <form action="<?php echo base_url(); ?>caixa/incluir/" method="post">
                    <div class="form-group col-12">
                        <input name="caixa_codigo" id="caixa_codigo" value="<?= isset($caixa) ? $caixa->id : ''; ?>" hidden="hidden">
                        <input name="caixa_serial" value="<?= isset($caixa) ? $caixa->serial : ''; ?>" hidden="hidden">
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="forma_sagria" id="radioRetirada" value="1" checked="checked">
                                    <label for="radioRetirada"> RETIRADA </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="forma_sagria" id="radioDeposito" value="2">
                                    <label for="radioDeposito"> DEPOSITO </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <br>
                        </div>
                        <div class="row">
                            <div class="form-group col-12" id="div_conta" hidden="hidden">
                                <label>CONTA BANCARIA</label>
                                <select name="cod_conta" id="cod_conta" class="form-control select2bs4" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="">FORMA</label>
                                <select name="san_forma" class="form-control" required="required">
                                    <?php if (!empty($formaPagmento)) : ?>
                                        <?php foreach ($formaPagmento as $row) : ?>
                                            <option value="<?= $row->id ?>"><?= $row->for_descricao ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="">VALOR</label>
                                <input name="san_valor" class="valorbr form-control" placeholder="R$ 0,01" required="required">
                            </div>
                            <div class="form-group col-4">
                                <label for="">DESCRIÇÃO</label>
                                <input name="san_documento" type="text" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CENCELAR</button>
                        <button type="submit" id="submitSangria" class="btn btn-success" onclick="salvarSangria()">SANGRIA</button>
                    </div>
                    <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- FIM SANGRIA -->

<div class="modal fade" id="cancelarMovimento" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">CANCELAMENTO</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>caixa/cancelarMovimento/" method="post">
                    <div class="form-group col-12">
                        <input name="caixa_id" value="<?= isset($caixa) ? $caixa->codigo : ''; ?>" hidden="hidden">
                        <input name="caixa_tipo" value="2" hidden="hidden">
                        <hr>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">Descrição</label>
                                <input type="text" name="caixa_id" value="<?= isset($caixa) ? $caixa->codigo : ''; ?>" hidden="hidden" required="required">
                                <input name="codigo" id="codigo" type="text" class="form-control" hidden="hidden" required="required">
                                <input name="motivo_can" type="text" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIM CANCELAMENTO -->

<div class="modal fade" id="modalReceberVenda" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
           <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <address>
                    <h4 class="modal-title">
                        <i class="fas fa-globe"></i> <span id="modalTitleReceberVenda"></span>
                    </h4>
                </address>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="col-12">
                        <form role="form" action="<?php echo base_url(); ?>payment/venda" method="post">

                            <div class="form-group" hidden>
                                <input name="cod_orcamento" hidden="hidden">
                                <input name="cod_cliente" hidden="hidden">
                                <input name="serial" hidden="hidden">
                            </div>

                            <div class="row col-12">
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

                            <div class="row col-12 mt-2">
                                <div class="form-group col-3">
                                    <label>VALOR DO PAGAMENTO</label>
                                    <input name="pag_valor" type="text" id="pag_valor" class="valorbr form-control" placeholder="INFORME O VALOR DO PAGAMENTO" required>
                                </div>
                                <div class="form-group col-3">
                                    <label>PARCELA</label>
                                    <input name="pag_parcela" type="number" id="pag_parcela" value="1" class="form-control" disabled>
                                </div>
                                <div class="form-group col-4">
                                    <label>SELECIONE A CONTA</label>
                                    <select name="pag_conta" id="pag_conta" class="form-control" disabled>
                                        <option value="">SELECIONE A FORMA DE PAGAMENTO</option>
                                    </select>
                                </div>
                                <div class="form-group col-1">
                                    <label>RECEBER</label>
                                    <button type="submit" id="submitIncluirPagamentoVenda" class="btn btn-success btn-block" disabled onclick="receberPagamentoVenda()"><i class="far fa-save"></i> </button>
                                </div>
                            </div>

                            <div class="form-group row" id="div_troco" hidden>
                                <div class="col-sm-3">
                                    <label>TROCO</label>
                                    <input name="dinheiro_troco" id="dinheiro_troco" class="valorbr form-control" disabled>
                                </div>
                            </div>

                            <!-- /.card-body -->
                        </form>
                    </div>
                    <div class="row col-12 mt-2">
                        <table id="tableRecebimentoVenda" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>FORMA DE PAGAMENTO</th>
                                    <th>REFERENCIA</th>
                                    <th>PARCELA</th>
                                    <th>VALOR</th>
                                    <th>VENCIMENTO</th>
                                    <th>ACÕES</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 12px;">

                            </tbody>
                        </table>
                    </div>
                    <div class="row col-12 mt-2">
                        <div class="form-group col-4">
                            <label>VALOR DA VENDA</label>
                            <input type="number" id="val_total_venda" class="form-control" disabled>
                        </div>
                        <div class="form-group col-4">
                            <label>VALOR RECEBIDO</label>
                            <input type="number" id="val_total_recebido" class="form-control" disabled>
                        </div>
                        <div class="form-group col-4">
                            <label>VALOR A RECEBER</label>
                            <input type="number" id="val_total_restante" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" id="ReceberSubmit" class="btn btn-success" disabled><i class="far fa-credit-card"></i> FINALIZAR</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<!-- /.FIM MODAL PAGAMENTOS -->