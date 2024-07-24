<?= $this->extend('_layout/rh') ?>

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
        <h5 class="mt-4 mb-2">GERENCIAMENTO DE RH</h5>
        <div class="row">
            <!-- Small boxes (Stat box) -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>COLABORADOR</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/rh/colaborador'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- <h5 class="mt-4 mb-2">GERENCIAMENTO DAS VENDAS\SERVIÇOS</h5>
        <div class="row">
            <div class="col-lg-2 col-4">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>ORÇAMENTO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/venda/orcamento'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-4">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>CANCELAMENTO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/venda/cancelamento'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-4">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>DEVOLUÇÃO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/venda/devolucao'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div> -->
<!-- 
        <h5 class="mt-4 mb-2">GERENCIAMENTO DO CAIXA</h5>
        <div class="row">
            <div class="col-lg-2 col-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <p>CAIXA</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/caixa'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div> -->

        <!-- <h5 class="mt-4 mb-2">AUXILIAR NO FINANCEIRO</h5>
        <div class="row">
            <div class="col-lg-2 col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>GRUPO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro/auxiliar/grupo'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>SUBGRUPO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetags"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro/auxiliar/subgrupo'); ?>" class="small-box-footer"> ACESSAR <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>