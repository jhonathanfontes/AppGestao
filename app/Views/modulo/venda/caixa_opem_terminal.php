<?= $this->extend('_layout/venda') ?>

<?= $this->section('content_card') ?>
<?php // var_dump($caixa) 
?>

<!-- Main content -->
<section class="content">
	<!-- Default box -->

	<?php if (isset($caixa->id_caixa) && $caixa->situacao === 'A') : ?>

		<div class="card card-pink">
			<div class="card-header">
				<h2 class="card-title">CAIXA Nª
					<?= (isset($caixa->id_caixa)) ? esc($caixa->id_caixa) : 'CAIXA NÃO LOCALIZADO'; ?></h2>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body">
				<button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalCaixaSuplmento">
					<i class="fa fa-money-bill-alt"></i> SUPLEMENTO
				</button>
				<button class="btn btn-app bg-orange" data-toggle="modal" data-target="#modalCaixaSangria">
					<i class="fa fa-hand-holding-usd"></i> SANGRIA
				</button>
				<button class="btn btn-app bg-danger" data-toggle="modal" data-target="#modalCaixaFechar">
					<i class="fa fa-cash-register"></i> FECHAR CAIXA
				</button>
			</div>
		</div>

	<?php endif; ?>
	<!-- /.card -->
</section>

<?= $this->endSection() ?>

