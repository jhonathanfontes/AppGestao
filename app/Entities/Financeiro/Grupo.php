<?php

namespace App\Entities\Financeiro;

use CodeIgniter\Entity\Entity;

class Grupo extends Entity
{
    protected $datamap = [
        'cod_grupo'         => 'id_grupo',
        'cad_grupo'         => 'gru_descricao',
        'cad_tipo'          => 'gru_tipo',
        'cad_classificacao' => 'gru_classificacao',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
