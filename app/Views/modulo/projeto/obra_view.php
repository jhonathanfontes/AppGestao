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
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalLocal"
                onclick="setNewLocal(<?= isset($obra->cod_obra) ? $obra->cod_obra : ''; ?>)" <?= !isset($obra->cod_obra) ? 'disabled' : ''; ?>>
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
                                <td><?= isset($obra->cod_obra) ? $obra->cod_obra : 'CADASTRO NÃO LOCALIZADO!'; ?>
                                </td>
                            </tr>
                            <tr style="width: 40px;">
                                <th>OBRA</th>
                                <td><?= isset($obra->cad_obra) ? $obra->cad_obra : 'CADASTRO NÃO LOCALIZADO!'; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>PREVISÃO INICIO</th>
                                <td><?= isset($obra->cad_datainicio) ? date("d/m/Y", strtotime($obra->cad_datainicio)) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>'; ?>
                                </td>
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
                                    <?= isset($obra->cad_endereco) ? $obra->cad_endereco : ''; ?>
                                    <?= (isset($obra->cad_endereco) && !empty($obra->cad_numero)) ? ', Nº ' . $obra->cad_numero : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>BAIRO/SETOR</th>
                                <td><?= isset($obra->cad_setor) ? $obra->cad_cep : ''; ?></td>
                            </tr>
                            <tr>
                                <th>CIDADE</th>
                                <td>
                                    <?= isset($obra->cad_cidade) ? $obra->cad_cidade : ''; ?>
                                    <?= (isset($obra->cad_cidade) && !empty($obra->cad_estado)) ? ' - ' . $obra->cad_estado : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>CEP</th>
                                <td><?= isset($obra->cad_cep) ? $obra->cad_cep : ''; ?></td>
                            </tr>
                            <!-- <tr>
                                <th>SITUAÇÃO</th>
                                <td><?= isset($obra->status) ? convertStatus($obra->status) : ''; ?></td>
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

<?php // var_dump($obra); ?>

<?php if (!empty($locais)): ?>
    <section class="content">
        <!-- Default box -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><?= isset($card_title) ? $card_title : ''; ?></h3>
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
                                <th>SEQUENCIA</th>
                                <th>LOCAL</th>
                                <th>DATA PREVISTA</th>
                                <th class="no-print">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($locais)): ?>
                                <?php $sequencia = 1; ?>
                                <?php foreach ($locais as $row): ?>
                                    <tr style="text-align: center;">
                                        <td><?= esc($sequencia) ?></td>
                                        <td><?= esc($row->cad_local) ?></td>
                                        <td><?= esc($row->cad_datainicio) ? date("d/m/Y", strtotime($row->cad_datainicio)) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>' ?>
                                        </td>
                                        <td class="text-right no-print" style="width: 15%;">
                                            <button type="button" class="btn btn-xs btn-warning" data-toggle="modal"
                                                data-target="#modalLocal" onclick="getEditLocal(<?= $row->cod_local ?>)"><samp
                                                    class="far fa-edit"></samp> EDITAR</button>
                                            <a class="btn btn-xs btn-success" href="obra/view/"><span class="fas fa-tasks"></span>
                                                GERENCIAR </a>
                                        </td>
                                    </tr>
                                    <?php $sequencia++; ?>
                                <?php endforeach; ?>
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
<?php require_once ('componentes/local_modal.php'); ?>
<?= $this->endSection() ?>