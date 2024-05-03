<?= $this->extend('_layout/cadastro') ?>

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
            <button class="btn btn-app <?= getenv('tema.btn.app1.color'); ?>" data-toggle="modal" data-target="#modalProduto"
                onclick="setNewServico()">
                <i class="fa fa-tshirt"></i> SERVIÇO
            </button>

            <button class="btn btn-app <?= getenv('tema.btn.app2.color'); ?>" data-toggle="modal" data-target="#modalTamanho"
                onclick="setNewTamanho()">
                <i class="fa fa-ruler"></i> UNIDADE MEDIDA
            </button>
        </div>
    </div>
    <!-- /.card -->
</section>

<?= $this->endSection() ?>

<?= $this->section('view_content') ?>

<!-- /.content -->
<section class="content">
    <!-- Default box -->
    <div class="card <?= getenv('tema.modal.header.color'); ?>">
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
            <table id="tableServicos" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th>CODIGO</th>
                        <th>DESCRIÇÃO</th>
                        <th>CATEGORIA</th>
                        <th>TAMANHO</th>
                        <th><?= !empty(getenv('tela.valor1')) ? getenv('tela.valor1') : 'VALOR 1'; ?></th>
                        <th><?= !empty(getenv('tela.valor2')) ? getenv('tela.valor2') : 'VALOR 2'; ?></th>
                        <th>SITUAÇÃO</th>
                        <?php if (/*$this->session->userdata('jb_permissao')*/ 1 == 1): ?>
                            <th style="width: 15%;">AÇÕES</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody style="font-size: 12px;">

                </tbody>
            </table>
        </div>
    </div>

</section>

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once ('componentes/produto_modal.php'); ?>
<?php require_once ('componentes/categoria_modal.php'); ?>
<?php require_once ('componentes/tamanho_modal.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
     $(document).ready(function () {
        getProdutoCategoriaOption();
        getProdutoTamanhoOption();
    });
</script>
<?= $this->endSection() ?>