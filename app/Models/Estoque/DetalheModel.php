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
		return $this->select('id_detalhe, orcamento_id, estoque_id')->find($codigo);
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

	public function listarDetalhes()
	{
		$atributos = [
			'est_detalhe.id_detalhe AS cod_detalhe',
			'est_detalhe.orcamento_id AS cod_orcamento',
			'est_detalhe.estoque_id AS cod_estoque',
			'est_detalhe.produto_id AS cod_produto',
			'cad_produto.pro_descricao AS produto',
			'est_detalhe.tamanho_id AS cod_tamanho',
			'cad_tamanho.tam_descricao AS tamanho',
			'est_detalhe.mvd_tipo AS tipo',
			'est_detalhe.qtn_produto AS qtn_produto',
			'est_detalhe.qtn_devolvido AS qtn_devolvido',
			'est_detalhe.qtn_saldo AS qtn_saldo',
			'est_detalhe.mvd_val_un AS valor_un',
			'est_detalhe.mvd_val_ad AS valor_ad',
			'est_detalhe.mvd_val_unad AS valor_unad',
			'est_detalhe.mvd_total AS total',
			'est_detalhe.mvd_total_unad AS total_unad',
			'est_detalhe.mpd_val_un AS praz_valor_un',
			'est_detalhe.mpd_val_ad AS praz_valor_ad',
			'est_detalhe.mpd_val_unad AS praz_valor_unad',
			'est_detalhe.mpd_total AS praz_total',
			'est_detalhe.mpd_total_unad AS praz_total_unad',
			'est_detalhe.situacao AS situacao',
			'est_detalhe.serial AS serial',
			'est_detalhe.sug_avista AS sug_avista',
			'est_detalhe.sug_prazo AS sug_prazo',
			'est_detalhe.est_presente AS presente',
			'est_detalhe.created_user_id AS cod_usuario',
			'cad_usuario.use_nome AS usuario',
			'est_detalhe.created_at AS data_cadastro',
			'cad_produto.fabricante_id as cod_fabricante',
			'cad_fabricante.fab_descricao as cad_fabricante'
		];

		$return = $this->select($atributos)
			->join('cad_produto', 'cad_produto.id_produto = est_detalhe.produto_id')
			->join('cad_tamanho', 'cad_tamanho.id_tamanho = est_detalhe.tamanho_id')
			->join('cad_usuario', 'cad_usuario.id_usuario = est_detalhe.created_user_id')
			->join('cad_fabricante', 'cad_fabricante.id_fabricante = cad_produto.fabricante_id');

		return $return;
	}

	public function getProdutoDetalhe()
	{
		$atributos = [
			'est_movimentacao.id',
			'est_movimentacao.local_id',
			'est_movimentacao.produto_id',
			'est_movimentacao.qtn_produto',
			'est_movimentacao.val1_unad',
			'est_movimentacao.val1_total',
			'est_movimentacao.situacao',
			'cad_produto.pro_descricao',
			'cad_tamanho.tam_abreviacao',
			'cad_tamanho.tam_descricao'
		];

		$result = $this->select($atributos)
			->join('cad_produto', 'cad_produto.id = est_movimentacao.produto_id', 'LEFT')
			->join('cad_tamanho', 'cad_tamanho.id = cad_produto.tamanho_id', 'LEFT');

		return $result;
	}
}
