<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class ProdutoGrade extends Entity
{
    protected $datamap = [
        'codigo'            => 'cod_produtograde',
        'produto_id'        => 'cod_produto',
        'tamanho_id'        => 'cod_tamanho',
        'valor_custo'       => 'valor_custo',
        'valor_vendaavista' => 'valor_avista',
        'valor_vendaprazo'  => 'valor_aprazo',
        'codigobarra'       => 'codigobarra',
        'estoque'           => 'estoque',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
