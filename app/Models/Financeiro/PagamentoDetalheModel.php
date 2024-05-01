<?php

namespace App\Models\Financeiro;

use CodeIgniter\Model;

class PagamentoDetalheModel extends Model
{
	protected $table = 'pag_detalhe';
	protected $primaryKey = 'id_detalhe';
	protected $returnType = \App\Entities\Financeiro\PagamentoDetalhe::class;

	protected $allowedFields = [
		'pagamento_id',
		'orcamento_id',
		'receber_id',
		'pagar_id',
		'det_valor',
		'situacao',
		'serial'
	];

	public function getPagamentosContaReceber($serial, $codigo)
	{
		$atributos = [
			'id_detalhe',
			'det_valor',
			'situacao'
		];
		$result = $this->select($atributos)
			->whereIn('situacao', [1, 2])
			->where('serial', $serial)
			->where('pagamento_id', $codigo)
			->findAll();
		return $result;
	}
}
