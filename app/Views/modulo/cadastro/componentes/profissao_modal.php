<div class="modal fade" id="modalProfissao">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitleProfissao"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/cadastro/salvar/profissao'), ['method' => 'post', 'id' => 'formProfissao']) ?>
            <div class="card-body">
                <div class="hidden">
                    <input type="hidden" name="cod_profissao" id="cod_profissao" />
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Descrição</label>
                        <input name="cad_profissao" id="cad_profissao" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-10">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Situação</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="profissaoAtivo" value="1" checked>
                                    <label for="profissaoAtivo"> Habilitado </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="profissaoInativo" value="2">
                                    <label for="profissaoInativo"> Desabilitado </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarProfissao" onclick="salvarProfissao()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /. fim modal-fade -->