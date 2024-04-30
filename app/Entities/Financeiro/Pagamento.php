<?php

namespace App\Entities\Financeiro;

use CodeIgniter\Entity\Entity;

class Pagamento extends Entity
{
    protected $attributes = [
        'caixa_id'              => null,
        'formapac_id'           => null,
        'conta_id'              => null,
        'pag_formapagamento'    => null,
        'pag_valor'             => null,
        'pag_documento'         => null,
        'pag_parcela'           => null,
        'serial'                => null,
        'situacao'              => null,
        'created_user_id'       => null,
        'updated_user_id'       => null,
        'deleted_user_id'       => null

    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];
}
