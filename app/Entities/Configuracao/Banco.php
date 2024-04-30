<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class Banco extends Entity

{
    protected $attributes = [
        'id_banco'      => null,
        'ban_codigo'    => null,
        'ban_descricao' => null,
        'status'        => null
    ];

    protected $datamap = [
        'cod_banco'   => 'id_banco',
        'cad_codigo'  => 'ban_codigo',
        'cad_banco'   => 'ban_descricao'
    ];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_banco'] = $this->id_banco;
        
        $attribute['cad_codigo'] = [
            'new' => $this->ban_codigo
        ];

        $attribute['cad_banco'] = [
            'new' => $this->ban_descricao
        ];
       
        $attribute['status'] = [
            'new' => $this->status
        ];
       
        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_banco'] = $this->id_banco;

        if ($this->hasChanged('ban_codigo')) {
            $attribute['cad_codigo'] = [
                'old' => $this->original['ban_codigo'],
                'new' => $this->ban_codigo
            ];
        }
        
        if ($this->hasChanged('ban_descricao')) {
            $attribute['cad_banco'] = [
                'old' => $this->original['ban_descricao'],
                'new' => $this->ban_descricao
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
