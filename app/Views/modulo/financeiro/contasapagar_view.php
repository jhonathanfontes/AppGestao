<?= $this->extend('_layout/financeiro') ?>

<?= $this->section('view_content') ?>
<section class="content">
    <div class="card-body">
        <?php // var_dump($conta) ?>
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-8">
                    <h4>
                        <i class="fas fa-globe"></i> <?php // echo $empresa['emp_fantasia']; 
                                                        ?>
                        <small class="float-right"><?php // echo $pessoa->codigo 
                                                    ?></small>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-2">

                </div>
                <!-- /.col -->
            </div>

            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-5 invoice-col">
                    CONTA A PAGAR
                    <address>
                        <strong>
                            <?= isset($conta->des_fornecedor) ? ($conta->des_fornecedor) : '';  ?>
                        </strong><br>
                        <?= isset($conta->des_subgrupo) ? ($conta->des_subgrupo) : '';  ?> <br>
                        <?= isset($conta->referencia) ? ($conta->referencia) : '';  ?> <br>
                        <?= isset($conta->observacao) ? ($conta->observacao) : '';  ?>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                    <address>
                        <br>
                        Parcela:<strong> <?= isset($conta->parcela) ? ($conta->parcela) . '/' . ($conta->parcela_total) : ''; ?> </strong><br>
                        Vencimento:<strong> <?= isset($conta->vencimento) ? formatDataBR(esc($conta->vencimento)) : '';  ?></strong><br>
                        Valor:<strong> <?= isset($conta->valor) ? formatValorBR(esc($conta->valor)) : '';  ?></strong>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <?php if (esc($conta->saldo) <= 0 && esc($conta->quitado) != 'S') { ?>
                        <address>
                            <form method="post" action="<?php echo base_url(); ?>finish/contasapagar">
                                <input name="cod_pagar" value="<?= isset($conta->cod_pagar) ? ($conta->cod_pagar) : ''; ?>" hidden="hidden">
                                <input name="serial" value="<?= isset($conta->serial) ? ($conta->serial) : ''; ?>" hidden="hidden">
                                <button type="submit" class="form-control btn btn-warning"> <i class="fas "> </i> Finalizar</button>
                            </form>
                        </address>
                    <?php } else { ?>
                        <?php if (!empty($creditofinanceiro)) : ?>
                            <address>
                                <button class="form-control btn btn-warning" data-toggle="modal" data-target="#telaCredito"><i class="far fa-credit-card"></i> Usar Credito</button>
                            </address>
                        <?php endif ?>
                        <?php if (esc($conta->situacao) == 1) : ?>
                            <address>
                                <button class="form-control btn btn-dark " onclick="getCancelar( 'contapagar' , <?= isset($conta->cod_pagar) ? $conta->cod_pagar : null;  ?>)"><samp class="fa fa-archive"> </samp> CANCELAR CONTA</button>
                            </address>
                        <?php endif ?>
                    <?php } ?>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

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
            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                    <?php if (!empty($cancelamentos)) { ?>
                        <table class="table table-sm" style="color: red;">
                            <?php foreach ($cancelamentos as $row) : ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($row->data)) ?></td>
                                    <td><?php echo number_format($row->valor, 2, ',', '.') ?></td>
                                    <td><?php echo $row->motivo ?></td>
                                    <?php if ($conta->quitado != 'S') { ?>
                                        <td><button class="btn btn-sm btn-danger" onclick="DeletarCancelamento(<?php echo $row->codigo ?>);">Cancelar</button></td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php } ?>
                        </table>
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table table-sm" style="font-size: 13px;">
                            <?php if ($conta->cancelado <> 0) { ?>
                                <tr style="color: red;">
                                    <th>TOTAL CANCELADO</th>
                                    <td>R$ <?php echo number_format($conta->cancelado, 2, ',', '.') ?></td>
                                </tr>
                            <?php } ?>
                            <?php if ($conta->recebido <> 0) { ?>
                                <tr style="color: blue;">
                                    <th>TOTAL PAGO</th>
                                    <td>R$ <?php echo number_format($conta->recebido, 2, ',', '.') ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th>TOTAL A PAGAR</th>
                                <td>R$ <?php echo number_format(($conta->valor - ($conta->recebido + $conta->cancelado)), 2, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-12">
                    <?php if ($conta->quitado != "S") : ?>
                        <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-pagamento" style="margin-right: 5px;" <?php if (($conta->saldo <= 0) or empty($caixa)) {
                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                        } ?>><i class="far fa-credit-card"></i> Pagar Despesa </button>
                        <button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#modal-cancelamento" style="margin-right: 5px;" <?php if (($conta->saldo <= 0) or empty($caixa)) {
                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                            } ?>><i class="far fa-credit-card"></i> CANCELAR VALOR</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>



<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        getPagamentosContaPagar(<?= isset($conta->serial) ? "'" . esc($conta->serial) . "'" : '';  ?>, <?= isset($conta->cod_pagar) ? ($conta->cod_pagar) : '';  ?>);
    });
</script>
<?= $this->endSection() ?>