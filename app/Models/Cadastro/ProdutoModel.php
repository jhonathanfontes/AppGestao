<?php

namespace App\Models\Cadastro;

use CodeIgniter\Model;

class ProdutoModel extends Model
{

	protected $table = 'cad_produto';
	protected $primaryKey = 'id_produto';
	protected $returnType = \App\Entities\Cadastro\Produto::class;
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'subcategoria_id',
		'fabricante_id',
		'pro_descricao',
		'pro_descricao_pvd',
		'pro_cod_fabricante',
		'pro_codigobarras',
		'status',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id',
		'deleted_at'
	];

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
		return $this->select('id_produto, pro_descricao')->find($codigo);
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

	public function getProdutos()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select('cad_produto.*, cad_subcategoria.sub_descricao, cad_fabricante.fab_descricao,
		(SELECT COALESCE(SUM(pg.estoque),0) FROM pdv_produtograde pg WHERE pg.produto_id = cad_produto.id_produto and pg.status = 1) AS estoque ');
		$builder->join('cad_subcategoria', 'cad_subcategoria.id_subcategoria = cad_produto.subcategoria_id');
		$builder->join('cad_fabricante', 'cad_fabricante.id_fabricante = cad_produto.fabricante_id');
		$builder->whereIn('cad_produto.status', ['1', '2']);
		$result = $builder->get();
		return $result->getResult();
	}

	public function getProduto(int $codigo)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table($this->table);
		$builder->select(
			'cad_produto.id_produto as cod_produto,
			cad_produto.subcategoria_id as cod_subcategoria,
			cad_subcategoria.sub_descricao as des_subcategoria,
			cad_subcategoria.categoria_id as cod_categoria,
			cad_categoria.cat_descricao as des_categoria,
			cad_produto.fabricante_id as cod_fabricante, 
			cad_fabricante.fab_descricao as des_fabricante,
			cad_produto.pro_descricao as cad_produto,
			cad_produto.pro_descricao_pvd as cad_produto_pvd,
			cad_produto.pro_cod_fabricante as cad_fabricante,
			cad_produto.pro_codigobarras as cad_codigobarras,
			cad_produto.status,
		(SELECT COALESCE(SUM(pg.estoque),0) FROM pdv_produtograde pg WHERE pg.produto_id = cad_produto.id_produto and pg.status = 1) AS estoque '
		);
		$builder->join('cad_subcategoria', 'cad_subcategoria.id_subcategoria = cad_produto.subcategoria_id');
		$builder->join('cad_categoria', 'cad_categoria.id_categoria = cad_subcategoria.categoria_id');
		$builder->join('cad_fabricante', 'cad_fabricante.id_fabricante = cad_produto.fabricante_id');
		$builder->where('cad_produto.id_produto', $codigo);
		$builder->whereIn('cad_produto.status', ['1', '2', '3']);
		$result = $builder->get();
		return $result->getRow();
	}

	public function selectProdutos()
	{
		$atributos = [
			'cad_produto.*',
			'cad_subcategoria.sub_descricao',
			'cad_subcategoria.categoria_id',
			'cad_categoria.cat_descricao',
			'cad_fabricante.fab_descricao'
		];

		$result = $this->select($atributos)
			->join('cad_subcategoria', 'cad_subcategoria.id_subcategoria = cad_produto.subcategoria_id', 'LEFT')
			->join('cad_categoria', 'cad_categoria.id_categoria = cad_subcategoria.categoria_id', 'LEFT')
			->join('cad_fabricante', 'cad_fabricante.id_fabricante = cad_produto.fabricante_id', 'LEFT');

		return $result;
	}
}
