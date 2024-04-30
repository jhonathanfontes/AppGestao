<?php

namespace App\Models\Cadastro;

use CodeIgniter\Model;

class PessoaModel extends Model
{
	protected $table = 'cad_pessoa';
	protected $primaryKey = 'id_pessoa';
	protected $returnType = \App\Entities\Cadastro\Pessoa::class;
	protected $useSoftDeletes = true;
	protected $allowedFields = [
		'tipo_cliente',
		'pes_nome',
		'pes_apelido',
		'pes_cpf',
		'pes_rg',
		'pes_cnpj',
		'pes_tiponatureza',
		'pes_datanascimento',
		'pes_email',
		'pes_telefone',
		'pes_celular',
		'pes_endereco',
		'pes_numero',
		'pes_setor',
		'pes_complemento',
		'pes_cidade',
		'pes_estado',
		'pes_cep',
		'dadosbancarios_id',
		'profissao_id',
		'status',
		'pes_padrao',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
	];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;

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

	protected function atributos()
	{
		return array(
			'cad_pessoa.id_pessoa AS cod_pessoa',
			'cad_pessoa.tipo_cliente AS cad_tipo',
			'cad_pessoa.pes_nome AS cad_nome',
			'cad_pessoa.pes_apelido AS cad_apelido',
			'cad_pessoa.pes_cpf AS cad_cpf',
			'cad_pessoa.pes_rg AS cad_rg',
			'cad_pessoa.pes_cnpj AS cad_cnpj',
			'cad_pessoa.pes_tiponatureza AS cad_natureza',
			'cad_pessoa.pes_datanascimento AS cad_nascimento',
			'cad_pessoa.pes_email AS cad_email',
			'cad_pessoa.pes_telefone AS cad_telefone',
			'cad_pessoa.pes_celular AS cad_celular',
			'cad_pessoa.pes_endereco AS cad_endereco',
			'cad_pessoa.pes_numero AS cad_numero',
			'cad_pessoa.pes_setor AS cad_setor',
			'cad_pessoa.pes_complemento AS cad_complemento',
			'cad_pessoa.pes_cidade AS cad_cidade',
			'cad_pessoa.pes_estado AS cad_estado',
			'cad_pessoa.pes_cep AS cad_cep',
			'cad_pessoa.dadosbancarios_id AS cod_bancario',
			'cad_pessoa.status AS status',
			'cad_pessoa.pes_padrao AS cad_padrao'
		);
	}

	protected function atributosPessoas()
	{
		return array(
			'cad_pessoa.id_pessoa AS cod_pessoa',
			'cad_pessoa.tipo_cliente AS cad_tipo',
			'cad_pessoa.pes_nome AS cad_nome',
			'cad_pessoa.status AS status',
			'cad_pessoa.pes_padrao AS cad_padrao'
		);
	}

	public function returnSave(int $codigo = null)
	{
		return $this->select('id_pessoa, pes_nome')->find($codigo);
	}

	public function arquivarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 3;
			$data['deleted_user_id'] = getUsuarioID();
			$data['deleted_at'] 	 = getDatetimeAtual();
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

	public function getClientes()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select($this->atributosPessoas());
		$builder->where('status', 1);
		$builder->whereIn('tipo_cliente', ['1', '3']);
		$builder->orderBy('pes_nome', 'ASC');
		$result = $builder->get();
		return $result->getResult();
	}
	public function getFornecedores()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select($this->atributosPessoas());
		$builder->where('status', 1);
		$builder->whereIn('tipo_cliente', ['2', '3']);
		$builder->orderBy('pes_nome', 'ASC');
		$result = $builder->get();
		return $result->getResult();
	}
	public function getPessoaPadrao(string $tipo = 'F')
	{
		if ($tipo != 'F') {
			$where = ['2', '3'];
		} else {
			$where = ['1', '3'];
		}
		$result = $this->where('pes_padrao', 'S')
			->where('status', 1)
			->whereIn('tipo_cliente', $where)
			->first();
		return $result;
	}
}
