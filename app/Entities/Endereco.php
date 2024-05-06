<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Endereco extends Entity
{
    protected $datamap = [
        'cod_endereco'  => 'id',
        'cad_endereco'  => 'end_endereco',
        'cad_numero'    => 'end_numero',
        'cad_setor'     => 'end_setor',
        'cad_complemento' => 'end_complemento',
        'cad_cidade'    => 'end_cidade',
        'cad_estado'    => 'end_estado',
        'cad_cep'       => 'end_cep'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
}
