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
            <button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalProduto" onclick="setNewProduto()">
                <i class="fa fa-tshirt"></i> PRODUTO
            </button>
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalCategoria" onclick="setNewCategoria()">
                <i class="fa fa-tag"></i> CATEGORIA
            </button>
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalSubCategoria" onclick="setNewSubCategoria()">
                <i class="fa fa-tags"></i> SUBCATEGORIA
            </button>
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalFabricante" onclick="setNewFabricante()">
                <i class="fa fa-briefcase"></i> FABRICANTE
            </button>
            <button class="btn btn-app bg-info" data-toggle="modal" data-target="#modalTamanho" onclick="setNewTamanho()">
                <i class="fa fa-ruler"></i> TAMANHO
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
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= isset($card_title) ? $card_title : ''; ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <table id="tableProdutos" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr style="text-align: center;">
                        <th>Codigo</th>
                        <th>Descrição</th>
                        <th>Descrição PDV</th>
                        <th>Subcategoria</th>
                        <th>Fabricante</th>
                        <th>Estoque</th>
                        <th>Status</th>
                        <th>Acões</th>
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
<?php require_once('componentes/produto_modal.php'); ?>
<?php require_once('componentes/categoria_modal.php'); ?>
<?php require_once('componentes/subcategoria_modal.php'); ?>
<?php require_once('componentes/fabricante_modal.php'); ?>
<?php require_once('componentes/tamanho_modal.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {

        $("#pro_categoria").on("change", function() {
            var pro_categoria = $(this).val();

            getProdutoSubcategoriaOption(pro_categoria);
            
            selectedSubcategoria();
        });

        getProdutoFabricanteOption();

        getCategoriaOption();

    });
</script>
<?= $this->endSection() ?>