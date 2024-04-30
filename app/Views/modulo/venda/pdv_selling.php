<?= $this->extend('_layout/venda') ?>

<?= $this->section('stylesheet_css') ?>

<?php $empresa = dadosEmpresa(); ?>
<style>
    /* Autocomplete
----------------------------------*/
    .ui-autocomplete {
        position: absolute;
        cursor: default;
    }

    /* workarounds */
    * html .ui-autocomplete {
        width: 1px;
    }

    /* without this, the menu expands to 100% in IE6 */

    /* Menu
----------------------------------*/
    .ui-menu {
        list-style: none;
        padding: 10px;
        margin: 0;
        display: block;
    }

    .ui-menu .ui-menu {
        margin-top: -3px;
    }

    .ui-menu .ui-menu-item {
        margin: 0;
        padding: 0;
    }

    .ui-menu .ui-menu-item a {
        text-decoration: none;
        display: block;
        padding: .2em .4em;
        line-height: 1.5;
        zoom: 1;
    }

    .ui-menu .ui-menu-item a.ui-state-hover,
    .ui-menu .ui-menu-item a.ui-state-active {
        margin: -1px;
    }

    .printer-ticket {
        display: table !important;
        width: 100%;
        font-weight: light;
        line-height: 1.3em;
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content_card') ?>

<?= $this->endSection() ?>

<?= $this->section('view_content') ?>

<!-- Main content -->
<section class="content">
    <?php
    // var_dump($venda);
    ?>
    <!-- Card Body - Formulario -->
    <div class="row">
        <div class="col-sm-8">
            <!-- .card INCLUIR PRODUTO -->
            <div class="card card-warning">
                <div class="card-body">
                    <div class="col-sm-12 invoice-info no-print">
                        <?= form_open(base_url('/api/venda/pdv/inclui/produto'), ['method' => 'post', 'id' => 'formAddProduto']) ?>
                        <div class="row mt-3">
                            <div class="hidden">
                                <input type="text" name="cod_orcamento" id="conf_codOrcamento" value="<?= isset($orcamento) ? $orcamento->cod_orcamento : null; ?>" hidden="hidden">
                                <input type="text" name="serial" id="conf_Serial" value="<?= isset($orcamento) ? $orcamento->serial : null; ?>" hidden="hidden">
                                <input type="text" name="cat_grade" id="cat_grade" class="form-control" hidden required>
                            </div>
                            <div class="col-sm-5">
                                <label>PRODUTO - </label><i id="produtoSelect"></i>
                                <input type="text" name="PdvSearchProduto" id="PdvSearchProduto" class="form-control" required>
                            </div>
                            <div class="col-sm-2">
                                <label>ESTOQUE</label>
                                <input type="text" name="est_produto" id="est_produto" value="" class="form-control" disabled="disabled" style="text-align: center;">
                            </div>
                            <div class="col-sm-2">
                                <label>VALOR</label>
                                <input type="text" id="val_venda" class="form-control" disabled="disabled" style="text-align: center;">
                                <input type="text" name="val_venda" id="valor_venda" class="form-control" hidden>
                            </div>
                            <div class="col-sm-2">
                                <label>QUANTIDADE</label>
                                <input type="text" name="quantidade" id="quantidade" class="form-control">
                            </div>
                            <div class="col-sm-1 text-center">
                                <label>INCLUIR</label>
                                <button type="submit" id="submitAdicionar" class="form-control btn btn-success" disabled onclick="AddProdutoOrcamento()"><i class="fas fa-cart-plus"> </i></button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Inicio Tabela Produtos -->
            <div class="col-sm-12 invoice-info no-print">
                <?php if (!empty($detalhes)) : ?>
                    <div class="card card-warning">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>DESCRIÇÃO / TAMANHO</th>
                                                <th>QUANTIDADE</th>
                                                <th>UNITARIO</th>
                                                <th>UNITARIO DESCONTO</th>
                                                <th>TOTAL</th>
                                                <th class="no-print">ACÕES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($detalhes)) : ?>
                                                <?php foreach ($detalhes as $detalhe) : ?>
                                                    <tr>
                                                        <td style="text-align: justify;"><?= $detalhe->produto . ' / ' . $detalhe->tamanho . ' - ' . $detalhe->cad_fabricante ?></td>
                                                        <td><?= $detalhe->qtn_produto ?></td>
                                                        <td><?= number_format($detalhe->valor_un, 2, ',', '.') ?></td>
                                                        <td><?= number_format($detalhe->valor_unad, 2, ',', '.') ?></td>
                                                        <td><?= number_format($detalhe->total_unad, 2, ',', '.') ?></td>
                                                        <td class="no-print">
                                                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#editarGradeProduto" onclick="editarGradeProduto(<?= $detalhe->cod_detalhe ?>);"> <samp class="fas fa-edit fa-sm"></samp></button>
                                                            <button class="btn btn-xs btn-danger" onclick="DeletarDetalhe(<?= $detalhe->cod_detalhe ?>);"> <samp class="fas fa-trash-alt fa-sm"></samp></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tr>
                                                <th>TOTAL</th>
                                                <td><?= isset($orcamento) ? 'R$ ' . number_format($orcamento->valor_bruto, 2, ',', '.') : null; ?></td>
                                                <th>DESCONTO</th>
                                                <td><?= isset($orcamento) ? 'R$ ' . number_format($orcamento->valor_desconto, 2, ',', '.') : null; ?></td>
                                                <th>TOTAL A PAGAR</th>
                                                <td><?= isset($orcamento) ? 'R$ ' . number_format($orcamento->valor_total, 2, ',', '.') : null; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- Card Body - Tabela -->
                <?php endif; ?>
            </div>
            <!-- Fim Tabela Produtos -->

            <!-- Inicio Tabela - Pagamento -->
            <div class="col-sm-12 invoice-info no-print">
                <?php if (!empty($pag_receber) or !empty($pag_movimento)) : ?>
                    <div class="card card-warning">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>FORMA DE PAGAMENTO</th>
                                                <th>REFERENCIA</th>
                                                <th>PACELA</th>
                                                <th>VALOR</th>
                                                <th>VENCIMENTO</th>
                                                <th>ACÕES</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pag_movimento)) : ?>
                                                <?php foreach ($pag_movimento as $detalhe) : ?>
                                                    <tr>
                                                        <td><?= convertFormarPagamento($detalhe->mov_formapagamento) ?> </td>
                                                        <td><?= $detalhe->mov_descricao ?></td>
                                                        <td><?= ($detalhe->mov_formapagamento == 4) ? $detalhe->mov_parcela . '/' . $detalhe->mov_parcela_total : '' ?></td>
                                                        <td><?= number_format($detalhe->mov_valor, 2, ',', '.')  ?></td>
                                                        <td><?= ($detalhe->mov_formapagamento == 3 or $detalhe->mov_formapagamento == 4) ? date("d/m/Y", strtotime($detalhe->concilia_data)) : '' ?></td>
                                                        <td width="200"><button class="btn btn-sm btn-danger" onclick="DeletarPagamento('movimento',<?= $detalhe->codigo ?>);"> <samp class="fas fa-trash-alt fa-sm"></samp> EXCLUIR</button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php if (!empty($pag_receber)) : ?>
                                                <?php foreach ($pag_receber as $detalhe) : ?>
                                                    <tr>
                                                        <td><?= convertFormarPagamento($detalhe->forma_id) ?></td>
                                                        <td><?= $detalhe->rec_referencia ?></td>
                                                        <td><?= $detalhe->rec_parcela . '/' . $detalhe->rec_parcela_total ?></td>
                                                        <td><?= number_format($detalhe->rec_valor, 2, ',', '.')  ?></td>
                                                        <td><?= date("d/m/Y", strtotime($detalhe->rec_vencimento)) ?></td>
                                                        <td width="200"><button class="btn btn-sm btn-danger" onclick="DeletarPagamento('areceber',<?= $detalhe->id_receber ?>);"> <samp class="fas fa-trash-alt fa-sm"></samp> EXCLUIR</button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body - Tabela -->
                <?php endif; ?>
            </div>
            <!-- Fim Tabela - Pagamento -->
        </div>

        <!-- /.card Incluir Produto -->
        <div class="col-sm-4">
            <!-- .card Painel Botoes -->
            <div class="col-sm-12">
                <div class="card card-warning no-print">
                    <div class="card-body">

                        <?php if (($venda->ven_saldo == 0) && ($venda->ven_quitado == 'N') && ($venda->valor_total > 0)) { ?>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <?= form_open(base_url('/api/venda/finaliza/venda'), ['method' => 'post', 'id' => 'formFinalizaVendaPDV']) ?>
                                        <select name="cod_caixa" id="cod_caixa" class="form-control select2bs4" style="width: 100%;">
                                            <?php foreach ($caixas as $row) : ?>
                                                <option value="<?= $row->id_caixa ?>">CAIXA Nº <?= $row->id_caixa ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input name="cod_venda" id="cod_venda" value="<?php echo $venda->cod_venda; ?>" hidden="hidden">
                                        <input name="cod_orcamento" id="cod_orcamento" value="<?php echo $venda->cod_orcamento; ?>" hidden="hidden">
                                        <input name="serial" id="serial" value="<?php echo $venda->serial; ?>" hidden="hidden">
                                        <button type="submit" onclick="salvarFinalizaVendaPDV()" id="submitFinalizaVenda" class="btn btn-success btn-block"><i class="fa fa-check"></i> FINALIZAR VENDA </button>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-basket"></i></span>

                                    <div class="info-box-content text-center">
                                        <span class="info-box-text">VENDA</span>
                                        <span class="info-box-number" style="font-size: 14px;"><?= isset($orcamento) ? 'R$ ' . number_format($orcamento->valor_total, 2, ',', '.') : null; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                                    <div class="info-box-content text-center">
                                        <span class="info-box-text">A PAGAR</span>
                                        <span class="info-box-number" style="font-size: 14px;"><?= isset($venda) ? 'R$ ' . number_format($venda->ven_saldo, 2, ',', '.') : null; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <a class="btn btn-app btn-warning" data-toggle="modal" data-target="#alterarCliente">
                                <i class="fas fa-edit"></i> CLIENTE
                            </a>
                            <a class="btn btn-app btn-warning" data-toggle="modal" data-target="#alterarVendedor">
                                <i class="fas fa-edit"></i> VENDEDOR
                            </a>
                            <a class="btn btn-app btn-warning <?= (empty($detalhes)) ? 'disabled' : ''; ?>" id="buttonDescVista" data-toggle="modal" data-target="#alterarDesconto">
                                <i class="fas fa-play"></i> DESCONTO
                            </a>
                            <a class="btn btn-app btn-warning <?= (empty($detalhes)) ? 'disabled' : ''; ?>" data-toggle="modal" data-target="#modalPagamento">
                                <i class="fas fa-pause"></i> PAGAMENTO
                            </a>
                            <a class="btn btn-app btn-warning <?= (empty($detalhes)) ? 'disabled' : ''; ?>" onclick="showCancelar(<?= isset($orcamento) ? $orcamento->cod_orcamento : null; ?>);">
                                <i class="fas fa-save"></i> CANCELAR
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- ./card Fim dos botes -->

            <!-- Inicio Tabela - Produtos -->
            <div class="col-sm-12 invoice-info">
                <?php if (empty($pedidos)) : ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <table class="printer-ticket">
                                    <thead class="text-center">
                                        <tr>
                                            <th class="title" colspan="5"><?= dadosEmpresa()->emp_fantasia; ?></th>

                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                CLIENTE - <?= isset($orcamento) ? $orcamento->pessoa : null; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="ttu" colspan="5">
                                                <b>CUPOM NÃO FISCAL</b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <br>
                                            </td>
                                        </tr>
                                        <tr class="top">
                                            <td><b>ITEN</b></td>
                                            <td><b>DESCRIÇÃO</b></td>
                                            <td><b>VALOR</b></td>
                                            <td align="center"><b>QTD</b></td>
                                            <td align="right"><b>TOTAL</b></td>
                                        </tr>
                                        <?php if (!empty($detalhes)) : ?>
                                            <?php $itens = 0; ?>
                                            <?php foreach ($detalhes as $detalhe) : ?>
                                                <?php $itens++; ?>
                                                <tr>
                                                    <td><?= $itens; ?></td>
                                                    <td><?= $detalhe->produto . '  -  ' . $detalhe->tamanho ?></td>
                                                    <td><?= number_format($detalhe->valor_unad, 2, ',', '.') ?></td>
                                                    <td align="center"><?= $detalhe->qtn_produto ?></td>
                                                    <td align="right"><?= number_format($detalhe->total_unad, 2, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td><br></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> <i>QTDE TOTAL DE ITENS</i></td>
                                                <td align="right"><i><?= $itens; ?></i></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="sup ttu p--0">
                                            <td colspan="4">
                                                <br>
                                            </td>
                                        </tr>
                                        <tr class="ttu">
                                            <td colspan="4">DESCONTO</td>
                                            <td align="right"><?= isset($orcamento) ? 'R$ ' . number_format($orcamento->valor_desconto, 2, ',', '.') : null; ?></td>
                                        </tr>
                                        <tr class="ttu">
                                            <td colspan="4">TOTAL</td>
                                            <td align="right"><?= isset($orcamento) ? 'R$ ' . number_format($orcamento->valor_total, 2, ',', '.') : null; ?></td>
                                        </tr>

                                        <tr class="sup">
                                            <td colspan="5" align="center">
                                                <b>ORÇAMENTO: </b> <?= isset($orcamento) ? $orcamento->cod_orcamento : null; ?>/<?= isset($orcamento) ? date("Y", strtotime($orcamento->orc_data)) : null; ?>
                                                <b>VENDA: </b> <?= isset($venda) ? $venda->cod_venda : null; ?>/<?= isset($venda) ? date("Y", strtotime($venda->data_compra)) : null; ?>
                                            </td>
                                        </tr>
                                        <tr class="sup">
                                            <td colspan="5" align="center">
                                                <b>VENDEDOR: </b><?= isset($orcamento->vendedor) ? $orcamento->vendedor : 'Não informado'; ?>
                                            </td>
                                        </tr>
                                        <tr class="sup">
                                            <td colspan="5" align="center">
                                                <b>CHAVE: </b><?= isset($orcamento) ? $orcamento->serial : null; ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Fim Tabela Produtos -->

            <!-- Inicio Tabela Pagamentos -->
            <div class="col-sm-12 invoice-info">
                <?php if (empty($pagamentos)) : ?>
                    <div class="card">
                        <div class="card-body">
                            <table class="printer-ticket">
                                <thead class="text-center">
                                    <tr>
                                        <th class="title" colspan="3"><?= dadosEmpresa()->emp_fantasia; ?></th>
                                    </tr>
                                    <tr>
                                        <th class="ttu" colspan="3">
                                            <b>COMPROVANTE DE PAGAMENTO</b>
                                        </th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr class="sup ttu p--0">
                                        <td colspan="3">
                                            <b>PAGAMENTOS</b>
                                        </td>
                                    </tr>
                                    <?php if (!empty($pag_movimento)) : ?>
                                        <?php foreach ($pag_movimento as $detalhe) : ?>
                                            <tr class="ttu">
                                                <td><?= convertFormarPagamento($detalhe->mov_formapagamento) ?>
                                                    <?php if ($detalhe->mov_formapagamento == 4) { ?>
                                                <td><?= $detalhe->mov_parcela . '/' . $detalhe->mov_parcela_total ?></td>
                                            <?php } else { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td align="right"><?= 'R$ ' . number_format($detalhe->mov_valor, 2, ',', '.')  ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($pag_receber)) : ?>
                                        <?php foreach ($pag_receber as $detalhe) : ?>
                                            <tr class="ttu">
                                                <td><?= convertFormarPagamento($detalhe->forma_id) ?> </td>
                                                <td><?= $detalhe->rec_parcela . '/' . $detalhe->rec_parcela_total ?></td>
                                                <td align="right"><?= 'R$ ' . number_format($detalhe->rec_valor, 2, ',', '.')  ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <tr class="ttu">
                                        <td colspan="2"><b>TOTAL PAGO<b></td>
                                        <td align="right"><b><?= isset($venda) ? 'R$ ' . number_format($venda->ven_pagamento + $venda->ven_boleto, 2, ',', '.') : null; ?><b></td>
                                    </tr>
                                    <tr class="sup">
                                        <td colspan="3" align="center">
                                            <b>ORÇAMENTO: </b> <?= isset($orcamento) ? $orcamento->cod_orcamento : null; ?>/<?= isset($orcamento) ? date("Y", strtotime($orcamento->orc_data)) : null; ?>
                                            <b>VENDA: </b> <?= isset($venda) ? $venda->cod_venda : null; ?>/<?= isset($venda) ? date("Y", strtotime($venda->data_compra)) : null; ?>
                                        </td>
                                    </tr>
                                    <tr class="sup">
                                        <td colspan="3" align="center">
                                            OBRIGADO PELA PREFERENCIA
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Fim Tabela Pagamentos -->
        </div>
    </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once('componentes/orcamento_selling_modal.php'); ?>
<?php require_once('componentes/pdv_selling_modal.php'); ?>

<?= $this->endSection() ?>