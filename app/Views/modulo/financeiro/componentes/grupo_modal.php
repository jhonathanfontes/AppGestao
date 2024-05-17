<div class="modal fade" id="modalGrupo" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title"><span id="modalTitleGrupo"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/financeiro/salvar/grupo'), ['method' => 'post', 'id' => 'formGrupo']) ?>
            <div class="card-body">
                <div class="hidden">
                    <input name="cod_grupo" id="cod_grupo" hidden>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="">TIPO</label>
                        <select name="cad_tipo" id="cad_tipo" class="form-control">
                            <option value="">SELECIONE UM TIPO</option>
                            <option value="D">DESPESA</option>
                            <option value="R">RECEITA</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_grupo" id="cad_grupo" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">CLASSIFICAÇÃO</label>
                        <select name="cad_classificacao" id="cad_classificacao" class="form-control">
                            <option value="">SELECIONE UMA CLASSIFICAÇÃO</option>
                            <option value="1">OPERACIONAL</option>
                            <option value="2">CUSTO VARIÁVEL</option>
                            <option value="3">NÃO OPERACIONAL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                        <div class="col-sm-3">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="status" id="grupoAtivo" value="1" checked>
                                <label for="grupoAtivo"> HABILITADO</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="status" id="grupoInativo" value="2">
                                <label for="grupoInativo"> DESABILITADO</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="SalvarGrupo" onclick="SalvaGrupos()"><i
                        class="fa fa-save"></i> SALVAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>