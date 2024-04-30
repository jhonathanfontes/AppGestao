<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class Vendedor extends Entity

{
    protected $attributes = [
        'id_vendedor'   => null,
        'usuario_id'    => null,
        'pessoa_id'     => null,
        'status'        => null
    ];

    protected $datamap = [
        'cod_vendedor'  => 'id_vendedor',
        'cod_usuario'   => 'usuario_id',
        'cod_pessoa'    => 'pessoa_id'
    ];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_vendedor'] = $this->id_vendedor;

        $attribute['cod_usuario'] = [
            'new' => $this->usuario_id
        ];

        $attribute['cod_pessoa'] = [
            'new' => $this->pessoa_id
        ];

        $attribute['status'] = [
            'new' => $this->status
        ];

        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_vendedor'] = $this->id_vendedor;

        if ($this->hasChanged('usuario_id')) {
            $attribute['cod_usuario'] = [
                'old' => $this->original['usuario_id'],
                'new' => $this->usuario_id
            ];
        }

        if ($this->hasChanged('pessoa_id')) {
            $attribute['cod_pessoa'] = [
                'old' => $this->original['pessoa_id'],
                'new' => $this->pessoa_id
            ];
        }

        if ($this->hasChanged('status')) {
            $attribute['status'] = [
                'old' => $this->original['status'],
                'new' => $this->status
            ];
        }

        return serialize($attribute);
    }
}
