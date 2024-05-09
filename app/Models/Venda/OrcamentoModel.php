<?php

namespace App\Models\Venda;

use CodeIgniter\Model;

class OrcamentoModel extends Model
{

	protected $table = 'pdv_orcamento';
	protected $primaryKey = 'id_orcamento';
	protected $returnType = \App\Entities\Venda\Orcamento::class;
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'pessoa_id',
		'venda_tipo',
		'orc_tipo',
		'orc_data',
		'orc_pdv',
		'vendedor_id',
		'qtn_produto',
		'qtn_devolvido',
		'qtn_restante',
		'valor_bruto',
		'valor_desconto',
		'valor_total',
		'vpo_bruto',
		'vpo_desconto',
		'vpo_total',
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
		$data['data']['situacao'] 		 = 4;
		$data['data']['orc_data'] 		 = getDatetimeAtual();
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
		return $this->select('id_orcamento, venda_tipo, serial')->find($codigo);
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

			$data['situacao'] 		 = 2;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] 	 = getDatetimeAtual();

			return $this->where('id_orcamento', $cod_orcamento)
				->where('serial', $serial)
				->set($data)
				->update();
		}
		return false;
	}

	public function vendaToOrcamento(int $cod_orcamento = null, string $serial = null): bool
	{
		if ($cod_orcamento != null && $serial != null) {

			$data['situacao'] 		 = 4;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] 	 = getDatetimeAtual();

			return $this->where('id_orcamento', $cod_orcamento)
				->where('serial', $serial)
				->set($data)
				->update();
		}
		return false;
	}

	public function finishVenda(int $cod_orcamento = null): bool
	{
		if ($cod_orcamento != null) {

			$data['situacao'] 		 = 2;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] 	 = getDatetimeAtual();

			return $this->where('id_orcamento', $cod_orcamento)
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
			$data['deleted_at'] 	 = getDatetimeAtual();
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function returnOrcamentos()
	{
		$atributos = [
			'id_orcamento',
			'venda_tipo',
			'orc_tipo',
			'orc_data',
			'qtn_produto',
			'qtn_devolvido',
			'qtn_restante',
			'valor_bruto',
			'valor_desconto',
			'valor_total',
			'vpo_bruto',
			'vpo_desconto',
			'vpo_total',
			'serial',
			'situacao',
			'cad_pessoa.pes_nome as pessoa',
			'cad_usuario.use_nome as usuario',
		];

		$return = $this->select($atributos)
			->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id')
			->join('cad_usuario', 'cad_usuario.id_usuario = pdv_orcamento.created_user_id');

		return $return;
	}

	public function listarOrcamentos()
	{
		$atributos = [
			'pdv_orcamento.id_orcamento AS cod_orcamento',
			'pdv_orcamento.pessoa_id AS cod_pessoa',
			'cad_pessoa.pes_nome AS pessoa',
			'pdv_orcamento.venda_tipo AS venda_tipo',
			'pdv_orcamento.orc_tipo AS cod_tipo',
			'pdv_orcamento.orc_data AS orc_data',
			'pdv_orcamento.orc_pdv AS orc_pdv',
			'pdv_orcamento.qtn_produto AS qtn_produto',
			'pdv_orcamento.qtn_devolvido AS qtn_devolvido',
			'pdv_orcamento.qtn_restante AS qtn_restante',
			'pdv_orcamento.valor_bruto AS valor_bruto',
			'pdv_orcamento.valor_desconto AS valor_desconto',
			'pdv_orcamento.valor_total AS valor_total',
			'pdv_orcamento.vpo_bruto AS praz_bruto',
			'pdv_orcamento.vpo_desconto AS praz_desconto',
			'pdv_orcamento.vpo_total AS praz_total',
			'pdv_orcamento.serial AS serial',
			'pdv_orcamento.situacao AS situacao',
			'pdv_orcamento.created_user_id AS cod_usuario',
			'cad_usuario.use_nome AS usuario',
			'pdv_orcamento.created_at AS data_cadastro',
			'pdv_orcamento.vendedor_id',
			'use_vendedor.use_apelido AS vendedor',
		];

		$return = $this->select($atributos)
			->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id')
			->join('cad_usuario', 'cad_usuario.id_usuario = pdv_orcamento.created_user_id')
			->join('cad_vendedor', 'cad_vendedor.id_vendedor = pdv_orcamento.vendedor_id', 'LEFT')
			->join('cad_usuario as use_vendedor', 'use_vendedor.id_usuario = cad_vendedor.usuario_id', 'LEFT');

		return $return;
	}
}
