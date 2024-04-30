<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Profissao extends Entity
{
    protected $datamap = [
        'cod_profissao' => 'id_profissao',
        'cad_profissao' => 'prof_descricao'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
