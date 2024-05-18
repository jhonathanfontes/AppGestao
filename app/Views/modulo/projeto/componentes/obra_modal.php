<div class="modal fade" id="modalObra" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header <?= getenv('tema.modal.header.color'); ?>">
                <h4 class="modal-title"><span id="modalTitleObra"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body">
                <?= form_open(base_url('/api/projeto/salvar/obra'), ['method' => 'post', 'id' => 'formObra']) ?>

                <div class="hidden">
                    <input type="hidden" name="cod_obra" id="cod_obra" />
                    <input type="hidden" name="cod_endereco" id="cod_endereco" />
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">CLIENTE</label>
                        <select name="cod_pessoa" id="cod_pessoa" class="form-control select2bs4" style="width: 100%;">

                        </select>
                    </div>
                    <div class="form-group col-7">
                        <label for="">DESCRIÇÃO</label>
                        <input name="cad_obra" id="cad_obra" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-5" id="container-nascimento">
                        <label for="">DATA PREVISTA</label>
                        <input name="cad_datainicio" id="cad_datainicio" type="date" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="">CEP</label>
                        <input name="cad_cep" id="cad_cep" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-7">
                        <label for="">ENDEREÇO</label>
                        <input name="cad_endereco" id="cad_endereco" type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-2">
                        <label for="">NUMERO</label>
                        <input name="cad_numero" id="cad_numero" type="text" class="form-control" placeholder="">
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
                    <div class="form-group col-12">
                        <label for="">COMPLEMENTO</label>
                        <input name="cad_complemento" id="cad_complemento" type="text" class="form-control"
                            placeholder="">
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary " id="SalvarObra"
                        onclick="salvarObra()">Salvar</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>