<?= $this->section('view_content') ?>
<!-- /.content -->
<section class="content">
	<!-- Card Body - Formulario -->
	<?php if (!empty($a_receber)) : ?>
		<?php if (isset($caixa->id_caixa) && $caixa->situacao === 'A') : ?>
			<div class="card card-pink">
				<div class="card-header">
					<h3 class="card-title">VENDAS A RECEBER</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-sm">
							<thead style="font-size: 12px;">
								<tr style="text-align: center;">
									<th>VENDA</th>
									<th>CLIENTE</th>
									<th>VENDEDOR</th>
									<th>VALOR</th>
									<th>ACÕES</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($a_receber as $venda) : ?>
									<tr>
										<td style="text-align: center;"><?= $venda->cod_venda ?></td>
										<td style="text-align: center;"><?= $venda->pessoa ?></td>
										<td style="text-align: center;"><?= $venda->usuario ?></td>
										<td style="text-align: center;"><?= number_format($venda->valor_total, 2, ',', '.') ?></td>
										<td width="150" style="text-align: center;">
											<!-- <button class="btn btn-xs btn-danger mr-2" data-toggle="modal" data-target="#modalReceberVenda" onclick="getReceberVenda('<?= $venda->serial ?>')">
												<samp class="far fa-edit"></samp> RECEBER </button> -->
											<a href="<?= base_url('app/caixa/receber/' . $venda->serial); ?>" class="btn btn-primary btn-xs">
												<samp class="far fa-edit"></samp> RECEBER </a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<!-- FIM DAS VENDAS A RECEBER -->
	<div class="card card-pink">
		<div class="card-body">
			<div class="row">
				<div class="col-4">
					<address>
						Codigo Caixa :
						<strong><?= (isset($caixa->id_caixa)) ? esc($caixa->id_caixa) : 'CAIXA NÃO LOCALIZADO'; ?></strong><br>
					</address>
				</div>
				<div class="col-4">
					<address>
						Aberto por: <strong>
							<?= (isset($caixa->use_abertura)) ? esc($caixa->use_abertura) : 'CAIXA NÃO LOCALIZADO'; ?></strong>
					</address>
				</div>
				<div class="col-4">
					<address>
						Aberto em : <strong>
							<?= (isset($caixa->cai_abertura_data)) ? formatDataTimeBR($caixa->cai_abertura_data) : 'CAIXA NÃO LOCALIZADO'; ?></strong>
					</address>
				</div>
			</div>
		</div>
		<div class="card-body">
			<label>RESUMO/MOVIMENTAÇÃO</label>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-sm">
					<thead style="font-size: 12px;">
						<tr style="text-align: center;">
							<th>SALDO INICIAL</th>
							<th>SUPLEMENTAÇÃO</th>
							<th>VENDAS</th>
							<th>RECEBIMENTOS</th>
							<th>SANGRIAS</th>
							<th>PAGAMENTOS</th>
							<th>SALDO ATUAL</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($res_movimento)) : ?>
							<tr>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format($res_movimento->saldo_inicial, 2, ',', '.') ?></td>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format($res_movimento->suplemento, 2, ',', '.') ?></td>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format($res_movimento->vendas, 2, ',', '.') ?></td>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format($res_movimento->recebimentos, 2, ',', '.') ?></td>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format($res_movimento->sagria, 2, ',', '.') ?></td>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format($res_movimento->pagamentos, 2, ',', '.') ?></td>
								<td style="text-align: center;">
									<?= 'R$ ' . number_format(($res_movimento->saldo_inicial + $res_movimento->suplemento + $res_movimento->vendas + $res_movimento->recebimentos) - ($res_movimento->sagria + $res_movimento->pagamentos), 2, ',', '.') ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php if (!empty($movimentacoes)) : ?>
			<!-- Card Body - Tabela -->
			<div class="card-body">
				<label>LANÇAMENTOS</label>
				<div class="table-responsive">
					<table class="table table-sm table-bordered table-striped" style="font-size: 14px;">
						<thead>
							<tr style="text-align: center;">
								<th style="width: 20%;">LANÇAMENTO</th>
								<th>ENTRADAS</th>
								<th>SAIDAS</th>
								<th>DOCUMENTO</th>
								<?php if (isset($caixa->id_caixa) && $caixa->situacao === 'A') : ?>
									<th class="no-print">ACÕES</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($movimentacoes as $row) : ?>
								<?php
								if ($row->caixa_tipo = 1) {
									$sum_movimento['suplemento'] = $sum_movimento['suplemento'] + $row->supl_valor;
								}
								if ($row->caixa_tipo = 2) {
									$sum_movimento['sangria'] = $sum_movimento['sangria'] + $row->sang_valor;
								}
								?>
								<tr>
									<td style="text-align: justify; font-size: 13px;"><?= $row->descricao ?></td>
									<td style="text-align: center;">
										<?= ($row->supl_valor != null) ? 'R$ ' . number_format($row->supl_valor, 2, ',', '.') : ''; ?>
									</td>
									<td style="text-align: center;">
										<?= ($row->sang_valor != null) ? 'R$ ' . number_format($row->sang_valor, 2, ',', '.') : ''; ?>
									</td>
									<td style="text-align: justify; font-size: 13px;"><?= $row->documento ?></td>
									<?php if (isset($caixa->id_caixa) && $caixa->situacao === 'A') : ?>
										<td style="text-align: center;" class="no-print">
											<button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#cancelarMovimento" onclick="cancelar('<?= $row->codigo ?>')">
												<samp class="far fa-edit"></samp> Cancelar </button>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
							<tr>
								<th>TOTAL</th>
								<th style="text-align: center;">
									<?= 'R$ ' . number_format($sum_movimento['suplemento'], 2, ',', '.'); ?></th>
								<th style="text-align: center;">
									<?= 'R$ ' . number_format($sum_movimento['sangria'], 2, ',', '.'); ?></th>
								<th></th>
								<?php if (isset($caixa->id_caixa) && $caixa->situacao === 'A') : ?>
									<th class="no-print"></th>
								<?php endif; ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif; ?>
		<!-- Card Body - Tabela -->
		<?php if (!empty($res_venda) or !empty($res_devolucao) or !empty($res_retirada)) : ?>
			<div class="card-body">
				<label style="color: blue">VENDAS / DEVOLUÇÃO </label>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm">
						<thead style="font-size: 12px;">
							<tr style="text-align: center;">
								<th>ORIGEM</th>
								<th>DINHEIRO</th>
								<th>TRANSFERENCIA</th>
								<th>CARTÃO DEBITO</th>
								<th>CARTÃO CREDITO</th>
								<th>BOLETO</th>
								<th>CREDITO FINANCEIRO</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>

							<?php foreach ($res_venda as $row) : ?>
								<?php
								$sum_vendas['dinheiro']           = $sum_vendas['dinheiro'] + $row->dinheiro;
								$sum_vendas['transferencia']      = $sum_vendas['transferencia'] + $row->transferencia;
								$sum_vendas['debito']             = $sum_vendas['debito'] + $row->debito;
								$sum_vendas['credito']            = $sum_vendas['credito'] + $row->credito;
								$sum_vendas['boleto']             = $sum_vendas['boleto'] + $row->boleto;
								$sum_vendas['creditofinanceiro']  = $sum_vendas['creditofinanceiro'] + $row->creditofinanceiro;
								?>
								<tr>
									<td style="text-align: justify; font-size: 12px;"> VENDA <?= $row->cod_venda ?> -
										<?= abreviaNome(esc($row->pessoa)); ?></td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->dinheiro, 2, ',', '.') ?>
									</td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format($row->transferencia, 2, ',', '.') ?></td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->debito, 2, ',', '.') ?></td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->credito, 2, ',', '.') ?>
									</td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->boleto, 2, ',', '.') ?></td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format($row->creditofinanceiro, 2, ',', '.') ?></td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format(($row->dinheiro + $row->transferencia + $row->debito + $row->credito + $row->boleto + $row->creditofinanceiro), 2, ',', '.') ?>
									</td>
								</tr>
							<?php endforeach; ?>

							<?php foreach ($res_devolucao as $row) : ?>
								<?php
								$sum_vendas['creditofinanceiro']  = $sum_vendas['creditofinanceiro'] + ($row->total * -1);
								?>
								<tr style="color: red;">
									<td style="text-align: justify; font-size: 12px;"> DEVOLUÇÃO VENDA <?= $row->cod_venda ?> -
										<?= abreviaNome(esc($row->cad_pessoa)); ?></td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format(($row->total * -1), 2, ',', '.') ?></td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format(($row->total * -1), 2, ',', '.') ?></td>
								</tr>
							<?php endforeach; ?>

							<?php foreach ($res_retirada as $row) : ?>
								<?php
								$sum_vendas['dinheiro']           = $sum_vendas['dinheiro'] + $row->dinheiro;
								$sum_vendas['transferencia']      = $sum_vendas['transferencia'] + $row->transferencia;
								$sum_vendas['debito']             = $sum_vendas['debito'] + $row->debito;
								$sum_vendas['credito']            = $sum_vendas['credito'] + $row->credito;
								$sum_vendas['boleto']             = $sum_vendas['boleto'] + $row->boleto;
								$sum_vendas['creditofinanceiro']  = $sum_vendas['creditofinanceiro'] + $row->creditofinanceiro;
								?>
								<tr>
									<td style="text-align: justify; font-size: 13px;"> RETIRADA <?= $row->cod_retirada ?> -
										<?= abreviaNome(esc($row->pessoa)); ?></td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->dinheiro, 2, ',', '.') ?>
									</td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format($row->transferencia, 2, ',', '.') ?></td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->debito, 2, ',', '.') ?></td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->credito, 2, ',', '.') ?>
									</td>
									<td style="text-align: center;"><?= 'R$ ' . number_format($row->boleto, 2, ',', '.') ?></td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format($row->creditofinanceiro, 2, ',', '.') ?></td>
									<td style="text-align: center;">
										<?= 'R$ ' . number_format(($row->dinheiro + $row->transferencia + $row->debito + $row->credito + $row->boleto + $row->creditofinanceiro), 2, ',', '.') ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<thead>
							<tr style="text-align: center;">
								<th>TOTAL</th>
								<th><?= 'R$ ' . number_format($sum_vendas['dinheiro'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_vendas['transferencia'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_vendas['debito'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_vendas['credito'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_vendas['boleto'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_vendas['creditofinanceiro'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format(($sum_vendas['dinheiro'] + $sum_vendas['transferencia'] + $sum_vendas['debito'] + $sum_vendas['credito'] + $sum_vendas['boleto'] + $sum_vendas['creditofinanceiro']), 2, ',', '.') ?>
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		<?php endif; ?>
		<!-- Card Body - Recebimento -->
		<?php if (!empty($res_rebecer)) : ?>
			<div class="card-body">
				<label style="color: blue">RECEBIMENTO</label>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm">
						<thead style="font-size: 12px;">
							<tr style="text-align: center;">
								<th>DESCRIÇÃO</th>
								<th>DINHEIRO</th>
								<th>TRANSFERENCIA</th>
								<th>CARTÃO DEBITO</th>
								<th>CARTÃO CREDITO</th>
								<th>CREDITO LOJA</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						</tbody>
						<?php foreach ($res_rebecer as $row) : ?>
							<?php
							$sum_rebecer['dinheiro']           = $sum_rebecer['dinheiro'] + $row->dinheiro;
							$sum_rebecer['transferencia']      = $sum_rebecer['transferencia'] + $row->transferencia;
							$sum_rebecer['debito']             = $sum_rebecer['debito'] + $row->debito;
							$sum_rebecer['credito']            = $sum_rebecer['credito'] + $row->credito;
							$sum_rebecer['creditofinanceiro']  = $sum_rebecer['creditofinanceiro'] + $row->creditofinanceiro;
							?>
							<tr style="text-align: center;">
								<td style="text-align: justify; font-size: 12px;"> RECEBIMENTO <?= $row->id_receber ?> -
									<?= abreviaNome(esc($row->cliente)); ?></td>
								<td><?= 'R$ ' . number_format($row->dinheiro, 2, ',', '.') ?></td>
								<td><?= 'R$ ' . number_format($row->transferencia, 2, ',', '.') ?></td>
								<td><?= 'R$ ' . number_format($row->debito, 2, ',', '.') ?></td>
								<td><?= 'R$ ' . number_format($row->credito, 2, ',', '.') ?></td>
								<td><?= 'R$ ' . number_format($row->creditofinanceiro, 2, ',', '.') ?></td>
								<td><b><?= 'R$ ' . number_format(($row->dinheiro + $row->transferencia + $row->debito + $row->credito + $row->creditofinanceiro), 2, ',', '.') ?></b>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						<thead>
							<tr style="text-align: center;">
								<th style="text-align: left;">TOTAL</th>
								<th><?= 'R$ ' . number_format($sum_rebecer['dinheiro'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_rebecer['transferencia'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_rebecer['debito'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_rebecer['credito'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_rebecer['creditofinanceiro'], 2, ',', '.') ?></th>
								<th><b><?= 'R$ ' . number_format(($sum_rebecer['dinheiro'] + $sum_rebecer['transferencia'] + $sum_rebecer['debito'] + $sum_rebecer['credito'] + $sum_rebecer['creditofinanceiro']), 2, ',', '.') ?></b>
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		<?php endif; ?>
		<!-- Card Body - Tabela -->
		<?php if (!empty($res_pagar) or !empty($res_folha)) : ?>
			<div class="card-body">
				<label style="color: red">PAGAMENTOS</label>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm">
						<thead>
							<tr style="text-align: center; font-size: 12px;">
								<th>DESPESA</th>
								<th>DINHEIRO</th>
								<th>TRANSFERENCIA</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($res_pagar)) : ?>
								<?php foreach ($res_pagar as $row) : ?>
									<?php
									$sum_pagar['dinheiro']      = $sum_pagar['dinheiro'] + $row->dinheiro;
									$sum_pagar['transferencia'] = $sum_pagar['transferencia'] + $row->transferencia;
									?>
									<tr>
										<td style="text-align: justify; font-size: 12px;"> DESPESA <?= $row->cod_pagar ?> -
											<?= abreviaNome(esc($row->cliente)); ?></td>
										<td style="text-align: center;"><?= 'R$ ' . number_format($row->dinheiro, 2, ',', '.') ?>
										</td>
										<td style="text-align: center;">
											<?= 'R$ ' . number_format($row->transferencia, 2, ',', '.') ?></td>
										<td style="text-align: center;">
											<?= 'R$ ' . number_format(($row->dinheiro + $row->transferencia), 2, ',', '.') ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if (!empty($res_folha)) : ?>
								<?php foreach ($res_folha as $row) : ?>
									<?php
									$sum_pagar['dinheiro']      = $sum_pagar['dinheiro'] + $row->dinheiro;
									$sum_pagar['transferencia'] = $sum_pagar['transferencia'] + $row->transferencia;
									?>
									<tr>
										<td style="text-align: justify; font-size: 12px;">FOLHA DE PAGAMENTO <?= $row->cod_folha ?>
											- <?= abreviaNome(esc($row->cliente)); ?></td>
										<td style="text-align: center;"><?= 'R$ ' . number_format($row->dinheiro, 2, ',', '.') ?>
										</td>
										<td style="text-align: center;">
											<?= 'R$ ' . number_format($row->transferencia, 2, ',', '.') ?></td>
										<td style="text-align: center;">
											<?= 'R$ ' . number_format(($row->dinheiro + $row->transferencia), 2, ',', '.') ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr style="text-align: center;">
								<th style="text-align: left;">TOTAL</th>
								<th><?= 'R$ ' . number_format($sum_pagar['dinheiro'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format($sum_pagar['transferencia'], 2, ',', '.') ?></th>
								<th><?= 'R$ ' . number_format(($sum_pagar['dinheiro'] + $sum_pagar['transferencia']), 2, ',', '.') ?>
								</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- Card Body - Tabela -->
		<?php endif; ?>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>

<?= $this->section('modal_content') ?>
<?php require_once('componentes/caixa_open_modal.php');
?>
<?= $this->endSection() ?>