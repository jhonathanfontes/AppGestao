<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioEmpresaModel extends Model
{
    protected $table = 'cad_usuario_empresa';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'usuario_id',
        'empresa_id',
        'status',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'usuario_id' => 'required|integer',
        'empresa_id' => 'required|integer',
        'status' => 'required|in_list[1,0]'
    ];

    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'O usuário é obrigatório.',
            'integer' => 'O usuário deve ser um número inteiro.'
        ],
        'empresa_id' => [
            'required' => 'A empresa é obrigatória.',
            'integer' => 'A empresa deve ser um número inteiro.'
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser 1 (ativo) ou 0 (inativo).'
        ]
    ];
} 