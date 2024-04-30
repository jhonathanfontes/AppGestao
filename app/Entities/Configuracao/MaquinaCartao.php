<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class MaquinaCartao extends Entity

{
    protected $attributes = [
        'id_maquina'  => null,
        'maq_descricao' => null,
        'status'        => null,

    ];

    protected $datamap = [
        'cod_maquinacartao'   => 'id_maquina',
        'cad_maquinacartao'   => 'maq_descricao'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function auditoriaAtributos()
    {
        $attribute = [];

        $attribute['cod_maquinacartao'] = $this->id_maquina;

        if ($this->hasChanged('maq_descricao')) {
            $attribute['cod_maquinacartao'] = [
                'old' => $this->original['maq_descricao'],
                'new' => $this->cat_descricao
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
