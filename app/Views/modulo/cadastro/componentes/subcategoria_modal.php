<div class="modal fade" id="modalSubCategoria">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitleSubCategoria"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/cadastro/salvar/subcategoria'), ['method' => 'post', 'id' => 'formSubcategoria']) ?>

            <div class="card-body">
                <div class="hidden">
                    <input type="hidden" name="cod_subcategoria" id="cod_subcategoria" />
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="">CATEGORIA</label>
                        <select name="cod_categoria" id="sub_categoria" class="form-control select2bs4" style="width: 100%;">
                        </select>
                    </div>
                    <div class="form-group col-8">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_subcategoria" id="cad_subcategoria" type="text" class="form-control" placeholder="">
                    </div>

                    <div class="col-md-10">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="subcategoriaAtivo" value="1" checked>
                                    <label for="subcategoriaAtivo"> HABILITADO </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="subcategoriaInativo" value="2">
                                    <label for="subcategoriaInativo"> DESABILITADO </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="salvarSubcategoria" onclick="salvarSubcategorias()">Salvar</button>
                </div>
                <?= form_close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /. fim modal-fade -->