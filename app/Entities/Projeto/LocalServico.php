<?php

namespace App\Entities\Projeto;

use CodeIgniter\Entity\Entity;

class LocalServico extends Entity
{
    protected $attributes = [
        'id' => null,
        'local_id' => null,
        'produto_id' => null,
        'lsv_quantidade' => null,
        'lsv_valor' => null,
        'lsv_total' => null,
        'lsv_observacao' => null,
        'status' => null,

    ];


    protected $datamap = [
        'cod_localservico' => 'id',
        'cod_local' => 'local_id',
        'cod_produto' => 'produto_id',
        'cad_quantidade' => 'lsv_quantidade',
        'cad_valor' => 'lsv_valor',
        'cad_total' => 'lsv_total',
        'cad_observacao' => 'lsv_observacao'
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
