<!-- /.modal's Descontos -->
<div class="modal fade" id="descontoPrazo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title">Desconto na Compra a Prazo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/venda/atualiza/desconto/valor/aprazo'), ['method' => 'post', 'id' => 'formDescontoAPrazoOrcamento']) ?>
            <div class="modal-body">
                <div class="form-group col-12">
                    <label for=""></label><br>
                    <input name="cod_orcamento" value="<?php echo $orcamento->cod_orcamento ?>" hidden="hidden">
                    <input name="serial" value="<?php echo $orcamento->serial ?>" hidden="hidden">
                    <input name="cod_tipo" value="2" hidden="hidden">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">PERCENTUAL</label>
                            <input name="desc_perc_prazo" id="desc_perc_prazo" class="taxabr form-control" onblur="descVendaPrazo();">
                        </div>
                        <div class="form-group col-6">
                            <label for="">VALOR FINAL</label>
                            <input name="desc_val_prazo" id="desc_val_prazo" class="valorbr form-control" onblur="descVendaPrazo();">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">COMPRA</label>
                            <input id="val_praz_pagar" value="<?php echo $orcamento->praz_bruto ?>" hidden="hidden">
                            <input id="compra_praz" class="form-control" value=" <?php echo number_format($orcamento->praz_bruto, 2, ',', '.') ?>" disabled="disabled">
                        </div>
                        <div class="form-group col-3">
                            <label for="">PERCENTUAL</label>
                            <input id="perc_prazo_d" class="form-control" disabled="disabled">
                            <input name="perc_prazo" id="perc_prazo" class="form-control" hidden="hidden">
                        </div>
                        <div class="form-group col-3">
                            <label for="">DESCONTO</label>
                            <input id="desc_compra_praz" class="form-control" disabled="disabled">
                        </div>
                        <div class="form-group col-3">
                            <label for="">VALOR FINAL</label>
                            <input id="val_compra_praz" class="form-control" disabled="disabled">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitDescPrazo" class="btn btn-primary" disabled onclick="descontoAPrazoOrcamento()">APLICAR</button>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-Desconto -->
</div>

<div class="modal fade" id="descontoVista" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title">Desconto na Compra a Vista</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/venda/atualiza/desconto/valor/avista'), ['method' => 'post', 'id' => 'formDescontoAVistaOrcamento']) ?>
            <div class="modal-body">
                <div class="form-group col-12">
                    <label for=""></label><br>
                    <input name="cod_orcamento" value="<?php echo $orcamento->cod_orcamento ?>" hidden="hidden">
                    <input name="serial" value="<?php echo $orcamento->serial ?>" hidden="hidden">
                    <input name="cod_tipo" value="1" hidden="hidden">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">PERCENTUAL</label>
                            <input name="desc_perc_vista" id="desc_perc_vista" class="taxabr form-control" onblur="descVendaVista();">
                        </div>
                        <div class="form-group col-6">
                            <label for="">VALOR FINAL</label>
                            <input name="desc_val_vista" id="desc_val_vista" class="valorbr form-control" onblur="descVendaVista();">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">COMPRA</label>
                            <input id="val_vist_pagar" value="<?php echo $orcamento->valor_bruto ?>" hidden="hidden">
                            <input id="compra_vist" class="form-control" value="<?php echo number_format($orcamento->valor_bruto, 2, ',', '.') ?>" disabled="disabled">
                        </div>
                        <div class="form-group col-3">
                            <label for="">PERCENTUAL</label>
                            <input id="perc_vista_d" class="form-control" disabled="disabled">
                            <input name="perc_vista" id="perc_vista" class="form-control" hidden="hidden">
                        </div>
                        <div class="form-group col-3">
                            <label for="">DESCONTO</label>
                            <input name="desc_compra_vist" id="desc_compra_vist" class="form-control" disabled="disabled">
                        </div>
                        <div class="form-group col-3">
                            <label for="">VALOR FINAL</label>
                            <input name="val_compra_vist" id="val_compra_vist" class="form-control" disabled="disabled">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitDescVista" class="btn btn-primary" disabled onclick="descontoAVistaOrcamento()">APLICAR</button>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-Desconto -->
</div>

<div class="modal fade" id="alterarDesconto" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title">DESCONTO NO ORÇAMENTO Nº <?= $orcamento->cod_orcamento ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/venda/atualiza/desconto/orcamento'), ['method' => 'post', 'id' => 'formDescontoValorOrcamento']) ?>
            <div class="modal-body">
                <div class="form-group col-12">

                    <label for=""></label><br>
                    <input name="cod_orcamento" value="<?php echo $orcamento->cod_orcamento ?>" hidden="hidden">
                    <input name="serial" value="<?php echo $orcamento->serial ?>" hidden="hidden">
                    <input name="cod_tipo" value="<?php echo $orcamento->cod_tipo ?>" hidden="hidden">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">PERCENTUAL</label>
                            <input name="desc_percentual" id="desc_percentual" class="taxabr form-control" onblur="atualizaValorOrcamento();">
                        </div>
                        <div class="form-group col-6">
                            <label for="">VALOR FINAL</label>
                            <input name="desc_val_final" id="desc_val_final" class="valorbr form-control" onblur="atualizaValorOrcamento();">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">COMPRA</label>
                            <input id="compra_total" class="form-control" value="<?= number_format((($orcamento->cod_tipo == 1) ? $orcamento->valor_bruto : $orcamento->praz_bruto), 2, ',', '.')  ?>" disabled="disabled">
                        </div>
                        <div class="form-group col-3">
                            <label for="">PERCENTUAL</label>
                            <input id="perc_percentual_view" class="form-control" disabled="disabled">
                            <input name="perc_percentual" id="perc_percentual" class="form-control" hidden="hidden">
                        </div>
                        <div class="form-group col-3">
                            <label for="">DESCONTO</label>
                            <input name="desconto_compra" id="desconto_compra" class="form-control" disabled="disabled">
                        </div>
                        <div class="form-group col-3">
                            <label for="">VALOR FINAL</label>
                            <input name="valor_compra" id="valor_compra" value="<?= number_format((($orcamento->cod_tipo == 1) ? $orcamento->valor_bruto : $orcamento->praz_bruto), 2, ',', '.')  ?>" class="form-control" disabled="disabled">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitDesconto" class="btn btn-primary" disabled onclick="descontoValorOrcamento()">APLICAR</button>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-Desconto -->
