<?php

namespace App\Entities\Projeto;

use CodeIgniter\Entity\Entity;

class Local extends Entity
{
    protected $attributes = [
        'id' => null,
        'loc_descricao' => null,
        'loc_datainicio' => null,
        'obra_id ' => null,
        'status' => null,

    ];

    protected $datamap = [
        'cod_local' => 'id',
        'cad_local' => 'loc_descricao',
        'cad_datainicio' => 'loc_datainicio',
        'cod_obra' => 'obra_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function auditoriaInsertAtributos()
    {
        $attribute['cod_local'] = $this->id;

        $attribute['cad_local'] = [
            'new' => $this->cat_descricao
        ];

        $attribute['status'] = [
            'new' => $this->status
        ];

        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_local'] = $this->id;

        if ($this->hasChanged('cat_descricao')) {
            $attribute['cad_local'] = [
                'old' => $this->original['cat_descricao'],
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
