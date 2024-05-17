<div class="modal fade" id="modalGrupoAcesso" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title"><span id="modalTitleGrupoAcesso"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="card-body">
        <?= form_open(base_url('/api/configuracao/salvar/grupodeacesso'), ['method' => 'post', 'id' => 'formGrupoAcesso']) ?>

        <div class="hidden">
          <input type="hidden" name="cod_grupodeacesso" id="cod_gruposdeacesso" />
        </div>
        <div class="row">
          <div class="form-group col-12">
            <label for="">DESCRIÇÃO</label>
            <input name="cad_grupodeacesso" id="cad_grupodeacesso" type="text" class="form-control" placeholder="">
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary " id="SalvarGrupoAcesso" onclick="salvarGrupoAcesso()">Salvar</button>
        </div>
        <?= form_close(); ?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>