<div class="modal fade" id="modalFormaPagamento" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modalTitleFormaPagamento"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body">
                <?= form_open(base_url('/api/configuracao/salvar/formapagamento'), ['method' => 'post', 'id' => 'formFormaPagamento']) ?>

                <div class="row">
                    <div class="hidden">
                        <input name="cod_formapagamento" id="cod_formapagamento" hidden>
                    </div>

                    <div class="form-group col-4">
                        <label for="">FORMA DE PAGAMENTO</label>
                        <select name="cad_forma" id="cad_forma" class="form-control select2bs4" style="width: 100%;"
                            required>
                            <option value="1">DINHEIRO</option>
                            <option value="2">TRANSFERENCIA</option>
                            <option value="3">CARTÃO DEBITO</option>
                            <option value="4">CARTÃO CREDITO</option>
                            <option value="5">BOLETO</option>
                            <option value="99">OUTRAS</option>
                        </select>
                    </div>
                    <div class="form-group col-8">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_descricao" id="cad_descricao" type="text" class="form-control" placeholder=""
                            required>
                    </div>
                </div>
                <div class="form-group row" id="container-cartao" hidden>
                    
                    <div class="form-group col-8">
                        <label for="">CONTA</label>
                        <select name="cad_conta" id="cad_conta" class="form-control select2bs4" style="width: 100%;">
                          
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="">PARCELA</label>
                        <select name="cad_parcela" id="cad_parcela" class="form-control">
                            <option value="0">NÃO</option>
                            <option value="1">SIM</option>
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="">ANTERCIPA</label>
                        <select name="cad_antecipa" id="cad_antecipa" class="form-control">
                            <option value="0">NÃO</option>
                            <option value="1">SIM</option>
                        </select>
                    </div>
                    <div class="form-group row col-6" id="container-taxaPrazo">
                        <div class="form-group col-6">
                            <label for="">TAXA</label>
                            <input name="cad_ftaxa" id="cad_ftaxa" min="0" max="100" type="text"
                                class="form-control taxabr" placeholder="">
                        </div>
                        <div class="form-group col-6">
                            <label for="">PRAZO</label>
                            <input name="cad_fprazo" id="cad_fprazo" type="number" min="1" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="formapagamentoAtivo" value="1" checked>
                                    <label for="formapagamentoAtivo">HABILITADO</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="formapagamentoInativo" value="2">
                                    <label for="formapagamentoInativo">DESABILITADO</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarFormaPagamento"
                        onclick="salvarFormaPagamento()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>