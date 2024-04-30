<div class="modal fade" id="modalPessoa">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><span id="modalTitlePessoa"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/cadastro/salvar/pessoa'), ['method' => 'post', 'id' => 'formPessoa']) ?>
            <div class="card-body">
                <div class="hidden">
                    <input name="cod_pessoa" id="cod_pessoa" hidden>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="">TIPO</label>
                        <select name="cad_tipopessoa" id="cad_tipopessoa" class="form-control">
                            <option value="1" selected="selected">CLIENTE</option>
                            <option value="2">FORNECEDOR</option>
                            <option value="3">CLIENTE/FORNECEDOR</option>
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="">NATUREZA</label>
                        <select name="cad_natureza" id="cad_natureza" class="form-control">
                            <option value="F">FISICA</option>
                            <option value="J">JURIDICA</option>
                        </select>
                    </div>
                    <div class="form-group col-5">
                        <label for=""><span id="nameDocumento">CPF/CNPJ</span></label>
                        <input name="cad_documento" id="cad_documento" class="form-control"
                            onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);"
                            maxlength="14" placeholder="Informe o CPF ou CNPJ">
                    </div>
                    <div class="form-group col-1" id="container-sync">
                            <label for="">SYNC</label>
                            <button type="button" id="buttonSync" class="btn btn-outline-primary btn-block" disabled><i class="fa fa-sync"></i></button>
                        </div>
                </div>
                    <div class="row">
                        <div class="form-group col-5" id="container-nascimento">
                            <label for="">DATA NASCIMENTO</label>
                            <input name="cad_nascimeto" id="cad_nascimeto" type="date" class="form-control">
                        </div>
                        <div class="form-group col-5" id="container-rg">
                            <label for="">RG</label>
                            <input name="cad_rg" id="cad_rg" type="text" class="form-control">
                        </div>
                    </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="">NOME</label>
                        <input name="cad_nome" id="cad_nome" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-6">
                        <label for="">APELIDO / FANTASIA</label>
                        <input name="cad_apelido" id="cad_apelido" type="text" class="form-control" placeholder="">
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
                        <input name="cad_numero" id="cad_numero" type="number" class="form-control" placeholder="">
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
                    <div class="form-group col-2">
                        <label for="">CELULAR</label>
                        <input name="cad_celular" id="cad_celular" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">E-MAIL</label>
                        <input name="cad_email" id="cad_email" type="email" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">PROFISSÃO</label>
                        <select name="cod_profissao" id="pes_profissao" class="form-control select2bs4"
                            style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                        <div class="col-sm-3">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="status" id="pessoaAtivo" value="1" checked>
                                <label for="pessoaAtivo"> HABILITADO</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="icheck-danger d-inline">
                                <input type="radio" name="status" id="pessoaInativo" value="2">
                                <label for="pessoaInativo"> DESABILITADO</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="SalvarPessoa" onclick="SalvaPessoa()">SALVAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /. fim modal-fade -->