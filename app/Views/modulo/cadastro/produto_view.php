<?= $this->extend('_layout/cadastro') ?>

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
                    if (isset($produto->status)) {
                        if ($produto->status == 1 or $produto->status == 2) { ?>
                            <button type="button" class="btn btn-xs btn-dark ml-2"
                                onclick="getArquivar( 'produto' , <?= isset($produto->cod_produto) ? $produto->cod_produto : null; ?>)"><samp
                                    class="fa fa-archive"></samp> ARQUIVAR</button>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- /.col -->
            </div>
            <?php // dd($produto) ?>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th style="width: 120px;">CODIGO</th>
                                <td><?= isset($produto->cod_produto) ? $produto->cod_produto : ''; ?></td>
                            </tr>
                            <tr>
                                <th>DESCRIÇÃO</th>
                                <td><?= isset($produto->cad_produto) ? $produto->cad_produto : 'CADASTRO NÃO LOCALIZADO!'; ?>
                                </td>
                            </tr>

                        </table>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th style="width: 170px;">TIPO</th>
                                <td><?= (isset($produto->cad_tipo) && $produto->cad_tipo == 1) ? 'PRODUTO' : 'SERVIÇO'; ?>
                                </td>
                            </tr>

                            <tr>
                                <th>CODIGO DE BARRAS</th>
                                <td><?= isset($produto->cad_codigobarras) ? $produto->cad_codigobarras : ''; ?></td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <address>
                        <table>
                            <tr>
                                <th style="width: 100px;">CATEGORIA</th>
                                <td><?= isset($produto->cod_categoria) ? $produto->cod_categoria . ' - ' . $produto->cad_categoria : ''; ?>
                                </td>
                            </tr>

                            <tr>
                                <th>SITUAÇÃO</th>
                                <td><?= isset($produto->status) ? convertStatus($produto->status) : ''; ?></td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</section>
<?php
if (isset($produto->status)) {
    if ($produto->status == 1 or $produto->status == 2) { ?>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card card-pink">
                <div class="card-header">
                    <h3 class="card-title">TAMANHOS DO PRODUTO:
                        <?= isset($produto->cad_produto) ? $produto->cad_produto : ''; ?></h3>
                    <button class="btn btn-sm btn-success float-right" data-toggle="modal"
                        data-target="#modalProdutoGrade"><samp class="fas fa-plus"> TAMANHO</button>
                </div>
                <div class="card-body">
                    <div class="form-group col-md-12">
                        <table id="tableProdutoGrade" class="table table-sm table-bordered table-striped"
                            style="text-align: center;">
                            <thead>
                                <th>TAMANHO</th>
                                <?php if (1 == 1): ?>
                                    <th>VALOR CUSTO</th>
                                <?php endif; ?>
                                <th>VENDA A VISTA</th>
                                <th>VENDA A PRAZO</th>
                                <th>ESTOUE</th>
                                <th>SITUAÇÃO</th>
                                <?php if (/*$this->session->userdata('jb_permissao')*/ 1 == 1): ?>
                                    <th>AÇÃO</th>
                                <?php endif; ?>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
        <?php
    }
}
?>
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once ('componentes/produtograde_modal.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function () {
        tableProdutoGrade(<?= $produto->cod_produto; ?>);
        getProdutoGradeSelecionado(<?= $produto->cod_produto; ?>);
    });
</script>
<?= $this->endSection() ?>