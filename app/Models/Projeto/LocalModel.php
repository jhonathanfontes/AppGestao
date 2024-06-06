<?php

namespace App\Models\Projeto;

use CodeIgniter\Model;

class LocalModel extends Model
{
	protected $table = 'ger_local';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Projeto\Local::class;
	protected $useSoftDeletes = true;
	protected $allowedFields = [
		'loc_descricao',
		'loc_datainicio',
		'loc_observacao',
		'obra_id',
		'status',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
	];
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $validationMessages = [];

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

	public function returnSave(int $codigo = null)
	{
		return $this->select('id, loc_descricao')->find($codigo);
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

	public function getLocalObra($cod_obra = null)
	{
		$atributos = [
			'id',
			'obra_id',
			'loc_descricao',
			'loc_datainicio',
			'status'
		];

		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select($atributos);
		$builder->where('status', '1');
		$builder->where('obra_id', $cod_obra);
		$result = $builder->get();
		return $result->getResult();
	}

	public function getOrcamentoObraLocal(){

		$atributos = [
			'pdv_orcamento.id as cod_orcamento',
			'pdv_orcamento.serial',
			'ger_local.id',
			'ger_local.obra_id',
		];

		return $this->select($atributos)
			->join('ger_obra', 'ger_obra.id = ger_local.obra_id', 'LEFT')
			->join('pdv_orcamento', 'pdv_orcamento.obra_id = ger_obra.id', 'LEFT');
	}
}
