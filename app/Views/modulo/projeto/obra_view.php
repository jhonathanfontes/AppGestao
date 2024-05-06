<?= $this->extend('_layout/projeto') ?>

<?= $this->section('content_card') ?>

<!-- Main content-header -->
<section class="content-header">
    <div class="container-fluid">
        <h5 class="text-sm font-weight">ADICIONAR NOVO CADASTRO</h5>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalLocal" onclick="setNewLocal()">
                <i class="fas fa-warehouse"></i></i> LOCAL
            </button>
        </div>
    </div>
    <!-- /.card -->
</section>

<?= $this->endSection() ?>

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
                        <small class="float-right"><?php // echo $pessoa->codigo 
                        ?></small>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-2">
                    <?php
                    if (isset($pessoa->status)) {
                        if ($pessoa->status == 1 or $pessoa->status == 2) { ?>
                            <button type="button" class="btn btn-xs btn-dark ml-2"
                                onclick="getArquivar( 'pessoa' , <?= isset($pessoa->cod_pessoa) ? $pessoa->cod_pessoa : null; ?>)"><samp
                                    class="fa fa-archive"></samp> ARQUIVAR</button>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <table>
                            <tr style="width: 40px;">
                                <th>OBRA</th>
                                <td><?= isset($pessoa->cad_nome) ? $pessoa->cad_nome : 'CADASTRO NÃO LOCALIZADO!'; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>PREVISÃO INICIO</th>
                                <td><?= isset($pessoa->cad_apelido) ? $pessoa->cad_apelido : ''; ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
                <!-- <div class="col-sm-4 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                        </table>
                    </address>
                </div> -->
                <!-- /.col -->
                <div class="col-sm-8 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th style="width: 30px;">ENDEREÇO</th>
                                <td>
                                    <?= isset($pessoa->cad_endereco) ? $pessoa->cad_endereco : ''; ?>
                                    <?= (isset($pessoa->cad_endereco) && !empty($pessoa->cad_numero)) ? ' Nº ' . $pessoa->cad_numero : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>BAIRO/SETOR</th>
                                <td><?= isset($pessoa->cad_setor) ? $pessoa->cad_cep : ''; ?></td>
                            </tr>
                            <tr>
                                <th>CIDADE</th>
                                <td>
                                    <?= isset($pessoa->cad_cidade) ? $pessoa->cad_cidade : ''; ?>
                                    <?= (isset($pessoa->cad_cidade) && !empty($pessoa->cad_estado)) ? ' - ' . $pessoa->cad_estado : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>CEP</th>
                                <td><?= isset($pessoa->cad_cep) ? $pessoa->cad_cep : ''; ?></td>
                            </tr>
                            <!-- <tr>
                                <th>SITUAÇÃO</th>
                                <td><?= isset($pessoa->status) ? convertStatus($pessoa->status) : ''; ?></td>
                            </tr> -->
                        </table>
                    </address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</section>

<?php if (!empty($vendas)): ?>
    <section class="content">
        <!-- Default box -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><?php // echo $titulo; 
                    ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablePessoaCompras" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th>DATA</th>
                                <th>VENDA</th>
                                <th>PEÇAS</th>
                                <th>VALOR BRUTO</th>
                                <th>DESCONTO</th>
                                <th>VALOR LIQUIDO</th>
                                <th>DEVOLUÇÃO</th>
                                <th>VENDEDOR</th>
                                <th class="no-print">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($vendas)): ?>
                                <?php $sequencia = 1; ?>
                                <?php foreach ($vendas as $row): ?>
                                    <tr style="text-align: center;">
                                        <td><?= date("d/m/Y", strtotime($row->data_compra)) ?></td>
                                        <td><?= $row->cod_venda . '/' . date("Y", strtotime($row->data_compra)) ?></td>
                                        <td><?= $row->qtn_produto ?></td>
                                        <td><?= "R$ " . number_format($row->valor_bruto, 2, ',', '.') ?></td>
                                        <td><?= "R$ " . number_format($row->valor_desconto, 2, ',', '.') ?></td>
                                        <td><?= "R$ " . number_format($row->valor_total, 2, ',', '.') ?></td>
                                        <td><?= $row->qtn_devolvido ?></td>
                                        <td><?= $row->usuario ?></td>
                                        <td class="text-right no-print">
                                            <a href="<?php // echo base_url(); 
                                                        ?>report/consultarvenda/<?php // echo $row->serial 
                                                                    ?>" class="btn btn-xs btn-primary"><span
                                                    class="far fa-eye"></span> VISUALIZAR</a>
                                        </td>
                                    </tr>
                                    <?php $sequencia++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- /.content -->
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>

<?= $this->endSection() ?>