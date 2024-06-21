<?= $this->extend('_layout/projeto') ?>
<?= $this->section('stylesheet_css') ?>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 10px;
    }

    .flex-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    img {
        max-width: 200px;
        margin-bottom: 10px;
    }

    .logotipo img {
        width: 100%;
        max-width: 150px;
        /* Define a largura máxima em pixels */
        margin-bottom: 20px;
    }

    .cabecario {
        width: 100%;
        margin-bottom: 10px;
    }

    h1,
    h2,
    p {
        margin: 5px;
    }

    hr {
        margin-top: 5px;
        margin-bottom: 10px;
        border: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    tr,
    th,
    td {

        padding: 3px;
    }

    .local-section {
        margin: 10px 0;
        /* Adiciona margem acima e abaixo da seção */
    }

    .local-section span {
        margin: 10px 0;
        /* Adiciona margem acima e abaixo da seção */
    }

    #footer {
        margin-top: 10px;
        text-align: center;
        font-size: 10px;
        color: #777;
    }
</style>
<?= $this->endSection() ?>
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

        </div>
    </div>
    <!-- /.card -->
</section>

<?= $this->endSection() ?>

<?= $this->section('view_content') ?>

<!-- Main content -->
<section class="content">
    <!-- Card Body - Formulario -->
    <div class="card card-warning">
        <?php // var_dump($obra['local'][0]['detalhes']) ?>
        <div class="card-body">
            <div class="invoice p-3 mb-3">
                <div class="container">

                    <div class="flex-row">
                        <div class="logotipo">
                            <img src="<?= site_url('dist/img/' . dadosEmpresa()->emp_icone); ?>"
                                alt="Logotipo da Empresa">
                        </div>
                        <div class="cabecario">
                            <hr>
                            <div>
                                <h2>R. D. J. TECNOLOGIA LTDA.</h2>
                                <p> Endereço: [Endereço da Empresa]<br>
                                    Telefone: [Telefone da Empresa]<br>
                                    E-mail: [E-mail da Empresa]<br>
                                    Website: [Website da Empresa]</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h3 style="text-align: center;">RELATÓRIO DE VENDAS</h3>
                <hr>
                <h4>Dados do Cliente</h4>

                <div>
                    <table class="table table-responsive-sm table-striped table-bordered">
                        <tr>
                            <th style="width: 20%;">Nome do Cliente:</th>
                            <td>[Nome do Cliente]</td>
                        </tr>
                        <tr>
                            <th>Endereço:</th>
                            <td>[Endereço do Cliente]</td>
                        </tr>
                        <tr>
                            <th>Telefone:</th>
                            <td>[Telefone do Cliente]</td>
                        </tr>
                        <tr>
                            <th>E-mail:</th>
                            <td>[E-mail do Cliente]</td>
                        </tr>
                    </table>
                </div>

                <div class="row">
                    <div class="col-12">
                        <!-- Table row -->
                        <div class="col-12 table-responsive">
                            <?php if (!empty($obra['local'])): ?>
                                <?php foreach ($obra['local'] as $row): ?>
                                    <?php if (!empty($row['detalhes'])): ?>
                                        <div class="local-section">
                                            <h5><?= isset($row['cod_local']) ? $row['cod_local'] . ' - ' . $row['cad_local'] : 'LOCAL NÃO INFORMADO!'; ?>
                                            </h5>
                                            <span>PREVISÃO:
                                                <?= isset($row['cad_datainicio']) ? date("d/m/Y", strtotime($row['cad_datainicio'])) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>'; ?></span>
                                            <br>
                                            <span>OBSERVAÇÃO:
                                                <?= isset($row['cad_observacao']) ? $row['cad_observacao'] : 'SEM OBSERVAÇÃO'; ?></span>
                                        </div>
                                        <hr>
                                        <div>
                                            <table class="table table-sm table-striped table-bordered">
                                                <thead style="text-align: center;">
                                                    <tr>
                                                        <th colspan="6" style="text-align: left;">PRODUTOS</th>
                                                    </tr>
                                                    <tr>
                                                        <th>CODIGO</th>
                                                        <th>DESCRIÇÃO DO PRODUTO</th>
                                                        <th>TAMANHO</th>
                                                        <th>QUANTIDADE</th>
                                                        <th>PREÇO UNITÁRIO</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    <?php
                                                    $sumQuantidadeProduto = 0;
                                                    $sumTotalProduto = 0;
                                                    $countProduto = 0;
                                                    foreach ($row['detalhes'] as $detalhe):
                                                        if (!empty($detalhe->pro_tipo) && $detalhe->pro_tipo == 1):
                                                            $sumQuantidadeProduto += $detalhe->qtn_produto;
                                                            $sumTotalProduto += $detalhe->val1_total;
                                                            ?>
                                                            <tr>
                                                                <td><?= $detalhe->produto_id; ?></td>
                                                                <td style="text-align: justify;"><?= $detalhe->pro_descricao; ?></td>
                                                                <td><?= $detalhe->tam_descricao; ?></td>
                                                                <td><?= $detalhe->qtn_produto; ?></td>
                                                                <td><?= $detalhe->val1_unad; ?></td>
                                                                <td><?= formatValorBR($detalhe->val1_total); ?></td>
                                                            </tr>
                                                            <?php
                                                            $countProduto++;
                                                        endif;
                                                    endforeach;
                                                    if ($countProduto == 0):
                                                        ?>
                                                        <tr style="text-align: center;">
                                                            <td colspan="6">NÃO FOI INCLUIDO PRODUTO PARA ESSE ORÇAMENTO</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($sumQuantidadeProduto > 0 || $sumTotalProduto > 0): ?>
                                                        <tr style="text-align: center;">
                                                            <th style="text-align: left;">Total Produtos:</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th><?= $sumQuantidadeProduto; ?></th>
                                                            <th></th>
                                                            <th><?= formatValorBR($sumTotalProduto); ?></th>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                                <thead style="text-align: center;">
                                                    <tr>
                                                        <th colspan="6" style="text-align: left;">SERVICOS</th>
                                                    </tr>
                                                    <tr>
                                                        <th>CODIGO</th>
                                                        <th>DESCRIÇÃO DO SERVIÇO</th>
                                                        <th>TAMANHO</th>
                                                        <th>QUANTIDADE</th>
                                                        <th>PREÇO UNITÁRIO</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    <?php
                                                    $sumQuantidadeServico = 0;
                                                    $sumTotalServico = 0;
                                                    $countServico = 0;
                                                    foreach ($row['detalhes'] as $detalhe):
                                                        if (!empty($detalhe->pro_tipo) && $detalhe->pro_tipo == 2):
                                                            $sumQuantidadeServico += $detalhe->qtn_produto;
                                                            $sumTotalServico += $detalhe->val1_total;
                                                            ?>
                                                            <tr>
                                                                <td><?= $detalhe->produto_id; ?></td>
                                                                <td style="text-align: justify;"><?= $detalhe->pro_descricao; ?></td>
                                                                <td><?= $detalhe->tam_descricao; ?></td>
                                                                <td><?= $detalhe->qtn_produto; ?></td>
                                                                <td><?= $detalhe->val1_unad; ?></td>
                                                                <td><?= formatValorBR($detalhe->val1_total); ?></td>
                                                            </tr>
                                                            <?php
                                                            $countServico++;
                                                        endif;
                                                    endforeach;
                                                    if ($countServico == 0):
                                                        ?>
                                                        <tr style="text-align: center;">
                                                            <td colspan="6">NÃO FOI INCLUIDO SERVIÇO PARA ESSE ORÇAMENTO</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                                <tfoot>
                                                    <?php if ($sumQuantidadeServico > 0 || $sumTotalServico > 0): ?>
                                                        <tr style="text-align: center;">
                                                            <th style="text-align: left;">Total Serviço:</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th><?= $sumQuantidadeServico; ?></th>
                                                            <th></th>
                                                            <th><?= formatValorBR($sumTotalServico); ?></th>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <th colspan="5">TOTAL GERAL -
                                                            <?= isset($row['cod_local']) ? $row['cod_local'] . ' - ' . $row['cad_local'] : 'LOCAL NÃO INFORMADO!'; ?>
                                                        </th>
                                                        <th style="text-align: center;">
                                                            <?= formatValorBR($sumTotalProduto + $sumTotalServico); ?>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>VALOR TOTAL DA OBRA</th>
                                            <th style="width: 20%; text-align: right;">R$ 59.000,00</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- this row will not appear when printing -->

            </div>
        </div>
        <!-- Card Body - Tabela -->


        <hr>
        <div id="footer">
            <p>Este relatório é uma representação dos dados disponíveis até a data de emissão. Qualquer informação
                adicional
                pode ser obtida entrando em contato conosco.</p>
            <p>R. D. J. TECNOLOGIA LTDA. | Endereço: [Endereço da Empresa] | Telefone: [Telefone da Empresa] | E-mail:
                [E-mail da Empresa] | Website: [Website da Empresa]</p>
        </div>

    </div>
</section>
<!-- /.content -->

<!-- /.content -->
<?= $this->endSection() ?>