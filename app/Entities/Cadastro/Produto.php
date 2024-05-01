<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Produto extends Entity
{
    protected $datamap = [
        'cod_produto'       => 'id',
        'cod_subcategoria'  => 'subcategoria_id',
        'cod_fabricante'    => 'fabricante_id',
        'cad_produto'       => 'pro_descricao',
        'cad_produto_pdv'   => 'pro_descricao_pvd',
        'cad_fabricante'    => 'pro_cod_fabricante',
        'cad_codigobarras'  => 'pro_codigobarras'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
