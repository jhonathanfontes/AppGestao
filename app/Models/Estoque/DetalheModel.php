<?php

namespace App\Models\Estoque;

use CodeIgniter\Model;

class DetalheModel extends Model
{
	protected $table = 'est_movimentacao';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Estoque\Detalhe::class;
	protected $useSoftDeletes = true;
	protected $allowedFields = [
		'estoque_id',
		'orcamento_id',
		'local_id',
		'produto_id',
		'del_tipo',
		'qtn_produto',
		'qtn_devolvido',
		'qtn_saldo',
		'val1_un',
		'val1_unad',
		'val1_total',
		'val2_un',
		'val2_unad',
		'val2_total',
		'situacao',
		'serial',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id',
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

	public function returnSave(int $codigo = null)
	{
		return $this->select('id, orcamento_id, estoque_id')->find($codigo);
	}

	public function arquivarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['status'] = 3;
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function finishOrcamento(int $cod_orcamento = null): bool
	{
		if ($cod_orcamento != null) {

			$data['situacao'] = 2;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] = getDatetimeAtual();

			return $this->where('orcamento_id', $cod_orcamento)
				->where('situacao', 1)
				->set($data)
				->update();
		}
		return false;
	}

	public function vendaToOrcamento(int $cod_orcamento = null): bool
	{
		if ($cod_orcamento != null) {

			$data['situacao'] = 1;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] = getDatetimeAtual();

			return $this->where('orcamento_id', $cod_orcamento)
				->where('situacao', 2)
				->set($data)
				->update();
		}
		return false;
	}

	public function finishVenda(int $cod_orcamento = null): bool
	{
		if ($cod_orcamento != null) {

			$data['situacao'] = 1;
			$data['updated_user_id'] = getUsuarioID();
			$data['updated_at'] = getDatetimeAtual();

			return $this->where('orcamento_id', $cod_orcamento)
				->where('situacao', 2)
				->set($data)
				->update();
		}
		return false;
	}

	public function deletarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['situacao'] = 0;
			$data['deleted_user_id'] = getUsuarioID();
			$data['deleted_at'] = getDatetimeAtual();
			return $this->update($codigo, $data);
		}
		return false;
	}

	public function deletarRegistros(array $codigos = null, $orcamento = null, $estoque = null)
	{
		if ($codigos != null) {
			$data['situacao'] = 0;
			$data['deleted_user_id'] = getUsuarioID();
			$data['deleted_at'] = getDatetimeAtual();

			if ($orcamento != null) {
				return $this->set($data)->where('orcamento_id', $orcamento)->whereIn('id_detalhe', $codigos)->update();
			}

			if ($estoque != null) {
				return $this->set($data)->where('estoque_id', $estoque)->whereIn('id_detalhe', $codigos)->update();
			}

			return false;
		}
		return false;
	}

	public function getProdutoDetalhe()
	{
		$atributos = [
			'est_movimentacao.id',
			'est_movimentacao.orcamento_id',
			'est_movimentacao.local_id',
			'est_movimentacao.produto_id',
			'cad_produto.pro_descricao',
			'cad_produto.pro_tipo',
			'est_movimentacao.qtn_produto',
			'est_movimentacao.qtn_devolvido',
			'est_movimentacao.qtn_saldo',
			'est_movimentacao.val1_un',
			'est_movimentacao.val1_unad',
			'est_movimentacao.val1_total',
			'est_movimentacao.val2_un',
			'est_movimentacao.val2_unad',
			'est_movimentacao.val2_total',
			'est_movimentacao.situacao',
			'cad_tamanho.tam_abreviacao',
			'cad_tamanho.tam_descricao'
		];

		$result = $this->select($atributos)
			->join('cad_produto', 'cad_produto.id = est_movimentacao.produto_id', 'LEFT')
			->join('cad_tamanho', 'cad_tamanho.id = cad_produto.tamanho_id', 'LEFT');

		return $result;
	}

	public function getSumProdutoDetalhe()
	{
		$atributos = [
			'est_movimentacao.local_id',
			'SUM(est_movimentacao.qtn_produto) AS qtn_produto',
			'SUM(est_movimentacao.val1_unad) AS val1_unad',
			'SUM(est_movimentacao.val1_total) AS val1_total',
			'cad_produto.pro_tipo'
		];

		$result = $this->select($atributos)
			->join('cad_produto', 'cad_produto.id = est_movimentacao.produto_id', 'LEFT');

		return $result;
	}
}
