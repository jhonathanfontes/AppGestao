<div class="modal fade" id="modalSubgrupo">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title"><span id="modalTitleSubgrupo"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <<?= form_open(base_url('/api/financeiro/salvar/subgrupo'), ['method' => 'post', 'id' => 'formSubgrupo']) ?> <div class="card-body">
                <div class="row">
                    <div class="hidden">
                        <input name="cod_subgrupo" id="cod_subgrupo" hidden>
                    </div>
                    <div class="form-group col-5">
                        <label for="">GRUPO</label>
                        <select name="cod_grupo" id="cod_grupo" class="form-control select2bs4" style="width: 100%;">

                        </select>
                    </div>
                    <div class="form-group col-7">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_subgrupo" id="cad_subgrupo" type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                        <div class="col-sm-3">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="status" id="subgrupoAtivo" value="1" checked>
                                <label for="subgrupoAtivo"> HABILITADO</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="status" id="subgrupoInativo" value="2">
                                <label for="subgrupoInativo"> DESABILITADO</label>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
            <button type="submit" class="btn btn-primary" id="SalvarSubGrupo" onclick="SalvaSubGrupos()"><i class="fa fa-save"></i> SALVAR</button>
        </div>
        <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>