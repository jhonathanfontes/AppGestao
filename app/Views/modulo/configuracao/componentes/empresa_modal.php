<div class="modal fade" id="modalEmpresa" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title"><span id="modalTitleEmpresa"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/configuracao/salvar/empresa'), ['method' => 'post', 'id' => 'formEmpresa']) ?>
            <div class="card-body">
                <div hidden>
                    <input name="cod_empresa" id="cod_empresa" type="text">
                    <input name="cod_endereco" id="cod_endereco" type="text">
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="">CNPJ</span></label>
                        <input name="cad_documento" id="cad_documento" onfocus="javascript: retirarFormatacao(this);"
                            onblur="javascript: validaCnpjEmpresa(this);" class="form-control"
                            placeholder="Informe o CNPJ">
                    </div>
                    <div class="form-group col-1" id="container-sync">
                        <label for="">SYNC</label>
                        <button type="button" id="buttonSyncPessoa" class="btn btn-outline-primary btn-block"
                            onclick="consultaCNPJ(this)" disabled><i class="fa fa-sync"></i></button>
                    </div>
                    <div class="form-group col-8">
                        <label for="">RAZÃO</label>
                        <input name="cad_nome" id="cad_nome" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-6">
                        <label for="">FANTASIA</label>
                        <input name="cad_apelido" id="cad_apelido" type="text" class="form-control" placeholder="">
                    </div>

                    <div class="form-group col-6">
                        <label for="">SLOGAN</label>
                        <input name="cad_slogan" id="cad_slogan" type="text" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-2">
                        <label for="">CEP</label>
                        <input name="cad_cep" id="cad_cep" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-6">
                        <label for="">ENDEREÇO</label>
                        <input name="cad_endereco" id="cad_endereco" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-1">
                        <label for="">NUMERO</label>
                        <input name="cad_numero" id="cad_numero" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-3">
                        <label for="">SETOR/BAIRRO</label>
                        <input name="cad_setor" id="cad_setor" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">CIDADE</label>
                        <input name="cad_cidade" id="cad_cidade" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">ESTADO</label>
                        <input name="cad_estado" id="cad_estado" type="text" class="form-control" maxlength="2"
                            placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">COMPLEMENTO</label>
                        <input name="cad_complemento" id="cad_complemento" type="text" class="form-control"
                            placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-2">
                        <label for="">TELEFONE</label>
                        <input name="cad_telefone" id="cad_telefone" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">E-MAIL</label>
                        <input name="cad_email" id="cad_email" type="email" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                            <div class="col-sm-3">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="status" id="empresaAtivo" value="1" checked>
                                    <label for="empresaAtivo"> HABILITADO </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="icheck-danger d-inline">
                                    <input type="radio" name="status" id="empresaInativo" value="2">
                                    <label for="empresaInativo"> DESABILITADO </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="SalvarEmpresa"
                    onclick="salvarEmpresa()">SALVAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /. fim modal-fade -->