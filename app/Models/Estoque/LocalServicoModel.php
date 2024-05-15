<?php

namespace App\Models\Projeto;

use CodeIgniter\Model;

class LocalServicoModel extends Model
{
	protected $table = 'ger_localservico';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Projeto\LocalServico::class;
	protected $useSoftDeletes = true;
	protected $allowedFields = [
		'local_id',
		'produto_id',
		'lsv_quantidade',
		'lsv_valor',
		'lsv_total',
		'lsv_observacao',
		'status',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
	];
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $beforeInsert = ['insertAuditoria'];
	protected $beforeUpdate = ['updateAuditoria'];

	protected function insertAuditoria(array $data)
	{
		$data['data']['created_user_id'] = getUsuarioID();
		$data['data']['created_at'] = getDatetimeAtual();
		return $data;
	}

	protected function updateAuditoria(array $data)
	{
		$data['data']['updated_user_id'] = getUsuarioID();
		$data['data']['updated_at'] = getDatetimeAtual();
		return $data;
	}

	public function arquivarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 9;
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function deletarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 0;
			$data['deleted_user_id'] = getUsuarioID();
			$data['deleted_at'] = getDatetimeAtual();
			return $this->update($codigo, $data);
		}
		return false;
	}
	public function getProdutoDetalhe()
	{
		$atributos = [
			'ger_localservico.id',
			'ger_localservico.local_id',
			'ger_localservico.produto_id',
			'ger_localservico.lsv_quantidade',
			'ger_localservico.lsv_valor',
			'ger_localservico.lsv_total',
			'ger_localservico.lsv_observacao',
			'ger_localservico.status',
			'cad_produto.pro_descricao',
			'cad_tamanho.tam_abreviacao',
			'cad_tamanho.tam_descricao'
		];

		$result = $this->select($atributos)
			->join('cad_produto', 'cad_produto.id = ger_localservico.produto_id', 'LEFT')
			->join('cad_tamanho', 'cad_tamanho.id = cad_produto.tamanho_id', 'LEFT');

		return $result;
	}
}
