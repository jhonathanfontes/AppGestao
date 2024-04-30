<div class="modal fade" id="modalFabricante">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitleFabricante"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/cadastro/salvar/fabricante'), ['method' => 'post', 'id' => 'formFabricante']) ?>
            <div class="card-body">
                <div class="hidden">
                    <input type="hidden" name="cod_fabricante" id="cod_fabricante" />
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Descrição</label>
                        <input name="cad_fabricante" id="cad_fabricante" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-10">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Situação</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="fabricanteAtivo" value="1" checked>
                                    <label for="fabricanteAtivo"> Habilitado </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="fabricanteInativo" value="2">
                                    <label for="fabricanteInativo"> Desabilitado </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarFabricante" onclick="salvarFabricante()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /. fim modal-fade -->