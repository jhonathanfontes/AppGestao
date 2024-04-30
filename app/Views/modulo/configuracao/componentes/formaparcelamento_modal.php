<div class="modal fade" id="modalFormaParcelamento">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modal_title"></span> GRADE DO PRODUTO: <?= isset($formapagamento->cad_descricao) ? $formapagamento->cad_descricao : 'CADASTRO NÃO LOCALIZADO!';  ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
            $input = [
                'type'  => 'hidden',
                'name'  => 'cod_forma',
                'id'    => 'cod_forma',
                'value' => isset($formapagamento->cod_forma) ? $formapagamento->cod_forma : ''
            ];
            ?>

            <?= form_open(base_url('/api/configuracao/salvar/formaparcelamento'), ['method' => 'post', 'id' => 'formFormaParcelamento']) ?>
            <div class="card-body">
                <div class="hidden">
                    <?= form_input($input); ?>
                </div>
                <div class="row">
                    <div class="form-group col-4" style="text-align: center;">
                        <label for="">BANDEIRA</label>
                        <select name="cad_bandeira" id="cad_bandeira" class="form-control select2bs4" required>
                            <option value="">SELECIONA A BANDEIRA</option>
                            <?php if (!empty($bandeiras)) : ?>
                                <?php foreach ($bandeiras as $row) : ?>
                                    <option value="<?= isset($row->cod_bandeira) ? $row->cod_bandeira : '';  ?>"><?= isset($row->cad_bandeira) ? $row->cad_bandeira : '';  ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-3" style="text-align: center;">
                        <label for="">PARCELA</label>
                        <select name="cad_parcela" id="cad_parcela" class="form-control" required>
                            <option value="">SELECIONA A PARCELA</option>
                        </select>
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">PRAZO</label>
                        <input type="number" name="cad_prazo" id="cad_prazo" class="form-control">
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">TAXA</label>
                        <input name="cad_taxa" id="cad_taxa" class="form-control taxabr" placeholder="1.90 %">
                    </div>

                    <div class="form-group col-1" style="text-align: center;">
                        <label for="">&nbsp</label>
                        <button type="submit" id="incluirFormaParcelamento" class="btn btn-outline-info btn-block btn-flat" onclick="salvarParcelamentoBandeira()"></i> INCLUIR</button>
                        <!-- <input type="button" name="cad_venda" id="cad_venda" class="form-control valorbr" value="Incluir"> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade" id="modalFormasParcelamentos">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h4 class="modal-title"><span id="modalTitleFormasParcelamentos"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(base_url('/api/configuracao/salvar/formasparcelamentos'), ['method' => 'post', 'id' => 'formFormasParcelamentos']) ?>
            <div class="card-body">
                <div class="row" id="formFormasAtributos">
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">PRAZO</label>
                        <input type="number" name="cad_prazo" class="form-control">
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">TAXA</label>
                        <input name="cad_taxa" class="form-control taxabr" placeholder="1.90 %">
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">PRAZO</label>
                        <input type="number" name="cad_prazo" class="form-control">
                    </div>
                    <div class="form-group col-2" style="text-align: center;">
                        <label for="">TAXA</label>
                        <input name="cad_taxa" class="form-control taxabr" placeholder="1.90 %">
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
                <button type="submit" class="btn btn-primary " id="SalvarFormasParcelamentos" onclick="salvarFormasParcelamentos()">Salvar</button>

            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>