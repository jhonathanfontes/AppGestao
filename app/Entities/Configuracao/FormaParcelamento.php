<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class FormaParcelamento extends Entity

{
    protected $attributes = [
        'id_formapac'   => null,
        'forma_id'      => null,
        'bandeira_id'   => null,
        'fpc_parcela'   => null,
        'fpc_prazo'     => null,
        'fpc_taxa'      => null,
        'status'        => null,

    ];

    protected $datamap = [
        'cod_formapac'      => 'id_formapac',
        'cod_formapag'      => 'forma_id',
        'cad_bandeira'      => 'bandeira_id',
        'cad_parcela'       => 'fpc_parcela',
        'cad_prazo'         => 'fpc_prazo',
        'cad_taxa'          => 'fpc_taxa'
    ];

    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    public function auditoriaAtributos()
    {
        $attribute = [];

        $attribute['cod_formapac'] = $this->id_formapac;

        if ($this->hasChanged('forma_id')) {
            $attribute['cod_formapag'] = [
                'old' => $this->original['forma_id'],
                'new' => $this->forma_id
            ];
        }
        if ($this->hasChanged('bandeira_id')) {
            $attribute['cad_bandeira'] = [
                'old' => $this->original['bandeira_id'],
                'new' => $this->bandeira_id
            ];
        }if ($this->hasChanged('fpc_parcela')) {
            $attribute['cad_parcela'] = [
                'old' => $this->original['fpc_parcela'],
                'new' => $this->fpc_parcela
            ];
        }
        if ($this->hasChanged('fpc_prazo')) {
            $attribute['cad_prazo'] = [
                'old' => $this->original['fpc_prazo'],
                'new' => $this->fpc_prazo
            ];
        }
        if ($this->hasChanged('fpc_taxa')) {
            $attribute['cad_prazo'] = [
                'old' => $this->original['fpc_taxa'],
                'new' => $this->fpc_taxa
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
