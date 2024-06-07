<?php

namespace App\Models\Venda;

use CodeIgniter\Model;

class OrcamentoModel extends Model
{

	protected $table = 'pdv_orcamento';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Venda\Orcamento::class;
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'orc_tipoorcamento',
		'orc_tipopagamento',
		'pessoa_id',
		'obra_id',
		'orc_dataorcamento',
		'vendedor_id',
		'qtn_produto',
		'qtn_devolvido',
		'qtn_saldo',
		'valor1_bruto',
		'valor1_desconto',
		'valor1_total',
		'valor2_bruto',
		'valor2_desconto',
		'valor2_total',
		'situacao',
		'serial',
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
		$data['data']['orc_dataorcamento'] = getDatetimeAtual();
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
		return $this->select('id, orc_tipoorcamento as venda_tipo, serial')->find($codigo);
	}

	public function arquivarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 3;
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function finishOrcamento(int $cod_orcamento = null, string $serial = null): bool
	{
		if ($cod_orcamento != null && $serial != null) {

			$data['situacao'] = 2;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] = getDatetimeAtual();

			return $this->where('id', $cod_orcamento)
				->where('serial', $serial)
				->set($data)
				->update();
		}
		return false;
	}

	public function vendaToOrcamento(int $cod_orcamento = null, string $serial = null): bool
	{
		if ($cod_orcamento != null && $serial != null) {

			$data['situacao'] = 4;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] = getDatetimeAtual();

			return $this->where('id', $cod_orcamento)
				->where('serial', $serial)
				->set($data)
				->update();
		}
		return false;
	}

	public function finishVenda(int $cod_orcamento = null): bool
	{
		if ($cod_orcamento != null) {

			$data['situacao'] = 2;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] = getDatetimeAtual();

			return $this->where('id', $cod_orcamento)
				->set($data)
				->update();
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

	public function returnOrcamentos()
	{
		$atributos = [
			'pdv_orcamento.id as cod_orcamento',
			'orc_tipoorcamento as venda_tipo',
			'orc_tipopagamento as orc_tipo',
			'orc_dataorcamento',
			'qtn_produto',
			'qtn_devolvido',
			'qtn_saldo',
			'valor1_bruto',
			'valor1_desconto',
			'valor1_total',
			'valor2_bruto',
			'valor2_desconto',
			'valor2_total',
			'serial',
			'situacao',
			'cad_pessoa.pes_nome as pessoa',
			'cad_usuario.use_nome as usuario',
		];

		$return = $this->select($atributos)
			->join('cad_pessoa', 'cad_pessoa.id = pdv_orcamento.pessoa_id', 'LEFT')
			->join('cad_usuario', 'cad_usuario.id = pdv_orcamento.created_user_id', 'LEFT');

		return $return;
	}

	public function listarOrcamentos()
	{
		$atributos = [
			'pdv_orcamento.id AS cod_orcamento',
			'pdv_orcamento.pessoa_id AS cod_pessoa',
			'cad_pessoa.pes_nome AS pessoa',
			'pdv_orcamento.orc_tipoorcamento AS venda_tipo',
			'pdv_orcamento.orc_tipopagamento AS cod_tipo',
			'pdv_orcamento.orc_dataorcamento AS orc_data',
			'pdv_orcamento.qtn_produto AS qtn_produto',
			'pdv_orcamento.qtn_devolvido AS qtn_devolvido',
			'pdv_orcamento.qtn_saldo AS qtn_saldo',
			'pdv_orcamento.valor1_bruto',
			'pdv_orcamento.valor1_desconto',
			'pdv_orcamento.valor1_total',
			'pdv_orcamento.valor2_bruto',
			'pdv_orcamento.valor2_desconto',
			'pdv_orcamento.valor2_total',
			'pdv_orcamento.serial AS serial',
			'pdv_orcamento.situacao AS situacao',
			'pdv_orcamento.created_user_id AS cod_usuario',
			'cad_usuario.use_nome AS usuario',
			'pdv_orcamento.created_at AS data_cadastro',
			'pdv_orcamento.vendedor_id',
			'use_vendedor.use_apelido AS vendedor',
		];

		$return = $this->select($atributos)
			->join('cad_pessoa', 'cad_pessoa.id = pdv_orcamento.pessoa_id')
			->join('cad_usuario', 'cad_usuario.id = pdv_orcamento.created_user_id')
			->join('cad_vendedor', 'cad_vendedor.id = pdv_orcamento.vendedor_id', 'LEFT')
			->join('cad_usuario as use_vendedor', 'use_vendedor.id = cad_vendedor.usuario_id', 'LEFT');

		return $return;
	}
}
