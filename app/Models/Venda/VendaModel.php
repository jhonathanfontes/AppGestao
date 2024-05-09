<?php

namespace App\Models\Venda;

use CodeIgniter\Model;

class VendaModel extends Model
{

	protected $table = 'pdv_venda';
	protected $primaryKey = 'id_venda';
	protected $returnType = \App\Entities\Venda\Venda::class;
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'orcamento_id',
		'caixa_id',
		'ven_data',
		'ven_usuario_id',
		'ven_tipo',
		'val_avista',
		'val_aprazo',
		'ven_pagamento',
		'ven_boleto',
		'ven_cancelado',
		'ven_quitado',
		'situacao',
		'ven_cancel_data',
		'serial',
		'fidelidade_id',
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

	public function returnSave(int $codigo = null)
	{
		return $this->select('id_venda, orcamento_id, caixa_id')->find($codigo);
	}

	public function arquivarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 3;
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function deletarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 0;
			$data['deleted_user_id'] = getUsuarioID();
			$data['deleted_at'] 	 = getDatetimeAtual();
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function getListarVendas()
	{
		$db      = \Config\Database::connect();

		$atributos = [
			'pdv_venda.id_venda AS cod_venda',
			'pdv_venda.orcamento_id AS cod_orcamento',
			'pdv_venda.caixa_id AS cod_caixa',
			'pdv_orcamento.pessoa_id AS cod_pessoa',
			'cad_pessoa.pes_nome AS pessoa',
			'pdv_orcamento.orc_data AS orc_data',
			'pdv_venda.ven_data AS data_compra',
			'pdv_orcamento.orc_tipo AS orc_tipo',
			'if(pdv_orcamento.orc_tipo = 1, pdv_orcamento.valor_bruto, pdv_orcamento.vpo_bruto) AS valor_bruto',
			'if(pdv_orcamento.orc_tipo = 1, pdv_orcamento.valor_desconto, pdv_orcamento.vpo_desconto) AS valor_desconto',
			'if(pdv_orcamento.orc_tipo = 1, pdv_orcamento.valor_total, pdv_orcamento.vpo_total) AS valor_total',


			'pdv_venda.ven_pagamento AS ven_pagamento',
			'pdv_venda.ven_boleto AS ven_boleto',
			'pdv_venda.ven_cancelado AS ven_cancelado',
			'if(pdv_venda.ven_tipo = 1, 
				CAST(pdv_venda.val_avista - (pdv_venda.ven_pagamento + pdv_venda.ven_boleto + pdv_venda.ven_cancelado) as decimal(9,2)), 
				CAST(pdv_venda.val_aprazo - (pdv_venda.ven_pagamento + pdv_venda.ven_boleto + pdv_venda.ven_cancelado) as decimal(9,2))) AS ven_saldo',
			'pdv_venda.ven_quitado AS ven_quitado',
			'pdv_venda.situacao AS situacao',
			'pdv_venda.ven_cancel_data AS ven_cancel_data',
			'pdv_venda.serial AS serial',
			'pdv_venda.created_user_id AS cod_usuario',
			'cad_usuario.use_nome AS usuario'
		];

		$qntProduto 	= $db->table('est_detalhe')
			->select('COALESCE(SUM(est_detalhe.qtn_produto),0)')
			->where('est_detalhe.situacao', 2)
			->where('est_detalhe.orcamento_id', 'pdv_venda.orcamento_id');

		$qntDevolvido 	= $db->table('est_detalhe')
			->select('COALESCE(SUM(est_detalhe.qtn_devolvido),0)')
			->where('est_detalhe.situacao', 2)
			->where('est_detalhe.orcamento_id', 'pdv_venda.orcamento_id');

		$Devolucao 		= $db->table('pdv_devolucao')
			->select('COUNT(pdv_devolucao.id_devolucao)')
			->where('pdv_devolucao.situacao >=', 1)
			->where('pdv_devolucao.situacao <=', 2)
			->where('pdv_devolucao.venda_id', 'pdv_venda.orcamento_id');

