<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Profissao extends Entity
{
    protected $datamap = [
        'cod_profissao' => 'id',
        'cad_profissao' => 'pro_descricao'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
