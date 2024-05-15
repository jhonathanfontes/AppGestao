<div class="modal fade" id="modalBanco" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
        <h4 class="modal-title"><span id="modalTitleBanco"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="card-body">
        <?= form_open(base_url('/api/configuracao/salvar/banco'), ['method' => 'post', 'id' => 'formBanco']) ?>

        <div class="hidden">
          <input name="cod_banco" id="cod_banco" hidden>
        </div>

        <div class="row">
          <div class="form-group col-6">
            <label for="">CODIGO</label>
            <input name="cad_codigo" id="cad_codigo" type="text" class="form-control" placeholder="" required>
          </div>
          <div class="form-group col-6">
            <label for="">DESCRIÇÃO</label>
            <input name="cad_banco" id="cad_banco" type="text" class="form-control" placeholder="" required>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary " id="SalvarBanco" onclick="salvarBanco()">Salvar</button>
        </div>
        <?= form_close(); ?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>