<?= $this->extend('_layout/projeto') ?>

<?= $this->section('view_content') ?>

<section class="content">
    <?php if (!empty($pontuacao)): ?>
        <div class="content">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Olá, <?= $this->session->userdata('jb_apelido'); ?>!</strong> <?= $pontuacao->pes_nome; ?> POSSUI
                <strong><?= $pontuacao->pontos - $pontuacao->utilizados; ?> PONTOS</strong> NO PROGRAMA DE FIDELIDADE!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php // dd($obra) ?>

    <!-- Main content -->
    <section class="content">
        <!-- Card Body - Formulario -->
        <div class="card card-warning">
            <div class="card-body">
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> <?= dadosEmpresa()->emp_fantasia; ?>
                                <small class="float-right"><?php echo $card_title; ?></small>
                            </h4>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                            <address>
                                CLIENTE:
                                <strong>
                                    <button class="btn btn-xs btn-primary no-print" data-toggle="modal"
                                        data-target="#alterarCliente">
                                        <samp class="fas fa-edit fa-sm"></samp> ALTERAR</button>
                                </strong>
                                <br>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-2 invoice-col no-print">
                            <address>
                                VENDEDOR:
                                <strong>
                                    <button class="btn btn-xs btn-primary no-print" data-toggle="modal"
                                        data-target="#alterarVendedor">
                                        <samp class="fas fa-edit fa-sm"></samp> ALTERAR</button>
                                </strong>
                                <br>
                            </address>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="col-sm-12 invoice-info no-print">
                                <?= form_open(base_url('/api/venda/orcamento/inclui/produto'), ['method' => 'post', 'id' => 'formAddProduto']) ?>
                                <div class="row">
                                    <div class="hidden">
                                        <input type="text" name="cod_obra" value="<?php echo $obra->cod_obra ?>"
                                            hidden="hidden">
                                        <input type="text" name="cod_local" value="" hidden="hidden">
                                        <input type="text" name="cod_produto" id="cod_produto" class="form-control"
                                            hidden required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>CODIGO DE BARRA / PRODUTO</label>
                                        <input type="text" name="searchProduto" id="searchProduto" class="form-control"
                                            autofocus required>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>ESTOQUE</label>
                                        <input type="text" name="est_produto" id="est_produto" value=""
                                            class="form-control" disabled="disabled" style="text-align: center;">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>A VISTA</label>
                                        <input type="text" id="val_avista" class="form-control" disabled="disabled"
                                            style="text-align: center;">
                                        <input type="text" name="valor_avista" id="valor_avista" class="form-control"
                                            hidden>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>A PRAZO</label>
                                        <input type="text" id="val_aprazo" class="form-control" disabled="disabled"
                                            style="text-align: center;">
                                        <input type="text" name="valor_aprazo" id="valor_aprazo" class="form-control"
                                            hidden>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>QUANTIDADE</label>
                                        <input type="text" name="quantidade" id="quantidade" class="form-control">
                                    </div>
                                    <div class="col-sm-1" style="text-align: center;">
                                        <label>ADICIONAR</label>
                                        <button type="submit" id="submitAdicionar" class="form-control btn btn-success"
                                            disabled onclick="AddProdutoOrcamento()"><i class="fas fa-cart-plus">
                                            </i></button>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <!-- /.row -->
                            <!-- Table row -->
                            <div class="row mt-2">
                                <div class="col-12 table-responsive">
                                    <table class="table table-sm table-striped" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>CODIGO</th>
                                                <th style="text-align: justify;">DESCRIÇÃO / TAMANHO</th>
                                                <th>QUANTIDADE</th>
                                                <th>VALOR <?= (1 == 1) ? 'A VISTA' : 'A PRAZO'; ?></th>
                                                <th>VALOR COM DESCONTO</th>
                                                <th>TOTAL</th>
                                                <th class="no-print">ACÕES</th>
                                                <th class="no-print"> <a onclick="MarcarDesmarcar();">EXCLUIR</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="text" name="rota" value="venda/selling/" hidden="hidden">
                                            <?php if (!empty($detalhes)): ?>
                                                <?php $sequencia = 1; ?>
                                                <?php foreach ($detalhes as $detalhe): ?>
                                                    <tr>
                                                        <td><?= $detalhe->cod_produto ?></td>
                                                        <td style="text-align: justify;">
                                                            <?= $detalhe->produto . ' / ' . $detalhe->tamanho ?>
                                                            <?php if ($detalhe->presente == 'S') { ?> <i
                                                                    class="fas fa-gift"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $detalhe->qtn_produto ?></td>
                                                        <td><?= number_format((($orcamento->cod_tipo == 1) ? $detalhe->valor_un : $detalhe->praz_valor_un), 2, ',', '.') ?>
                                                        </td>
                                                        <td><?= number_format((($orcamento->cod_tipo == 1) ? $detalhe->valor_unad : $detalhe->praz_valor_unad), 2, ',', '.') ?>
                                                        </td>
                                                        <td><?= number_format((($orcamento->cod_tipo == 1) ? $detalhe->total_unad : $detalhe->praz_total_unad), 2, ',', '.') ?>
                                                        </td>
                                                        <td class="no-print" width="200">
                                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                                data-target="#editarGradeProduto"
                                                                onclick="editarGradeProduto(<?php echo $detalhe->cod_detalhe ?>);">
                                                                <samp class="fas fa-edit fa-sm"></samp> ALTERAR</button>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="deleteCheckbox[<?= $sequencia ?>]" name="cod_detalhe[]"
                                                                    value="<?= $detalhe->cod_detalhe ?>">
                                                                <label for="deleteCheckbox[<?= $sequencia ?>]"
                                                                    class="custom-control-label"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $sequencia++; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>TOTAL</th>
                                                    <th></th>
                                                    <th></th>
                                                    <?php if (1 == 1) { ?>
                                                        <th><?php echo number_format(000, 2, ',', '.') ?></th>
                                                        <th></th>
                                                        <th><?php echo number_format(000, 2, ',', '.') ?></th>
                                                    <?php } ?>

                                                    <td colspan="2" style="text-align: center;"><button
                                                            class="btn btn-sm btn-danger" onclick="DeletarDetalhes()"
                                                            id="DeletarDetalheSelect" hidden> <samp
                                                                class="fas fa-trash-alt fa-sm"></samp> EXCLUIR
                                                            SELECIONADOS</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php endif; ?>
                                        <!--
                                     </form>
                                     -->
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-8">
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <?php
                                            $total = 0;
                                            $desconto = 0;
                                            $apagar = 0;
                                            ?>
                                            <thead>
                                                <tr>
                                                    <th style="width:50%">TOTAL</th>
                                                    <td>R$ <?php echo number_format($total, 2, ',', '.') ?></td>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <th><?= ($desconto >= 0) ? 'DESCONTO' : 'ACRÉSCIMO'; ?></th>
                                                <td>R$ <?php echo number_format(($desconto * -1), 2, ',', '.') ?></td>
                                            </tr>
                                            <tfoot>
                                                <tr>
                                                    <th>TOTAL A PAGAR</th>
                                                    <td>R$ <?php echo number_format($apagar, 2, ',', '.') ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="col-4">
                            <div class="col-sm-12 invoice-info no-print">
                                <div class="col-12 table-responsive">
                                    <table class="table table-sm table-striped" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: justify;">LOCAL</th>
                                                <th class="no-print">ACÕES</th>
                                                <th class="no-print"> <a onclick="MarcarDesmarcar();">EXCLUIR</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="text" name="rota" value="venda/selling/" hidden="hidden">
                                            <?php if (!empty($detalhes)): ?>
                                                <?php $sequencia = 1; ?>
                                                <?php foreach ($detalhes as $detalhe): ?>
                                                    <tr>
                                                        <td><?= $detalhe->cod_produto ?></td>
                                                        <td style="text-align: justify;">
                                                            <?= $detalhe->produto . ' / ' . $detalhe->tamanho ?>
                                                            <?php if ($detalhe->presente == 'S') { ?> <i
                                                                    class="fas fa-gift"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $detalhe->qtn_produto ?></td>
                                                        <td><?= number_format((($orcamento->cod_tipo == 1) ? $detalhe->valor_un : $detalhe->praz_valor_un), 2, ',', '.') ?>
                                                        </td>
                                                        <td><?= number_format((($orcamento->cod_tipo == 1) ? $detalhe->valor_unad : $detalhe->praz_valor_unad), 2, ',', '.') ?>
                                                        </td>
                                                        <td><?= number_format((($orcamento->cod_tipo == 1) ? $detalhe->total_unad : $detalhe->praz_total_unad), 2, ',', '.') ?>
                                                        </td>
                                                        <td class="no-print" width="200">
                                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                                data-target="#editarGradeProduto"
                                                                onclick="editarGradeProduto(<?php echo $detalhe->cod_detalhe ?>);">
                                                                <samp class="fas fa-edit fa-sm"></samp> ALTERAR</button>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="deleteCheckbox[<?= $sequencia ?>]" name="cod_detalhe[]"
                                                                    value="<?= $detalhe->cod_detalhe ?>">
                                                                <label for="deleteCheckbox[<?= $sequencia ?>]"
                                                                    class="custom-control-label"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $sequencia++; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>TOTAL</th>
                                                    <th></th>
                                                    <th></th>
                                                    <?php if (1 == 1) { ?>
                                                        <th><?php echo number_format(000, 2, ',', '.') ?></th>
                                                        <th></th>
                                                        <th><?php echo number_format(000, 2, ',', '.') ?></th>
                                                    <?php } ?>

                                                    <td colspan="2" style="text-align: center;"><button
                                                            class="btn btn-sm btn-danger" onclick="DeletarDetalhes()"
                                                            id="DeletarDetalheSelect" hidden> <samp
                                                                class="fas fa-trash-alt fa-sm"></samp> EXCLUIR
                                                            SELECIONADOS</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php endif; ?>
                                        <!--
                                     </form>
                                     -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <?= form_open(base_url('/api/venda/finaliza/orcamento'), ['method' => 'post', 'id' => 'formfinishOrcamento']) ?>
                            <input name="venda_serial" value="" hidden="hidden">
                            <input name="venda_id" value="" hidden="hidden">
                            <input name="venda_val" value="" hidden="hidden">
                            <button type="submit" id="submitFinalizar" class="btn btn-success float-right"
                                style="margin-right: 5px;" onclick="finishOrcamento()" <?= (empty($detalhes)) ? 'disabled' : ''; ?>><i class="far fa-credit-card"></i> FINALIZAR VENDA </button>
                            <?= form_close() ?>
                            <?php if (1 == 1) { ?>
                                <button type="button" class="btn btn-danger float-right" id="buttonDescVista"
                                    data-toggle="modal" data-target="#alterarDesconto" style="margin-right: 5px;"
                                    <?= (empty($detalhes)) ? 'disabled' : ''; ?>>
                                    DESCONTO</button>
                            <?php }
                            if (1 == 2) { ?>
                                <button type="button" class="btn btn-danger float-right" id="buttonDescPrazo"
                                    data-toggle="modal" data-target="#alterarDesconto" style="margin-right: 5px;"
                                    <?= (empty($detalhes)) ? 'disabled' : ''; ?>>
                                    DESCONTO</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Body - Tabela -->
        </div>

    </section>
    <!-- /.content -->

</section>
<!-- /.content -->
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once ('componentes/local_modal.php'); ?>
<?= $this->endSection() ?>