<?php

namespace App\Entities\Projeto;

use CodeIgniter\Entity\Entity;

class Obra extends Entity
{
    protected $attributes = [
        'id' => null,
        'obr_descricao' => null,
        'obr_datainicio' => null,
        'situacao' => null,

    ];

    protected $datamap = [
        'cod_obra' => 'id',
        'cad_obra' => 'obr_descricao',
        'cad_datainicio' => 'obr_datainicio'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function auditoriaInsertAtributos()
    {
        $attribute['cod_obra'] = $this->id;

        $attribute['cad_obra'] = [
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

        $attribute['cod_obra'] = $this->id;

        if ($this->hasChanged('cat_descricao')) {
            $attribute['cad_obra'] = [
                'old' => $this->original['cat_descricao'],
                'new' => $this->cat_descricao
            ];
        }

        if ($this->hasChanged('situacao')) {
            $attribute['situacao'] = [
                'old' => $this->original['situacao'],
                'new' => $this->situacao
            ];
        }

        return serialize($attribute);
    }
}
