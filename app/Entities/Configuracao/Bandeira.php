<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class Bandeira extends Entity

{
    protected $attributes = [
        'id_bandeira'      => null,
        'ban_codigo'    => null,
        'status'        => null
    ];

    protected $datamap = [
        'cod_bandeira'   => 'id_bandeira',
        'cad_bandeira'   => 'ban_descricao'
    ];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_bandeira'] = $this->id_bandeira;
        
        $attribute['cad_codigo'] = [
            'new' => $this->ban_codigo
        ];

        $attribute['cad_bandeira'] = [
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

        $attribute['cod_bandeira'] = $this->id_bandeira;

        if ($this->hasChanged('ban_codigo')) {
            $attribute['cad_codigo'] = [
                'old' => $this->original['ban_codigo'],
                'new' => $this->ban_codigo
            ];
        }
        
        if ($this->hasChanged('ban_descricao')) {
            $attribute['cad_bandeira'] = [
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
