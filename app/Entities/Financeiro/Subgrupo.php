<?php

namespace App\Entities\Financeiro;

use CodeIgniter\Entity\Entity;

class Subgrupo extends Entity
{
    protected $datamap = [
        'cod_subgrupo'  => 'id_subgrupo',
        'cod_grupo'     => 'grupo_id',
        'cad_subgrupo'  => 'sub_descricao',
        'vendapadrao'   => 'sub_vendapadrao',
        'folhapadrado'  => 'sub_folhapadrado',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
