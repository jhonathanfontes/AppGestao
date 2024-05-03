<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Produto extends Entity
{
    protected $datamap = [
        'cod_produto'       => 'id',
        'cod_tipo'          => 'pro_tipo',
        'cad_produto'       => 'pro_descricao',
        'cod_categoria'     => 'categoria_id',
        'cod_fabricante'    => 'tamanho_id',
        'cad_custo'         => 'valor_custo',
        'cad_valor1'        => 'valor_venda1',
        'cad_valor2'        => 'valor_venda2',
        'cad_codbarras'     => 'pro_codigobarras',
        'cad_codbarras'     => 'pro_codigobarras',
        'cad_codbarras'     => 'pro_codigobarras'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}