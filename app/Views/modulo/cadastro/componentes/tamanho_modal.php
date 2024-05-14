<div class="modal fade" id="modalTamanho">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title"><span id="modalTitleTamanho"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <?= form_open(base_url('/api/cadastro/salvar/tamanho'), ['id' => 'formTamanho']) ?>
                <div class="hidden">
                    <input type="hidden" name="cod_tamanho" id="cod_tamanho" />
                    <input type="hidden" name="cod_tipo" id="tam_tipo" />
                </div>
                <div class="row">
                    <div class="form-group col-5">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_tamanho" id="cad_tamanho" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-5">
                        <label for="">ABREVIAÇÃO</label>
                        <input name="cad_abreviacao" id="cad_abreviacao" type="text" class="form-control" placeholder="" maxlength="5">
                    </div>
                    <div class="form-group col-2">
                        <label for="">EMBALAGEM</label>
                        <input name="cad_embalagem" id="cad_embalagem" type="text" class="form-control" placeholder="" value="1" >
                    </div>
                    <div class="col-md-10">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="tamanhoAtivo" value="1" checked>
                                    <label for="tamanhoAtivo"> HABILITADO </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="tamanhoInativo" value="2">
                                    <label for="tamanhoInativo"> DESABILITADO </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="salvarTamanho" onclick="salvarTamanhos()">Salvar</button>
                </div>
                <?= form_close(); ?>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /. fim modal-fade -->