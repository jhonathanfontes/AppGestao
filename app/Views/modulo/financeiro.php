<?= $this->extend('_layout/financeiro') ?>

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
                        <p>CONTAS A PAGAR</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro/contapagar'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>CONTAS A RECEBER</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro/contareceber'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <!-- /.row -->
       
        <h5 class="mt-4 mb-2">Auxiliar Financeiro</h5>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>GRUPO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro/auxiliar/grupo'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>SUBGRUPO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetags"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro/auxiliar/subgrupo'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>