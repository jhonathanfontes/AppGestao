<?php

namespace App\Models\Cadastro;

use CodeIgniter\Model;

class FabricanteModel extends Model
{

	protected $table = 'cad_fabricante';
	protected $primaryKey = 'id_fabricante';
	protected $returnType = \App\Entities\Cadastro\Fabricante::class;
	protected $useSoftDeletes = true;
	protected $allowedFields = ['fab_descricao', 'status', 'created_user_id', 'updated_user_id', 'deleted_user_id'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;

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
		return $this->select('id_fabricante, fab_descricao')->find($codigo);
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
