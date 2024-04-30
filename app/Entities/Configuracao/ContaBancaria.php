<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class ContaBancaria extends Entity

{
    protected $attributes = [
        'id_conta'      => null,
        'con_tipo'      => null,
        'con_descricao' => null,
        'banco_id'      => null,
        'con_agencia'   => null,
        'con_conta'     => null,
        'tipo_titular'  => null,
        'empresa_id'    => null,
        'con_pagar'     => null,
        'con_receber'   => null,
        'con_titular'   => null,
        'con_documento' => null,
        'status'        => null
    ];

    protected $datamap = [
        'cod_contabancaria' => 'id_conta',
        'cad_banco'         => 'banco_id',
        'cad_agencia'       => 'con_agencia',
        'cad_conta'         => 'con_conta',
        'cad_contabancaria' => 'con_descricao',
        'cad_tipo'          => 'con_tipo',
        'cad_empresa'       => 'empresa_id',
        'cad_pagamento'     => 'con_pagar',
        'cad_recebimento'   => 'con_receber',
        'cad_natureza'      => 'tipo_titular',
        'cad_titular'       => 'con_titular',
        'cad_documento'     => 'con_documento',

    ];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_contabancaria'] = $this->id_conta;

        $attribute['cad_banco'] = [
            'new' => $this->banco_id
        ];

        $attribute['cad_agencia'] = [
            'new' => $this->con_agencia
        ];

        $attribute['cad_conta'] = [
            'new' => $this->con_conta
        ];

        $attribute['cad_contabancaria'] = [
            'new' => $this->con_descricao
        ];

        $attribute['cad_tipo'] = [
            'new' => $this->con_tipo
        ];

        $attribute['cad_empresa'] = [
            'new' => $this->empresa_id
        ];

        $attribute['cad_pagamento'] = [
            'new' => $this->con_pagar
        ];

        $attribute['cad_recebimento'] = [
            'new' => $this->con_receber
        ];

        $attribute['tip_titular'] = [
            'new' => $this->tipo_titular
        ];

        $attribute['cad_titular'] = [
            'new' => $this->con_titular
        ];

        $attribute['cad_documento'] = [
            'new' => $this->con_documento
        ];

        $attribute['status'] = [
            'new' => $this->status
        ];

        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_contabancaria'] = $this->id_conta;

        if ($this->hasChanged('banco_id')) {
            $attribute['cad_banco'] = [
                'old' => $this->original['banco_id'],
                'new' => $this->banco_id
            ];
        }

        if ($this->hasChanged('con_agencia')) {
            $attribute['cad_agencia'] = [
                'old' => $this->original['con_agencia'],
                'new' => $this->con_agencia
            ];
        }

        if ($this->hasChanged('con_conta')) {
            $attribute['cad_conta'] = [
                'old' => $this->original['con_conta'],
                'new' => $this->con_conta
            ];
        }

        if ($this->hasChanged('con_descricao')) {
            $attribute['cad_contabancaria'] = [
                'old' => $this->original['con_descricao'],
                'new' => $this->con_descricao
            ];
        }

        if ($this->hasChanged('con_tipo')) {
            $attribute['cad_tipo'] = [
                'old' => $this->original['con_tipo'],
                'new' => $this->con_tipo
            ];
        }

        if ($this->hasChanged('empresa_id')) {
            $attribute['cad_empresa'] = [
                'old' => $this->original['empresa_id'],
                'new' => $this->empresa_id
            ];
        }

        if ($this->hasChanged('con_pagar')) {
            $attribute['cad_pagamento'] = [
                'old' => $this->original['con_pagar'],
                'new' => $this->con_pagar
            ];
        }

        if ($this->hasChanged('con_receber')) {
            $attribute['cad_recebimento'] = [
                'old' => $this->original['con_receber'],
                'new' => $this->con_receber
            ];
        }

        if ($this->hasChanged('tipo_titular')) {
            $attribute['tip_titular'] = [
                'old' => $this->original['tipo_titular'],
                'new' => $this->tipo_titular
            ];
        }

        if ($this->hasChanged('con_titular')) {
            $attribute['cad_titular'] = [
                'old' => $this->original['con_titular'],
                'new' => $this->con_titular
            ];
        }

        if ($this->hasChanged('con_documento')) {
            $attribute['cad_documento'] = [
                'old' => $this->original['con_documento'],
                'new' => $this->con_documento
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
