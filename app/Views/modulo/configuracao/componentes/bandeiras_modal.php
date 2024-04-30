<div class="modal fade" id="modalBandeira">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modalTitleBandeira"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body">
                <?= form_open(base_url('/api/configuracao/salvar/bandeira'), ['method' => 'post', 'id' => 'formBandeira']) ?>

                <div class="hidden">
                    <input type="hidden" name="cod_bandeira" id="cod_bandeira" />
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Descrição</label>
                        <input name="cad_bandeira" id="cad_bandeira" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-10">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Situação</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="bandeiraAtivo" value="1" checked>
                                    <label for="bandeiraAtivo"> Habilitado </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="bandeiraInativo" value="2">
                                    <label for="bandeiraInativo"> Desabilitado </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarBandeira" onclick="salvarBandeira()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>