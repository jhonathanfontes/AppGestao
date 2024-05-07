<?php

namespace App\Models\Cadastro;

use CodeIgniter\Model;

class ProdutoModel extends Model
{

	protected $table = 'cad_produto';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Cadastro\Produto::class;
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'pro_tipo',
		'pro_descricao',
		'categoria_id',
		'pro_codigobarra',
		'tamanho_id',
		'valor_custo',
		'valor_venda1',
		'valor_venda2',
		'estoque',
		'status',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id',
		'deleted_at'
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
		return $this->select('id, pro_descricao')->find($codigo);
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

	public function getProdutos($cod_produto = null)
	{
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select('cad_produto.*, cad_categoria.cat_descricao, cad_tamanho.tam_abreviacao, cad_tamanho.tam_descricao');
		$builder->join('cad_categoria', 'cad_categoria.id = cad_produto.categoria_id');
		$builder->join('cad_tamanho', 'cad_tamanho.id = cad_produto.tamanho_id');
		$builder->whereIn('cad_produto.status', ['1', '2']);
		$builder->where('cad_produto.pro_tipo', $cod_produto);
		$result = $builder->get();
		return $result->getResult();
	}

	public function getProduto(int $codigo)
	{
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select(
			'cad_produto.id as cod_produto,		
			cad_produto.pro_descricao as cad_produto,
			cad_produto.pro_tipo as cad_tipo,
			cad_produto.categoria_id as cod_categoria, 
			cad_categoria.cat_descricao as cad_categoria,
			cad_produto.tamanho_id as cod_tamanho,
			cad_tamanho.tam_descricao as des_tamanho,                  
			cad_produto.valor_custo,
			cad_produto.valor_venda1,
			cad_produto.valor_venda2,
			COALESCE(cad_produto.estoque, 0) as estoque,
			pro_codigobarra as cad_codigobarras,
			cad_produto.status'
		);
		$builder->join('cad_categoria', 'cad_categoria.id = cad_produto.categoria_id');
		$builder->join('cad_tamanho', 'cad_tamanho.id = cad_produto.tamanho_id');
		$builder->where('cad_produto.id', $codigo);
		$builder->whereIn('cad_produto.status', ['1', '2', '9']);
		$result = $builder->get();
		return $result->getRow();
	}

	public function selectProdutos()
	{
		$atributos = [
			'cad_produto.*',
			'cad_categoria.cat_descricao',
			'cad_tamanho.tam_abreviacao',
			'cad_tamanho.tam_descricao'
		];

		$result = $this->select($atributos)
			->join('cad_categoria', 'cad_categoria.id = cad_produto.categoria_id', 'LEFT')
			->join('cad_tamanho', 'cad_tamanho.id = cad_produto.tamanho_id', 'LEFT');

		return $result;
	}
}