		return $this->select($atributos)
			->selectSubquery($qntProduto, 'qtn_produto')
			->selectSubquery($qntDevolvido, 'qtn_devolvido')
			->selectSubquery($Devolucao, 'devolucoes')
			->join('pdv_orcamento', 'pdv_orcamento.id_orcamento = pdv_venda.orcamento_id', 'left')
			->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id', 'left')
			->join('cad_usuario', 'cad_usuario.id_usuario = pdv_venda.created_user_id', 'left');
	}

	public function getVendaPDV()
	{
		$db      = \Config\Database::connect();

		$atributos = [
			'pdv_venda.id_venda AS cod_venda',
			'pdv_venda.orcamento_id AS cod_orcamento',
			'pdv_venda.caixa_id AS cod_caixa',
			'pdv_orcamento.pessoa_id AS cod_pessoa',
			'cad_pessoa.pes_nome AS pessoa',
			'pdv_orcamento.orc_data AS orc_data',
			'pdv_venda.ven_data AS data_compra',
			'pdv_orcamento.orc_tipo AS orc_tipo',
			'if(pdv_orcamento.orc_tipo = 1, pdv_orcamento.valor_bruto, pdv_orcamento.vpo_bruto) AS valor_bruto',
			'if(pdv_orcamento.orc_tipo = 1, pdv_orcamento.valor_desconto, pdv_orcamento.vpo_desconto) AS valor_desconto',
			'if(pdv_orcamento.orc_tipo = 1, pdv_orcamento.valor_total, pdv_orcamento.vpo_total) AS valor_total',


			'pdv_venda.ven_pagamento AS ven_pagamento',
			'pdv_venda.ven_boleto AS ven_boleto',
			'pdv_venda.ven_cancelado AS ven_cancelado',
			'if(pdv_venda.ven_tipo = 1, 
				CAST(pdv_venda.val_avista - (pdv_venda.ven_pagamento + pdv_venda.ven_boleto + pdv_venda.ven_cancelado) as decimal(9,2)), 
				CAST(pdv_venda.val_aprazo - (pdv_venda.ven_pagamento + pdv_venda.ven_boleto + pdv_venda.ven_cancelado) as decimal(9,2)) ) AS ven_saldo',

			'pdv_venda.ven_quitado AS ven_quitado',
			'pdv_venda.situacao AS situacao',
			'pdv_venda.ven_cancel_data AS ven_cancel_data',
			'pdv_venda.serial AS serial',
			'pdv_venda.created_user_id AS cod_usuario',
			'cad_usuario.use_nome AS usuario'
		];

		$qntProduto 	= $db->table('est_detalhe')
			->select('COALESCE(SUM(est_detalhe.qtn_produto),0)')
			->where('est_detalhe.situacao', 2)
			->where('est_detalhe.orcamento_id', 'pdv_venda.orcamento_id');

		$qntDevolvido 	= $db->table('est_detalhe')
			->select('COALESCE(SUM(est_detalhe.qtn_devolvido),0)')
			->where('est_detalhe.situacao', 2)
			->where('est_detalhe.orcamento_id', 'pdv_venda.orcamento_id');

		$Devolucao 		= $db->table('pdv_devolucao')
			->select('COUNT(pdv_devolucao.id_devolucao)')
			->where('pdv_devolucao.situacao >=', 1)
			->where('pdv_devolucao.situacao <=', 2)
			->where('pdv_devolucao.venda_id', 'pdv_venda.orcamento_id');

		return $this->select($atributos)
			->selectSubquery($qntProduto, 'qtn_produto')
			->selectSubquery($qntDevolvido, 'qtn_devolvido')
			->selectSubquery($Devolucao, 'devolucoes')
			->join('pdv_orcamento', 'pdv_orcamento.id_orcamento = pdv_venda.orcamento_id', 'left')
			->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id', 'left')
			->join('cad_usuario', 'cad_usuario.id_usuario = pdv_venda.created_user_id', 'left');
	}
}
