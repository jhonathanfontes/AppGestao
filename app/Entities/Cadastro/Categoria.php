<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Categoria extends Entity
{
    protected $attributes = [
        'id' => null,
        'cat_descricao' => null,
        'cat_tipo' => null,
        'status' => null,

    ];

    protected $datamap = [
        'cod_categoria' => 'id',
        'cad_categoria' => 'cat_descricao',
        'cat_tipo' => 'cod_tipo'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function auditoriaInsertAtributos()
    {
        $attribute['cod_categoria'] = $this->id;

        $attribute['cad_categoria'] = [
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

        $attribute['cod_categoria'] = $this->id;

        if ($this->hasChanged('cat_descricao')) {
            $attribute['cad_categoria'] = [
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
