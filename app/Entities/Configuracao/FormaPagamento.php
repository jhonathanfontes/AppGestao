<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class FormaPagamento extends Entity

{
    protected $attributes = [
        'id_forma'  => null,
        'for_descricao' => null,
        'for_forma' => null,
        'for_prazo' => null,
        'for_taxa' => null,
        'for_parcela' => null,
        'conta_id' => null,
        'status'        => null,

    ];

    protected $datamap = [
        'cod_forma'         => 'id_forma',
        'cad_descricao'     => 'for_descricao',
        'cad_forma'         => 'for_forma',
        'cad_fprazo'        => 'for_prazo',
        'cad_ftaxa'         => 'for_taxa',
        'cad_parcela'       => 'for_parcela',
        'cad_antecipa'      => 'for_antecipa',
        'cod_maquinacartao' => 'maquinacartao_id',
        'cad_conta'         => 'conta_id'
    ];

    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    public function auditoriaAtributos()
    {
        $attribute = [];

        $attribute['cod_forma'] = $this->id_forma;

        if ($this->hasChanged('for_descricao')) {
            $attribute['cad_descricao'] = [
                'old' => $this->original['for_descricao'],
                'new' => $this->for_descricao
            ];
        }
        if ($this->hasChanged('for_forma')) {
            $attribute['cad_forma'] = [
                'old' => $this->original['for_forma'],
                'new' => $this->for_forma
            ];
        }
        if ($this->hasChanged('for_prazo')) {
            $attribute['cad_fprazo'] = [
                'old' => $this->original['for_prazo'],
                'new' => $this->for_prazo
            ];
        }
        if ($this->hasChanged('for_taxa')) {
            $attribute['cad_ftaxa'] = [
                'old' => $this->original['for_taxa'],
                'new' => $this->for_taxa
            ];
        }
        if ($this->hasChanged('for_parcela')) {
            $attribute['cad_parcela'] = [
                'old' => $this->original['for_parcela'],
                'new' => $this->for_parcela
            ];
        }
        if ($this->hasChanged('conta_id')) {
            $attribute['cad_conta'] = [
                'old' => $this->original['conta_id'],
                'new' => $this->conta_id
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
