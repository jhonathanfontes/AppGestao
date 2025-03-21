<?php

namespace App\Models;

use CodeIgniter\Model;

class SalarioModel extends Model
{
    protected $table = 'cad_salario';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'colaborador_id',
        'salario_valor',
        'data_inicio',
        'data_fim',
        'tipo_salario',
        'observacao',
        'status',
        'empresa_id',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'colaborador_id' => 'required|integer',
        'salario_valor' => 'required|numeric',
        'data_inicio' => 'required|valid_date',
        'data_fim' => 'permit_empty|valid_date',
        'tipo_salario' => 'required|in_list[base,adicional,bonus]',
        'status' => 'required|in_list[1,2,3,9]'
    ];

    protected $validationMessages = [
        'colaborador_id' => [
            'required' => 'O colaborador é obrigatório.',
            'integer' => 'O colaborador deve ser um número inteiro.'
        ],
        'salario_valor' => [
            'required' => 'O valor do salário é obrigatório.',
            'numeric' => 'O valor do salário deve ser um número.'
        ],
        'data_inicio' => [
            'required' => 'A data de início é obrigatória.',
            'valid_date' => 'A data de início deve ser uma data válida.'
        ],
        'data_fim' => [
            'valid_date' => 'A data de fim deve ser uma data válida.'
        ],
        'tipo_salario' => [
            'required' => 'O tipo de salário é obrigatório.',
            'in_list' => 'O tipo de salário deve ser base, adicional ou bônus.'
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser 1 (Habilitado), 2 (Desativado), 3 (Pendente) ou 9 (Arquivado).'
        ]
    ];
} 