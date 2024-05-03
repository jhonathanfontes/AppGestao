<div class="modal fade" id="modalObra">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitleObra"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body">
                <?= form_open(base_url('/api/projeto/salvar/obra'), ['method' => 'post', 'id' => 'formObra']) ?>

                <div class="hidden">
                    <input type="hidden" name="cod_obra" id="cod_obra" />
                </div>
                <div class="row">
                    <div class="form-group col-7">
                        <label for="">Descrição</label>
                        <input name="cad_obra" id="cad_obra" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-5" id="container-nascimento">
                        <label for="">DATA PREVISTA</label>
                        <input name="cad_datainicio" id="cad_datainicio" type="date" class="form-control">
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarObra" onclick="salvarObra()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>