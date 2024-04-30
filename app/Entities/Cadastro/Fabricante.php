<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Fabricante extends Entity
{
    protected $datamap = [
        'cod_fabricante' => 'id_fabricante',
        'cad_fabricante' => 'fab_descricao'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
