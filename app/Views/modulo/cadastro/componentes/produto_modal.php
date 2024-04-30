<div class="modal fade" id="modalProduto">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitleProduto"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/cadastro/salvar/produto'), ['method' => 'post', 'id' => 'formProduto']) ?>
            <div class="card-body">

                <div class="hidden">
                    <input type="hidden" name="cod_produto" id="cod_produto" />
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_descricao" id="cad_descricao" type="text" class="form-control" placeholder="" required>
                    </div>
        
                    <div class="form-group col-6">
                        <label for="">CATEGORIA</label>
                        <select name="pro_categoria" id="pro_categoria" class="form-control select2bs4" style="width: 100%;" required="">
                            <option value="">SELECIONE UMA CATEGORIA</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="">SUBCATEGORIA</label>
                        <select name="pro_subcategoria" id="pro_subcategoria" class="form-control select2bs4" style="width: 100%;" disabled>
                            <option value="">SELECIONE UM CATEGORIA PRIMEIRO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4  ">
                        <label for="">CODIGO DE BARRA DO PRODUTO</label>
                        <input name="cad_codbarras" id="cad_codbarras" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                        <div class="col-sm-3">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="status" id="produtoAtivo" value="1" checked>
                                <label for="produtoAtivo"> HABILITADO </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="status" id="produtoInativo" value="2">
                                <label for="produtoInativo"> DESABILITADO </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="SalvaProduto" onclick="SalvaProdutos()">SALVAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /. fim modal-fade -->