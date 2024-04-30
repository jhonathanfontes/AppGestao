<div class="modal fade" id="modalContaBancaria">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modalTitleContaBancaria"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <?= form_open(base_url('/api/configuracao/salvar/contabancaria'), ['method' => 'post', 'id' => 'formContaBancaria']) ?>
                <div class="row">
                    <div class="hidden">
                        <input name="cod_contabancaria" id="cod_contabancaria" hidden>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">BANCO</label>
                            <select name="cad_banco" id="cad_banco" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="">SELECIONE UM BANCO</option>
                                <?php if (!empty($bancos)) : ?>
                                    <?php foreach ($bancos as $row) : ?>
                                        <option value="<?= $row->id_banco ?>"><?= $row->ban_codigo . ' - ' . $row->ban_descricao ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label for="">AGENCIA</label>
                            <input name="cad_agencia" id="cad_agencia" type="text" class="form-control" required />
                        </div>
                        <div class="form-group col-2">
                            <label for="">CONTA</label>
                            <input name="cad_conta" id="cad_conta" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-5">
                            <label for="">DESCRIÇÃO</label>
                            <input name="cad_contabancaria" id="cad_contabancaria" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-3">
                            <label for="">TIPO</label>
                            <select name="cad_tipo" id="cad_tipo" class="form-control select2bs4" style="width: 100%;">
                                <option value="C">CORRENTE</option>
                                <option value="P">POUPANÇA</option>
                            </select>
                        </div>

                        <div class="form-group col-3">
                            <label for="">EMPRESA</label>
                            <select name="cad_empresa" id="cad_empresa" class="form-control select2bs4" style="width: 100%;">
                                <option value="">SELECIONE UM EMPRESA</option>
                                <?php if (!empty($empresas)) : ?>
                                    <?php foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->id_empresa ?>"><?= $row->cad_razao ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="">PAGAMENTO</label>
                            <select name="cad_pagamento" id="cad_pagamento" class="form-control select2bs4" style="width: 100%;">
                                <option value="S">PERMITIR</option>
                                <option value="N">NÃO PERMITIR</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="">RECEBIMENTO</label>
                            <select name="cad_recebimento" id="cad_recebimento" class="form-control select2bs4" style="width: 100%;">
                                <option value="S">PERMITIR</option>
                                <option value="N">NÃO PERMITIR</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="">NATUREZA</label>
                            <select name="cad_natureza" id="cad_natureza" class="form-control select2bs4" style="width: 100%;">
                                <option value="F">Fisica</option>
                                <option value="J">Juridica</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="">TITULAR</label>
                            <input name="cad_titular" id="cad_titular" type="text" class="form-control" required />
                        </div>
                        <div class="form-group col-3">
                            <label for="">DOCUMENTO</label>
                            <input name="cad_documento" id="cad_documento" type="text" class="form-control" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);" maxlength="14">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="contabancariaAtivo" value="1" checked>
                                    <label for="contabancariaAtivo">HABILITADO</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="contabancariaInativo" value="2">
                                    <label for="contabancariaInativo">DESABILITADO</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarContaBancaria" onclick="salvarContaBancaria()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>