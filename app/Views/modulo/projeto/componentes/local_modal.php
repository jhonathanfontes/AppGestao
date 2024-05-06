<div class="modal fade" id="modalLocal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitleLocal"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <?= form_open(base_url('/api/projeto/salvar/local'), ['method' => 'post', 'id' => 'formLocal']) ?>
                <div class="hidden">
                    <input type="hidden" name="cod_local" id="cod_local" />
                    <input type="hidden" name="cod_obra" id="cod_obra" />
                </div>
                <div class="row">
                    <div class="form-group col-7">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_local" id="cad_local" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-5" id="container-nascimento">
                        <label for="">DATA PREVISTA</label>
                        <input name="cad_datainicio" id="cad_datainicio" type="date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarLocal"
                        onclick="salvarLocal()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>