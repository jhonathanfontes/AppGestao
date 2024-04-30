<?php

namespace App\Entities\Venda;

use CodeIgniter\Entity\Entity;

class Devolucao extends Entity
{
    protected $datamap = [];
    protected $dates   = ['dev_data'];
    protected $casts   = [];

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
