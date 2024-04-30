<?php

namespace App\Models\Cadastro;

use CodeIgniter\Model;

class ProdutoGradeModel extends Model
{
    protected $table      = 'pdv_produtograde';
    protected $primaryKey = 'codigo';
    protected $returnType = \App\Entities\Cadastro\ProdutoGrade::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'produto_id',
        'tamanho_id',
        'valor_custo',
        'valor_vendaavista',
        'valor_vendaprazo',
        'codigobarra',
        'estoque',
        'status',
    ];

    protected $useTimestamps = false;

    protected $skipValidation     = true;

    protected $beforeInsert = ['insertAuditoria'];
    protected $beforeUpdate = ['updateAuditoria'];

    protected function insertAuditoria(array $data)
    {
        $data['data']['created_user_id'] = getUsuarioID();
        $data['data']['created_at']      = getDatetimeAtual();
        return $data;
    }

    protected function updateAuditoria(array $data)
    {
        $data['data']['updated_user_id'] = getUsuarioID();
        $data['data']['updated_at']      = getDatetimeAtual();
        return $data;
    }

    public function returnSave(int $codigo = null)
    {
        return $this->select('produto_id, tamanho_id')->find($codigo);
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
            $data['deleted_at']      = getDatetimeAtual();
            return $this->update($codigo, $data);
        }
        return false;
    }

    public function getTamanhosProdutoGrade(int $codigo)
    {
        $atributos = '  pdv_produtograde.codigo as cod_produtograde,
                        pdv_produtograde.produto_id as cod_produto,
                        cad_produto.pro_descricao as des_produto,
                        pdv_produtograde.tamanho_id as cod_tamanho,
                        cad_tamanho.tam_descricao as des_tamanho,                  
                        pdv_produtograde.valor_custo,
                        pdv_produtograde.valor_vendaavista as valor_avista,
                        pdv_produtograde.valor_vendaprazo as valor_aprazo,
                        pdv_produtograde.estoque,
                        pdv_produtograde.status';

        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select($atributos);
        $builder->join('cad_produto', 'cad_produto.id_produto = pdv_produtograde.produto_id');
        $builder->join('cad_tamanho', 'cad_tamanho.id_tamanho = pdv_produtograde.tamanho_id');
        $builder->where('pdv_produtograde.produto_id', $codigo);
        $builder->whereIn('pdv_produtograde.status', ['1', '2', '3']);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getProdutoGrade()
    {
        $atributos = '  pdv_produtograde.codigo as cod_produtograde,
                        pdv_produtograde.produto_id as cod_produto,
                        cad_produto.pro_descricao as des_produto,
                        cad_produto.pro_descricao_pvd as des_produto_pvd,
                        cad_produto.fabricante_id as cod_fabricante,
                        cad_fabricante.fab_descricao as cad_fabricante,
                        cad_produto.pro_codigobarras as codigobarras,
                        pdv_produtograde.tamanho_id as cod_tamanho,
                        cad_tamanho.tam_descricao as des_tamanho,                  
                        pdv_produtograde.valor_custo,
                        pdv_produtograde.valor_vendaavista as valor_avista,
                        pdv_produtograde.valor_vendaprazo as valor_aprazo,
                        pdv_produtograde.estoque,
                        pdv_produtograde.status';

        return $this->select($atributos)
            ->join('cad_produto', 'cad_produto.id_produto = pdv_produtograde.produto_id')
            ->join('cad_tamanho', 'cad_tamanho.id_tamanho = pdv_produtograde.tamanho_id')
            ->join('cad_fabricante', 'cad_fabricante.id_fabricante = cad_produto.fabricante_id');
    }
}
