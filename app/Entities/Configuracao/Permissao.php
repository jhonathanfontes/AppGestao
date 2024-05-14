<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class Permissao extends Entity

{
    protected $attributes = [
        'id'     => null,
        'per_descricao'    => null
    ];

    protected $datamap = [
        'cod_permissao'  => 'id',
        'cad_permissao'  => 'per_descricao'
    ];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_permissao'] = $this->id;

        $attribute['cad_permissao'] = [
            'new' => $this->per_descricao
        ];
        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_permissao'] = $this->id;

        if ($this->hasChanged('per_descricao')) {
            $attribute['cad_permissao'] = [
                'old' => $this->original['per_descricao'],
                'new' => $this->per_descricao
            ];
        }
        return serialize($attribute);
    }
}
