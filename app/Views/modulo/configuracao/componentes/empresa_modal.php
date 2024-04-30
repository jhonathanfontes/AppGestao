<div class="modal fade" id="modalEmpresa">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modalTitleEmpresa"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/configuracao/salvar/empresa'), ['method' => 'post', 'id' => 'formEmpresa']) ?>
            <div class="card-body">
                <div hidden>
                    <input name="cod_empresa" id="cod_empresa" type="text">
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="">CNPJ</span></label>
                        <input name="cad_cnpj" id="cad_cnpj" class="form-control cnpj" placeholder="Informe o CNPJ">
                    </div>
                    <div class="form-group col-9">
                        <label for="">RAZÃO</label>
                        <input name="cad_razao" id="cad_razao" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-6">
                        <label for="">FANTASIA</label>
                        <input name="cad_fantasia" id="cad_fantasia" type="text" class="form-control" placeholder="">
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
                    <div class="form-group col-4">
                        <label for="">SETOR/BAIRRO</label>
                        <input name="cad_bairo" id="cad_bairo" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">CIDADE</label>
                        <input name="cad_cidade" id="cad_cidade" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">ESTADO</label>
                        <input name="cad_uf" id="cad_uf" type="text" class="form-control" maxlength="2" placeholder="">
                    </div>
                    <div class="form-group col-4">
                        <label for="">COMPLEMENTO</label>
                        <input name="cad_complemento" id="cad_complemento" type="text" class="form-control" placeholder="">
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
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="SalvarEmpresa" onclick="salvarEmpresa()">SALVAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /. fim modal-fade -->