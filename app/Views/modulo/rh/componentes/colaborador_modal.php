<div class="modal fade" id="modalColaborador" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
        <h4 class="modal-title"><span id="modalTitleColaborador"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="card-body">
        <?= form_open(base_url('/api/rh/salvar/colaborador'), ['method' => 'post', 'id' => 'formColaborador']) ?>

        <div class="hidden">
          <input name="cod_colaborador" id="cod_colaborador" hidden>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="">PESSOA</label>
            <select name="cod_pessoa" id="cod_pessoa" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">SELECIONE UMA PESSOA</option>

            </select>
          </div>
          <div class="form-group col-6">
            <label for="">USUARIO</label>
            <select name="cod_usuario" id="cod_usuario" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">SELECIONE UM USUARIO</option>

            </select>
          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">DATA ADMISSAO</label>
            <input name="cad_dt_admissao" id="cad_dt_admissao" type="date" class="form-control">
          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">DATA DESLIGAMENTO</label>
            <input name="cad_dt_desligamento" id="cad_dt_desligamento" type="date" class="form-control">
          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">SALÁRIO</label>
            <input name="cad_salario" id="cad_salario" type="text" minlength="3" class="valorbr form-control" placeholder="0,00" required>
          </div>
          <div class="col-md-12">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
              <div class="col-sm-3">
                <div class="icheck-success d-inline">
                  <input type="radio" name="status" id="vendedorAtivo" value="1" checked>
                  <label for="vendedorAtivo"> HABILITADO </label>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="icheck-danger d-inline">
                  <input type="radio" name="status" id="vendedorInativo" value="2">
                  <label for="vendedorInativo"> DESABILITADO </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary " id="SalvarVendedor" onclick="salvarVendedor()">Salvar</button>
        </div>
        <?= form_close(); ?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>