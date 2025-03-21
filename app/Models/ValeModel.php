<?php

namespace App\Models;

use CodeIgniter\Model;

class ValeModel extends Model
{
    protected $table = 'cad_vale';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'empresa_id',
        'colaborador_id',
        'tipo',
        'valor',
        'data_solicitacao',
        'data_pagamento',
        'status',
        'observacao',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'empresa_id' => 'required|integer',
        'colaborador_id' => 'required|integer',
        'tipo' => 'required|in_list[alimentacao,transporte,outros]',
        'valor' => 'required|numeric',
        'data_solicitacao' => 'required|valid_date',
        'data_pagamento' => 'permit_empty|valid_date',
        'status' => 'required|in_list[pending,approved,rejected,paid]',
        'observacao' => 'permit_empty|max_length[500]'
    ];

    protected $validationMessages = [
        'empresa_id' => [
            'required' => 'A empresa é obrigatória.',
            'integer' => 'A empresa deve ser um número inteiro.'
        ],
        'colaborador_id' => [
            'required' => 'O colaborador é obrigatório.',
            'integer' => 'O colaborador deve ser um número inteiro.'
        ],
        'tipo' => [
            'required' => 'O tipo de vale é obrigatório.',
            'in_list' => 'O tipo de vale deve ser alimentação, transporte ou outros.'
        ],
        'valor' => [
            'required' => 'O valor é obrigatório.',
            'numeric' => 'O valor deve ser um número.'
        ],
        'data_solicitacao' => [
            'required' => 'A data de solicitação é obrigatória.',
            'valid_date' => 'A data de solicitação é inválida.'
        ],
        'data_pagamento' => [
            'valid_date' => 'A data de pagamento é inválida.'
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser pendente, aprovado, rejeitado ou pago.'
        ],
        'observacao' => [
            'max_length' => 'A observação deve ter no máximo 500 caracteres.'
        ]
    ];
} 