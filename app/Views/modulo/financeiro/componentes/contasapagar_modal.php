<div class="modal fade" id="modalPagar" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-orange">
        <h4 class="modal-title"><span id="modalTitlePagar"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(base_url('/api/financeiro/salvar/contapagar'), ['method' => 'post', 'id' => 'formContaPagar']) ?>

      <div class="card-body">
        <div class="hidden">
          <input name="cod_pagar" id="cod_pagar" hidden>
          <input name="tipoconta" value="2" hidden>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="">CREDOR / FORNECERDOR</label>
            <select name="cod_pessoa" id="cod_pessoa" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">SELECIONE O CREDOR</option>
            </select>
          </div>
          <div class="form-group col-6">
            <label for="">TIPO DA DESPESA</label>
            <select name="cod_subgrupo" id="cod_subgrupo" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">SELECIONE O TIPO DA DESPESA</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-2">
            <label for="">VALOR TOTAL</label>
            <input name="cad_valor" id="cad_valor" type="text" minlength="3" class="valorbr form-control" placeholder="0,00" required>
          </div>
          <div class="form-group col-2">
            <label for="">REFERENCIA</label>
            <input name="cad_referencia" id="cad_referencia" type="text" class="form-control" placeholder="" required>
          </div>
          <div class="form-group col-2">
            <label for="">PARCELA</label>
            <input name="cad_parcela" id="cad_parcela" type="number" class="form-control" value="1" required>
          </div>
          <div class="form-group col-2" id="container-parcela" hidden>
            <label for="">ULTIMA PARCELA</label>
            <input name="cad_parcela_total" id="cad_parcela_total" type="number" class="form-control">
          </div>
          <div class="form-group col-2">
            <label for="">VENCIMENTO 1ª PARC</label>
            <input name="cad_vencimento" id="cad_vencimento" type="date" class="form-control" placeholder="Vencimento da 1ª Parcela" required>
          </div>
          <div class="form-group col-4" id="container-diasparc">
            <label for="">DIAS ENTRE PARCELAS</label>
            <input name="cad_diasparc" type="number" maxlength="2" class="form-control" placeholder="Não preencher se o dia for sempre o mesmo">
          </div>
          <div class="form-group col-6">
            <label for="">OBSERVAÇÃO</label>
            <input name="cad_observacao" id="cad_observacao" type="text" class="form-control" placeholder="">
          </div>
        </div>
        <label style="text-shadow: 0px 0px #ff0000;">O VALOR TOTAL SERA PARCELADO PELA QUANTIDADE DE PARCELAS INFORMADO</label>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"> CANCELAR</button>
        <button type="submit" class="btn btn-primary " id="submitContaPagar" onclick="salvarContaPagar()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalPagamentoPagar" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-orange">
        <h4 class="modal-title"><span id="modalTitlePagamentoPagar"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?= form_open(base_url('/api/financeiro/salvar/contapagar'), ['method' => 'post', 'id' => 'formContaPagar']) ?>
      <div class="card">
        <div class="card-body">
          <table class="table table-sm table-bordered text-center">
            <thead>
              <tr>
                <th>VALOR</th>
                <th>CANCELADO</th>
                <th>RECEBIDO</th>
                <th>RESTANTE</th>
                <th>PAGAMENTO</th>
              </tr>
            </thead>
            <tbody id="tablePagamentoPagar">

            </tbody>
          </table>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="hidden">
            <input name="cod_pagar" id="cod_pagar" hidden>
          </div>
          <div class="row">

          </div>

        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary " id="submitContaPagar" onclick="salvarContaPagar()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>