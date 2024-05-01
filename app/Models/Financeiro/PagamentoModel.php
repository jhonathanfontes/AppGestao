<?php

namespace App\Models\Financeiro;

use CodeIgniter\Model;

class PagamentoModel extends Model
{
	protected $table = 'pag_financeiro';
	protected $primaryKey = 'id_pagamento';
	protected $returnType = \App\Entities\Financeiro\Pagamento::class;

	protected $allowedFields = [
		'caixa_id',
		'formapac_id',
		'conta_id',
		'pag_formapagamento',
		'pag_valor',
		'pag_documento',
		'pag_parcela',
		'serial',
		'situacao',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
	];

	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	protected $beforeInsert = ['insertAuditoria'];
	protected $beforeUpdate = ['updateAuditoria'];

	protected function insertAuditoria(array $data)
	{

		$data['data']['created_user_id'] = getUsuarioID();
		$data['data']['created_at'] 	 = getDatetimeAtual();
		return $data;
	}

	protected function updateAuditoria(array $data)
	{
		$data['data']['updated_user_id'] = getUsuarioID();
		$data['data']['updated_at'] 	 = getDatetimeAtual();
		return $data;
	}

	public function getRecebimentoContaReceberCliente($codPessoa = null)
	{

		$attributes = [
			'pag_financeiro.id_pagamento',
			'pag_financeiro.caixa_id',
			'pag_financeiro.formapac_id',
			'pdv_formapag.for_descricao',
			'pag_financeiro.conta_id',
			'cad_contabancaria.con_descricao',
			'pag_financeiro.pag_formapagamento',
			'pag_financeiro.pag_valor',
			'pag_financeiro.pag_documento',
			'pag_financeiro.pag_parcela',
			'pag_financeiro.serial',
			'pag_financeiro.situacao',
			'pag_financeiro.created_user_id',
			'cad_usuario.use_apelido'
		];

		return $this->distinct()
			->select($attributes)
			->join('pdv_formapac', 'pdv_formapac.id_formapac = pag_financeiro.formapac_id', 'LEFT')
			->join('pdv_formapag', 'pdv_formapag.id_forma = pdv_formapac.forma_id', 'LEFT')
			->join('cad_contabancaria', 'cad_contabancaria.id_conta = pag_financeiro.conta_id', 'LEFT')
			->join('cad_usuario', 'cad_usuario.id_usuario = pag_financeiro.created_user_id', 'LEFT')
			->join('pag_detalhe', 'pag_detalhe.pagamento_id = pag_financeiro.id_pagamento', 'LEFT')
			->join('fin_receber', 'fin_receber.id_receber = pag_detalhe.receber_id', 'LEFT')
			->whereIn('pag_financeiro.situacao', ['1', '2'])
			->where('pag_detalhe.receber_id <>', NULL)
			->where('fin_receber.pessoa_id', $codPessoa)
			->orderBy('pag_financeiro.created_at', 'ASC');
	}
}
