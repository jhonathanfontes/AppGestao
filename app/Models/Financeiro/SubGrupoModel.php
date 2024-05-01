<?php

namespace App\Models\Financeiro;

use CodeIgniter\Model;

class SubGrupoModel extends Model
{

	protected $table = 'cad_subgrupo';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Financeiro\Subgrupo::class;
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'grupo_id',
		'sub_descricao',
		'sub_vendapadrao',
		'sub_folhapadrado',
		'status',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
	];
	protected $useTimestamps = false;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = true;

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
		return $this->select('id, sub_descricao')->find($codigo);
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

	public function getSubGrupos()
	{
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select('cad_subgrupo.*, cad_grupo.gru_descricao as cad_grupo');
		$builder->join('cad_grupo', 'cad_grupo.id = cad_subgrupo.grupo_id');
		$builder->whereIn('cad_subgrupo.status', ['1', '2']);
		$result = $builder->get();
		return $result->getResult();
	}
	public function getSubgrupoGrupoAtivo()
	{
		$attributes = [
			'cad_subgrupo.*',
			'cad_grupo.gru_descricao'
		];
		return $this->select($attributes)
			->join('cad_grupo', 'cad_grupo.id = cad_subgrupo.grupo_id')
			->where('cad_grupo.status', 1)
			->where('cad_subgrupo.status', 1);
	}
}
