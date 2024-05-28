<?= $this->extend('_layout/configuracao') ?>

<?= $this->section('view_content') ?>
<!-- /.content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title">
                <?= isset($card_title) ? $card_title : ''; ?>
            </h3>
        </div>
        <div class="card-body">
            <? var_dump($empresas); ?>
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">Nina Mcintire</h3>

                            <p class="text-muted text-center">Configurações Padrão</p>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#configuracao" data-toggle="tab"> Configurações</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="configuracao">
                                    <p class="text-muted text-center">Configurações Padrão</p>
                                    <form class="form-horizontal">
                                        <div class="form-group row post clearfix">
                                            <label for="inputEmpresa" class="col-sm-2 col-form-label">Empresa</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2bs4" style="width: 100%;"
                                                    name="cod_empresa" id="cod_empresa">
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group row post">
                                            <label for="inputCliente" class="col-sm-2 col-form-label">Cliente</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2bs4" style="width: 100%;"
                                                    name="cod_pessoa" id="cod_pessoa">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row post">
                                            <label for="inputSubGrupoVenda"
                                                class="col-sm-2 col-form-label">Venda</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2bs4" style="width: 100%;"
                                                    name="cod_subgrupo" id="cod_subgrupo">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row post">
                                            <label for="inputSubGrupoFolhaPagamento"
                                                class="col-sm-2 col-form-label">Folha de
                                                Pagamento</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2bs4" style="width: 100%;"
                                                    name="codSubGrupoFolhaPagamento" id="codSubGrupoFolhaPagamento">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">SALVAR</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php // require_once('componentes/categoria_modal.php'); 
?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function () {
        getEmpresasOption();
        getClientesOption();
        getContasReceitaOption();
    });
</script>
<?= $this->endSection() ?>