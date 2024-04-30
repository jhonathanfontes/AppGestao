<?php

namespace App\Entities\Financeiro;

use CodeIgniter\Entity\Entity;

class ContaReceber extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_contareceber'] = $this->id_receber;

        $attribute['cod_pessoa'] = [
            'new' => $this->pessoa_id
        ];

        $attribute['situacao'] = [
            'new' => $this->situacao
        ];

        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_contareceber'] = $this->id_receber;

        if ($this->hasChanged('pessoa_id')) {
            $attribute['cod_pessoa'] = [
                'old' => $this->original['pessoa_id'],
                'new' => $this->pessoa_id
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
