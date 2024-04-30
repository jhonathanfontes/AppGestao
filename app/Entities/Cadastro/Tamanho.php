<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Tamanho extends Entity
{
    protected $datamap = [
        'cod_tamanho'   => 'id_tamanho',
        'cad_abreviacao' => 'tam_abreviacao',
        'cad_tamanho'   => 'tam_descricao',
        'cad_embalagem' => 'tam_quantidade',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
