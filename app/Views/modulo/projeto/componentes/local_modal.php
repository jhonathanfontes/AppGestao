<div class="modal fade" id="modalLocal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title"><span id="modalTitleLocal"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <?= form_open(base_url('/api/projeto/salvar/local'), ['method' => 'post', 'id' => 'formLocal']) ?>
                <div hidden>
                    <input name="cod_local" id="id_local" />
                    <input name="cod_obra" id="cod_local_obra" />
                </div>
                <div class="row">
                    <div class="form-group col-7">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_local" id="cad_local" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-5" id="container-nascimento">
                        <label for="">DATA PREVISTA</label>
                        <input name="cad_datainicio" id="cad_datainicio" type="date" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">OBSERVAÇÕES</label>
                        <textarea name="cad_observacao" id="cad_observacao" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarLocal"
                        onclick="salvarLocal()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<!-- /.modal editarProduto -->
<div class="modal fade" id="modalProdutoLocalServico" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title"> <span id="modalTitleGradeProduto"></span></h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/projeto/orcamento/inclui/produto'), ['method' => 'post', 'id' => 'formUpdateGradeProduto']) ?>

            <div class="card-body">
                <input type="text" name="cod_detalhe" id="e_cod_detalhe" hidden="hidden">
                <input type="text" name="cod_obra" id="e_cod_obra" hidden="hidden">
                <input type="text" name="cod_local" id="e_cod_local" hidden="hidden">
                <input type="text" name="cod_produto" id="e_cod_produto" class="form-control" hidden="hidden" required>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="">QUANTIDADE</label>
                        <input name="quantidade" id="e_qnt_produto" class="form-control"
                            onblur="atualizaGradeProduto();">
                    </div>
                    <div class="form-group col-3">
                        <label for="">VALOR UNITARIO</label>
                        <input name="valor_unidade" id="e_valor_unidade" class="form-control" disabled="disabled">
                    </div>
                    <div class="form-group col-3">
                        <label for="">VALOR COM DESCONTO</label>
                        <input name="valor_desc" id="e_valor_desc" class="valorbr form-control"
                            onblur="atualizaGradeProduto();">
                    </div>
                   
                    <div class="form-group col-3">
                        <label for="">TOTAL</label>
                        <input name="valor_total" id="e_valor_total" class="form-control" disabled="disabled">
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitGradeProduto" class="btn btn-primary"
                    onclick="salvarDetalheProduto()">APLICAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-EditarProduto -->
</div>