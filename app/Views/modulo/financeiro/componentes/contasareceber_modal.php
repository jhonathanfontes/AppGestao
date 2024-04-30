<div class="modal fade" id="modalReceber" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-orange">
        <h4 class="modal-title"><span id="modalTitleReceber"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?= form_open(base_url('/api/financeiro/salvar/contareceber'), ['method' => 'post', 'id' => 'formContaReceber']) ?>
      <div class="card-body">
        <div class="hidden">
          <input name="cod_receber" id="cod_receber" hidden>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="">CLIENTE</label>
            <select name="cod_pessoa" id="cod_pessoa" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">SELECIONE O CLIENTE</option>
            </select>
          </div>
          <div class="form-group col-6">
            <label for="">TIPO DA RECEITA</label>
            <select name="cod_subgrupo" id="cod_subgrupo" class="form-control select2bs4" style="width: 100%;" required>
              <option value="">SELECIONE O TIPO DE RECEITA</option>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary " id="submitContaReceber" onclick="salvarContaReceber()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalPagamentoReceber" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-orange">
        <h4 class="modal-title"><span id="modalTitlePagamentoReceber"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?= form_open(base_url('/api/financeiro/salvar/contareceber'), ['method' => 'post', 'id' => 'formPagamentoReceber']) ?>
      <div class="card-body">
        <div class="form-group row">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="text-center">
                <th>VALOR</th>
                <th>CANCELADO</th>
                <th>RECEBIDO</th>
                <th>RESTANTE</th>
                <th>PAGAMENTO</th>
              </tr>
            </thead>
            <tbody class="text-center" id="tablePagamentoReceber">

            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="form-group" hidden>
            <?php if (isset($caixa->codigo)) : ?>
              <input type="text" name="cod_caixa" value="<?= $caixa->codigo ?>">
            <?php endif ?>

          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <div class="icheck-success d-inline">
              <input type="radio" name="pag_forma" class="pag_forma" id="radioDinheiro" value="1">
              <label for="radioDinheiro"> DINHEIRO </label>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="icheck-success d-inline">
              <input type="radio" name="pag_forma" class="pag_forma" id="radioTransferencia" value="2">
              <label for="radioTransferencia"> TRANSFERENCIA </label>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="icheck-success d-inline">
              <input type="radio" name="pag_forma" class="pag_forma" id="radioDebito" value="3">
              <label for="radioDebito"> CARTÃO DEBITO</label>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="icheck-success d-inline">
              <input type="radio" name="pag_forma" class="pag_forma" id="radioCredito" value="4">
              <label for="radioCredito"> CARTÃO CREDITO</label>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="icheck-success d-inline">
              <input type="radio" name="pag_forma" class="pag_forma" id="radioBoleto" value="5">
              <label for="radioBoleto"> BOLETO </label>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="icheck-success d-inline">
              <select name="serial_caixa" id="serial_caixa" class="form-control select2bs4" style="width: 100%;">
                <?php if (isset($caixa->codigo)) : ?>
                  <?php foreach ($caixas as $row) : ?>
                    <option value="<?= $row->serial ?>">CAIXA Nº <?= $row->id_caixa ?></option>
                  <?php endforeach; ?>
                <?php endif ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-sm-12 invoice-info">
          <div class="form-group row text-center">
            <div class="col-sm-2">
              <label for="formaValor">VALOR</label>
              <input name="pag_valor" id="pag_valor" value="" class="valorbr form-control text-left" required>
            </div>
            <div class="col-sm-3">
              <label for="formaConta">CONTA</label>
              <select name="pag_conta" id="pag_conta" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
              </select>
            </div>
            <div class="col-sm-2">
              <label for="formaBandeira">BANDEIRA</label>
              <select name="pag_bandeira" id="pag_bandeira" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
              </select>
            </div>
            <div class="col-sm-1">
              <label for="formaParcela">PARCELA </label>
              <select name="pag_parcela" id="pag_parcela" class="form-control select2bs4" style="width: 100%;" disabled="disabled" required>
              </select>
            </div>
            <div class="col-sm-2">
              <label for="formaDocumento">DOCUMENTO</label>
              <input type="text" name="pag_documento" id="pag_documento" class="form-control">
            </div>
            <div class="col-sm-2">
              <label for="formaDocumento"> RECEBER </label>
              <button type="submit" id="ReceberSubmit" class="btn btn-success" disabled="disabled" onclick="salvarPaymentVenda()">
                <i class="fas fa-hand-holding-usd"> ADICIONAR </i> </button>
            </div>
          </div>


          <div class="form-group row" id="div_troco" hidden>
            <div class="col-sm-3">
              <label>PAGAMENTO</label>
              <input name="dinheiro_valor" id="dinheiro_valor" class="valorbr form-control">
            </div>
            <div class="col-sm-3">
              <label>TROCO</label>
              <input name="dinheiro_troco" id="dinheiro_troco" class="valorbr form-control" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary " id="submitPagamentoReceber" onclick="salvarPagamentoReceber()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>