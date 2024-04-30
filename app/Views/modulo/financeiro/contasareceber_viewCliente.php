<?= $this->extend('_layout/financeiro') ?>

<?= $this->section('view_content') ?>

<section class="content">
    <div class="card-body">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-8">
                    <h4>
                        <i class="fas fa-globe"></i> <?php // echo $empresa['emp_fantasia']; 
                                                        ?>
                        <small class="float-right"><?php // echo $cliente->codigo 
                                                    ?></small>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-2">
                    <?php // var_dump($cliente); 
                    ?>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">

                <!-- /.col -->
                <div class="col-12">
                    <?php // var_dump($contas); 
                    ?>
                </div>
                <!-- /.col -->
            </div>

            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-5 invoice-col">
                    CONTA A RECEBER
                    <address>
                        CIENTE: <strong> <?= isset($cliente->cod_pessoa) ? ($cliente->cod_pessoa) : '';  ?> </strong> - <strong> <?= isset($cliente->cad_nome) ? ($cliente->cad_nome) : '';  ?> </strong>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th>E-MAIL</th>
                                <td><?= isset($cliente->cad_email) ? $cliente->cad_email : '';  ?></td>
                            </tr>
                            <tr>
                                <th>TELEFONE</th>
                                <td><?= isset($cliente->cad_telefone) ? $cliente->cad_telefone : '';  ?></td>
                            </tr>
                            <tr>
                                <th>CELULAR</th>
                                <td><?= isset($cliente->cad_celular) ? $cliente->cad_celular : '';  ?></td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th style="width: 30px;">ENDEREÇO</th>
                                <td>
                                    <?= isset($cliente->cad_endereco) ? $cliente->cad_endereco : ''; ?>
                                    <?= (isset($cliente->cad_endereco) && !empty($cliente->cad_numero)) ? ' Nº ' . $cliente->cad_numero : '';  ?>
                                </td>
                            </tr>
                            <tr>
                                <th>SETOR</th>
                                <td><?= isset($cliente->cad_setor) ? $cliente->cad_cep : '';  ?></td>
                            </tr>
                            <tr>
                                <th>CIDADE</th>
                                <td>
                                    <?= isset($cliente->cad_cidade) ? $cliente->cad_cidade : ''; ?>
                                    <?= (isset($cliente->cad_cidade) && !empty($cliente->cad_estado)) ? ' - ' . $cliente->cad_estado : '';  ?>
                                </td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <?php if (!empty($contas)) : ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?= isset($card_title) ? $card_title : ''; ?></h3>
                            </div>
                            <div class="card-body">
                                <?= form_open(base_url('/api/financeiro/contasreceber/payment'), ['method' => 'post', 'id' => 'formPaymentContaReceber']) ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead style="text-align: center;">
                                            <tr style="font-size: 12px;">
                                                <th style="width: 10%;">RECEBER <span class="badge bg-teal" id="selecionados"></span></th>
                                                <th>VENCIMENTO</th>
                                                <th>VALOR</th>
                                                <th>CANCELADO</th>
                                                <th>RECEBIDO</th>
                                                <th>RESTANTE</th>
                                                <th style="width: 10%;">REFERENCIA</th>
                                                <th>PARCELAS</th>
                                                <th class="no-print" style="width: 10%;">EDITAR</th>
                                                <th class="no-print" style="width: 10%;">VISUALIZAR</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 13px;">
                                            <?php $sequencia = 1; ?>
                                            <?php foreach ($contas as $row) : ?>
                                                <tr style="text-align: center;">
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="pagamentoCheckbox[<?= $sequencia ?>]" name="id_conta[]" value="<?= $row->cod_receber ?>">
                                                            <label for="pagamentoCheckbox[<?= $sequencia ?>]" class="custom-control-label"></label>
                                                        </div>
                                                    </td>
                                                    <td><?= date("d/m/Y", strtotime($row->vencimento)) ?></td>
                                                    <td>
                                                        <?= 'R$ ' . number_format($row->valor, 2, ',', '.') ?>
                                                        <input type="hidden" id="valor_<?= $row->cod_receber ?>" value="<?= $row->valor ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <?= 'R$ ' . number_format($row->cancelado, 2, ',', '.') ?>
                                                        <input type="hidden" id="cancelado_<?= $row->cod_receber ?>" value="<?= $row->cancelado ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <?= 'R$ ' . number_format($row->recebido, 2, ',', '.') ?>
                                                        <input type="hidden" id="recebido_<?= $row->cod_receber ?>" value="<?= $row->recebido ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <?= 'R$ ' . number_format($row->saldo, 2, ',', '.') ?>
                                                        <input type="hidden" id="saldo_<?= $row->cod_receber ?>" value="<?= $row->saldo ?>" disabled>
                                                    </td>
                                                    <td><?= $row->referencia ?></td>
                                                    <td><?= $row->parcela . '/' . $row->parcela_total ?></td>
                                                    <td class="no-print"><?= ($row->cod_orcamento != null) ? '<span class="badge badge-pill badge-secondary">NÃO PERMITIDO</span>' : '<button type="button" class="btn btn-xs btn-block btn-flat btn-warning" data-toggle="modal" data-target="#modalReceber" onclick="getEditReceber(' . $row->cod_receber . ')"><samp class="far fa-edit fa-xs"></samp> EDITAR</button>' ?></td>
                                                    <td class="no-print"><?= '<button type="button" class="btn btn-xs btn-block btn-flat btn-primary" data-toggle="modal" data-target="#modalViewReceber" onclick="getViewReceber(' . $row->cod_receber . ')"><samp class="far fa-eye fa-xs"></samp> VISUALIZAR</button>' ?></td>
                                                </tr>
                                                <?php $sequencia++; ?>
                                            <?php endforeach; ?>

                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: center;">
                                                <th></th>
                                                <th>TOTAL</th>
                                                <th>R$ <span id="total_valor"></span></th>
                                                <th>R$ <span id="total_cancelado"></span></th>
                                                <th>R$ <span id="total_recebido"></span></th>
                                                <th>R$ <span id="total_saldo"></span></th>
                                                <th colspan="2"></th>
                                                <th colspan="2" class="no-print"><button class="btn btn-xs btn-block btn-success" id="receberParcelaPagamento" data-toggle="modal" data-target="#modalPagamentoReceber" onclick="detalheAReceberPagamento()" hidden><i class=" far fa-credit-card"> RECEBER</button></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="card" id="cardParcelaPagamento" hidden>
                                    <div class="card-body">
                                        <?php if (!empty($caixa)) : ?>
                                            <div class="col-sm-12 invoice-info">
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
                                                            <input name="tipoTransferencia" id="tipoTransferencia" value="R" hidden>
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
                                                            <select name="serial_caixa" id="serial_caixa" class="form-control select2bs4" style="width: 100%;">
                                                                <?php if (isset($caixa)) : ?>
                                                                    <?php foreach ($caixa as $row) : ?>
                                                                        <option value="<?= $row->serial ?>">CAIXA Nº <?= $row->id_caixa ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row text-center">
                                                    <div class="col-sm-2">
                                                        <label for="formaValor">VALOR</label>
                                                        <input name="valSelecionado" id="valSelecionado" value="0" hidden>
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
                                                        <label for="formaDocumento">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
                                                        <button type="submit" id="ReceberSubmit" class="btn btn-success" disabled="disabled" onclick="salvarPaymentReceber()">
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
                                            <div class="col-sm-12 invoice-info">
                                                <!-- Table row -->
                                                <div class="row">
                                                    <div class="col-12 table-responsive">
                                                        <table id="tablePagamentosPagar" class="table table-sm table-striped">
                                                            <thead style="text-align: center;">
                                                                <tr>
                                                                    <th>DATA</th>
                                                                    <th>VALOR</th>
                                                                    <th>FORMA</th>
                                                                    <th>DOCUMENTO</th>
                                                                    <th>USUARIO</th>
                                                                    <th class="no-print">ACÕES</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size: 12px; text-align: center;">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-sm-12 invoice-info">
                                                <div class="alert alert-danger alert-dismissible">
                                                    <h5><i class="icon fas fa-ban"></i> OPERAÇÃO NEGADA!</h5>
                                                    SÓ É PERMITIDO REALIZAR ESSA OPERAÇÃO COM UM CAIXA ABERTO.
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <pre>
        <?php var_dump($pagamentos) ?>
    </pre>
</section>

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        getClientesOption();
        getContasReceitaOption();
    });
</script>
<?= $this->endSection() ?>