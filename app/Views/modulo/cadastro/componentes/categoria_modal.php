<div class="modal fade" id="modalCategoria" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title"><span id="modalTitleCategoria"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body">
                <?= form_open(base_url('/api/cadastro/salvar/categoria'), ['method' => 'post', 'id' => 'formCategoria']) ?>

                <div class="hidden">
                    <input type="hidden" name="cod_categoria" id="cod_categoria" />
                    <input type="hidden" name="cod_tipo" id="cod_tipo" />
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Descrição</label>
                        <input name="cad_categoria" id="cad_categoria" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-10">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Situação</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="categoriaAtivo" value="1" checked>
                                    <label for="categoriaAtivo"> Habilitado </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="categoriaInativo" value="2">
                                    <label for="categoriaInativo"> Desabilitado </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarCategoria" onclick="salvarCategoria()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>