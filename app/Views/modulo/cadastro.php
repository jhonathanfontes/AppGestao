<?= $this->extend('_layout/cadastro') ?>

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
                        <p>PESSOAS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/pessoas'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>PRODUTOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-tshirt"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/produtos'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>SERVIÇOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-tshirt"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/servicos'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <h5 class="mt-4 mb-2">Auxiliar Pessoas</h5>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>PROFISSÕES</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-hammer"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/auxiliar/pessoas/profissoes'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div><!-- /.container-fluid -->
        <h5 class="mt-4 mb-2">Auxiliar Produtos</h5>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>CATEGORIAS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/auxiliar/produtos/categorias'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>SUBCATEGORIAS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetags"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/auxiliar/produtos/subcategorias'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>FABRICANTES</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-briefcase"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/auxiliar/produtos/fabricantes'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>TAMANHOS</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-edit"></i>
                    </div>
                    <a href="<?= base_url('app/cadastro/auxiliar/produtos/tamanhos'); ?>" class="small-box-footer"> ACESSAR <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>