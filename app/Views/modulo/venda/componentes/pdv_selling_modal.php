<!-- MODAL PARA PAGAMENTOS DO PDV -->
<div class="modal fade" id="modalPagamento" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <?= form_open(base_url('/api/venda/atualiza/pagamento/venda'), ['method' => 'post', 'id' => 'formPaymentVenda']) ?>
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><?= "CLIENTE ORÇAMENTO Nº " . $orcamento->cod_orcamento . '/' . date("Y", strtotime($orcamento->orc_data)); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group" hidden>
                            <?php if (isset($caixa->codigo)) : ?>
                                <input type="text" name="cod_caixa" value="<?= $caixa->codigo ?>">
                            <?php endif ?>
                            <input name="cod_orcamento" value="<?= $venda->cod_orcamento; ?>" hidden="hidden">
                            <input name="cod_venda" value="<?= $venda->cod_venda; ?>" hidden="hidden">
                            <input name="cod_cliente" value="<?= $venda->cod_pessoa; ?>" hidden="hidden">
                            <input name="serial" value="<?= $venda->serial; ?>" hidden="hidden">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="pag_forma" class="pag_forma" id="radioDinheiro" value="1">
                                <label for="radioDinheiro"> DINHEIRO </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="pag_forma" class="pag_forma" id="radioTransferencia" value="2">
                                <input name="tipoTransferencia" id="tipoTransferencia" value="R" hidden>
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
                        <div class="col-sm-2">
                            <div class="icheck-success d-inline">
                                <select name="serial_caixa" id="serial_caixa" class="form-control select2bs4" style="width: 100%;">
                                    <?php foreach ($caixas as $row) : ?>
                                        <option value="<?= $row->serial ?>">CAIXA Nº <?= $row->id_caixa ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 invoice-info">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="formaValor">VALOR</label>
                                <input name="pag_valor" id="pag_valor" value="<?= number_format($venda->ven_saldo, 2, ',', '.')  ?>" class="valorbr form-control" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="formaConta">CONTA</label>
                                <select name="pag_conta" id="pag_conta" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="formaBandeira">BANDEIRA</label>
                                <select name="pag_bandeira" id="pag_bandeira" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <label for="formaParcela">PARCELA </label>
                                <select name="pag_parcela" id="pag_parcela" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="formaDocumento">DOCUMENTO</label>
                                <input type="text" name="pag_documento" id="pag_documento" class="form-control">
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
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" id="ReceberSubmit" class="btn btn-success" disabled="disabled" onclick="salvarPaymentVenda()">
                    <i class="fas fa-hand-holding-usd"> ADICIONAR </i> </button>
            </div>
            <?= form_close(); ?>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal Pagamento -->