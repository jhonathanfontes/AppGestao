<?= $this->extend('_layout/configuracao') ?>

<?= $this->section('view_content') ?>
<!-- Main content-header -->
<section class="content-header">
    <div class="container-fluid">
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>EMPRESAS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/empresas'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>PARAMETRO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/parametro'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <h5 class="mt-4 mb-2">GERENCIAR USUARIOS</h5>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>USUARIOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/gerenciar/usuarios'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>GRUPOS DE ACESSO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetags"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/gerenciar/gruposdeacesso'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.container-fluid -->

        <h5 class="mt-4 mb-2">AUXILIAR FINANCEIRO</h5>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>BANCOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/auxiliar/financeiro/bancos'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
       
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>CONTAS BANCARIAS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetags"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/auxiliar/financeiro/contasbancarias'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>FORMAS DE PAGAMENTOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/auxiliar/financeiro/formaspagamentos'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.container-fluid -->

        <h5 class="mt-4 mb-2">AUXILIAR VENDA</h5>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>VENDEDORES</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao/auxiliar/venda/vendedores'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>