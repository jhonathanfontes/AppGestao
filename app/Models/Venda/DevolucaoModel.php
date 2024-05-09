<?php

namespace App\Models\Venda;

use CodeIgniter\Model;

class DevolucaoModel extends Model
{

	protected $table = 'pdv_devolucao';
	protected $primaryKey = 'id_devolucao';
	protected $returnType = \App\Entities\Venda\Devolucao::class;
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'caixa_id',
		'venda_id',
		'dev_data',
		'dev_qtn',
		'dev_total',
		'dev_observacao',
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

	public function getDevolucoes()
	{
		$atributos = [
			'pdv_devolucao.id_devolucao AS cod_devolucao',
			'pdv_devolucao.caixa_id AS cod_caixa',
			'pdv_devolucao.venda_id AS cod_venda',
			'cad_pessoa.pes_nome AS cad_pessoa',
			'pdv_devolucao.dev_data AS cad_data',
			'pdv_devolucao.dev_qtn AS qtn_produto',
			'pdv_devolucao.dev_total AS total',
			'pdv_devolucao.serial AS serial',
			'pdv_devolucao.situacao AS situacao',
			'cad_usuario.use_apelido AS cad_usuario'
		];

		return $this->select($atributos)
			->join('pdv_venda', 'pdv_venda.id_venda = pdv_devolucao.venda_id', 'LEFT')
			->join('pdv_caixa', 'pdv_caixa.id_caixa = pdv_venda.caixa_id', 'LEFT')
			->join('pdv_orcamento', 'pdv_orcamento.id_orcamento = pdv_venda.orcamento_id', 'LEFT')
			->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id', 'LEFT')
			->join('cad_usuario', 'cad_usuario.id_usuario = pdv_devolucao.created_user_id', 'LEFT')
			->groupBy('pdv_devolucao.situacao, pdv_devolucao.id_devolucao');
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
}
