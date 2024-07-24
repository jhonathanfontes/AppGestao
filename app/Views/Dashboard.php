<?= $this->extend('_layout/dashboard') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">DASHBOARD</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>CADASTRO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
             <!-- ./col -->
             <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>PROJETOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?= base_url('app/projeto'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>VENDAS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?= base_url('app/venda'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>FINANCEIRO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/financeiro'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>RH</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="<?= base_url('app/rh'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>CONFIGURAÇÃO</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-settings"></i>
                    </div>
                    <a href="<?= base_url('app/configuracao'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>