</div>

<!-- /.modal editarProduto -->
<div class="modal fade" id="editarGradeProduto" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"> <span id="nameGradeProduto"></span></h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/venda/atualiza/orcamento/produto'), ['method' => 'post', 'id' => 'formUpdateGradeProduto']) ?>

            <div class="card-body">
                <input name="cod_detalhe" id="id_detalhe" hidden="hidden">
                <input name="cod_tipo" id="cod_tipo" hidden="hidden">
                <input name="serial" value="<?php echo $orcamento->serial ?>" hidden="hidden">
                <input name="cod_orcamento" value="<?php echo $orcamento->cod_orcamento ?>" hidden="hidden">
                <div class="row">
                    <div class="form-group col-3">
                        <label for="">QUANTIDADE</label>
                        <input name="qnt_produto" id="qnt_produto" class="form-control" onblur="atualizaGradeProduto();">
                    </div>
                    <div class="form-group col-3">
                        <label for="">VALOR UNITARIO</label>
                        <input name="valor_unidade" id="valor_unidade" class="form-control" disabled="disabled">
                    </div>
                    <div class="form-group col-3">
                        <label for="">VALOR COM DESCONTO</label>
                        <input name="valor_desc" id="valor_desc" class="valorbr form-control" onblur="atualizaGradeProduto();">
                    </div>
                    <div class="form-group col-3">
                        <label for="">TOTAL</label>
                        <input name="valor_total" id="valor_total" class="form-control" disabled="disabled">
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitGradeProduto" class="btn btn-primary" onclick="salvarGradeProduto()">APLICAR</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-EditarProduto -->
</div>

<!-- /.modal alterarCliente -->
<div class="modal fade" id="alterarCliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><?php echo "CLIENTE ORÇAMENTO Nº " . $orcamento->cod_orcamento . '/' . date("Y", strtotime($orcamento->orc_data)); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/venda/atualiza/orcamento/cliente'), ['method' => 'post', 'id' => 'formCliemteOrcamento']) ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Cliente</label>
                            <input type="text" name="cod_orcamento" value="<?php echo $orcamento->cod_orcamento ?>" hidden="hidden">
                            <input type="text" name="serial" value="<?php echo $orcamento->serial ?>" hidden="hidden">
                            <div class="col-sm-11">
                                <select name="cod_pessoa" id="cod_cliente" class="form-control select2bs4" style="width: 100%;" required>
                                    <?php if (!empty($clientes)) : ?>
                                        <?php foreach ($clientes as $row) : ?>
                                            <option value="<?php echo $row->cod_pessoa ?>" <?php if ($row->cod_pessoa == $orcamento->cod_pessoa) {
                                                                                                echo 'selected="selected"';
                                                                                            } ?>>
                                                <?php echo $row->cad_nome ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-primary" id="salvarCliemteOrcamento" onclick="ClienteOrcamento()">APLICAR</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-EditarCliente -->
</div>

<!-- /.modal alterarVendedor -->
<div class="modal fade" id="alterarVendedor" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><?php echo "VENDEDOR ORÇAMENTO Nº " . $orcamento->cod_orcamento . '/' . date("Y", strtotime($orcamento->orc_data)); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/venda/atualiza/orcamento/vendedor'), ['method' => 'post', 'id' => 'formVendedorOrcamento']) ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Vendedor</label>
                            <input type="text" name="cod_orcamento" value="<?php echo $orcamento->cod_orcamento ?>" hidden="hidden">
                            <input type="text" name="serial" value="<?php echo $orcamento->serial ?>" hidden="hidden">
                            <div class="col-sm-11">
                                <select name="cod_vendedor" id="cod_vendedor" class="form-control select2bs4" style="width: 100%;" required>
                                    <?php if (!empty($vendedores)) : ?>
                                        <?php foreach ($vendedores as $row) : ?>
                                            <option value="<?php echo $row->cod_vendedor ?>" <?php if ($row->cod_vendedor == $orcamento->vendedor_id) {
                                                                                                    echo 'selected="selected"';
                                                                                                } ?>>
                                                <?php echo $row->pessoa ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-primary" id="salvarVendedorOrcamento" onclick="VendedorOrcamento()">APLICAR</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-EditarVendedor -->
</div>