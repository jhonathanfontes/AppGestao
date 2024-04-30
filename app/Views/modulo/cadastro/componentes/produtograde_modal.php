<div class="modal fade" id="modalProdutoGrade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modal_title"></span> GRADE DO PRODUTO: <?= isset($produto->cad_produto) ? $produto->cad_produto : 'CADASTRO NÃO LOCALIZADO!';  ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(base_url('/api/cadastro/salvar/grade/produto'), ['method' => 'post', 'id' => 'formProdutoGrade'], ['cod_produto' => $produto->cod_produto]) ?>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-3" style="text-align: center;">
                        <label for="">Grande</label>
                        <select name="cod_gradetamanho" id="cod_gradetamanho" class="form-control select2bs4" required>
                            <option value="">TAMANHO DA EMBALAGEM</option>
                        </select>
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">VALOR CUSTO</label>
                        <input name="cad_custo" id="cad_custo" class="form-control valorbr" placeholder="0,00">
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">VALOR AVISTA</label>
                        <input name="cad_avista" id="cad_avista" class="form-control valorbr" placeholder="0,00">
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">VALOR APRAZO</label>
                        <input name="cad_aprazo" id="cad_aprazo" class="form-control valorbr" placeholder="0,00">
                    </div>                    
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">Codigo de Barra</label>
                        <input name="cad_codbarras" id="cad_codbarras" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-1" style="text-align: center;">
                        <label for="">&nbsp</label>
                        <button type="submit" id="incluirGradeProduto" class="btn btn-outline-info btn-block btn-flat" onclick="salvarGradeProdutoTamanho()"></i> INCLUIR</button>
                        <!-- <input type="button" name="cad_venda" id="cad_venda" class="form-control valorbr" value="Incluir"> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>