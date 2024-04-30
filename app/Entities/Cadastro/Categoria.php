<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Categoria extends Entity
{
    protected $attributes = [
        'id_categoria'  => null,
        'cat_descricao' => null,
        'status'        => null,

    ];

    protected $datamap = [
        'cod_categoria' => 'id_categoria',
        'cad_categoria' => 'cat_descricao'
    ];

    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    public function setId_categoria(int $cod_categoria)
    {
        $this->attributes['id_categoria'] = $cod_categoria;
        return $this;
    }

    public function setCat_descricao(string $cad_categoria)
    {
        $this->attributes['cat_descricao'] = returnNull(esc($cad_categoria), 'S');
        return $this;
    }

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_categoria'] = $this->id_categoria;
        
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

        $attribute['cod_categoria'] = $this->id_categoria;

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
