<?php

namespace App\Models\Projeto;

use CodeIgniter\Model;

class ObraModel extends Model
{
	protected $table = 'ger_obra';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Projeto\Obra::class;
	protected $useSoftDeletes = true;
	protected $allowedFields = [
		'obr_descricao',
		'obr_datainicio',
		'pessoa_id',
		'endereco_id',
		'situacao',
		'serial',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
	];
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $validationRules = [
		'obr_descricao' => 'required',
	];
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
		return $this->select('id, obr_descricao')->find($codigo);
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

	public function getObra()
	{
		$atributos = [
			'ger_obra.*',
			'cad_pessoa.pes_nome AS cad_nome',
			'cad_endereco.id AS cod_endereco',
			'end_endereco AS cad_endereco',
			'end_numero AS cad_numero',
			'end_setor AS cad_setor',
			'end_complemento AS cad_complemento',
			'end_cidade AS cad_cidade',
			'end_estado AS cad_estado',
			'end_cep AS cad_cep',
			'pdv_orcamento.id AS cod_orcamento'
		];

		return $this->select($atributos)
			->join('cad_pessoa', 'cad_pessoa.id = ger_obra.pessoa_id', 'LEFT')
			->join('cad_endereco', 'cad_endereco.id = ger_obra.endereco_id', 'LEFT')
			->join('pdv_orcamento', 'pdv_orcamento.obra_id = ger_obra.id', 'LEFT');
	}

	public function getObras()
	{
		$atributos = [
			'ger_obra.id as cod_obra',
			'obr_descricao as cad_obra',
			'obr_datainicio as cad_datainicio',
			'ger_obra.status',
			'cad_endereco.id as cod_endereco',
			'end_endereco as cad_endereco',
			'end_numero as cad_numero',
			'end_setor as cad_setor',
			'end_complemento as cad_complemento',
			'end_cidade as cad_cidade',
			'end_estado as cad_estado',
			'end_cep as cad_cep',
		];

		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select($atributos);
		$builder->join('cad_endereco', 'cad_endereco.id = ger_obra.endereco_id');
		$builder->whereIn('ger_obra.status', ['1', '2']);
		$builder->orderBy('emp_razao', 'asc');
		$result = $builder->get();
		return $result->getResult();
	}

	public function countProdutoObra(int $cod_obra = null)
	{
		$atributos = [
			'ger_obra.id',
			'count(est_movimentacao.id) AS totalProdutos'
		];

		return $this->select($atributos)
			->join('ger_local', 'ger_local.obra_id = ger_obra.id', 'LEFT')
			->join('est_movimentacao', 'est_movimentacao.local_id = ger_local.id AND est_movimentacao.situacao IN (1, 2, 4)', 'LEFT')
			->where('ger_obra.id', $cod_obra)
			->groupBy('ger_obra.id')
			->first();
	}
}
