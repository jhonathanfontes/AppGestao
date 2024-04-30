<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class SubCategoria extends Entity
{
    protected $datamap = [
        'cod_subcategoria'  => 'id_subcategoria',
        'cod_categoria'     => 'categoria_id',
        'cad_subcategoria'  => 'sub_descricao',
        'cad_comisao'       => 'sub_comissao'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
