<?php

namespace App\Models;

use CodeIgniter\Model;

class ColaboradorModel extends Model
{
    protected $table = 'cad_colaborador';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'empresa_id',
        'nome',
        'cpf',
        'rg',
        'data_nascimento',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'cargo',
        'data_admissao',
        'salario_base',
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
        'empresa_id' => 'required|integer',
        'nome' => 'required|min_length[3]|max_length[100]',
        'cpf' => 'required|min_length[11]|max_length[11]',
        'rg' => 'required|min_length[5]|max_length[20]',
        'data_nascimento' => 'required|valid_date',
        'email' => 'required|valid_email|max_length[100]',
        'telefone' => 'required|min_length[10]|max_length[20]',
        'endereco' => 'required|min_length[5]|max_length[200]',
        'cidade' => 'required|min_length[3]|max_length[100]',
        'estado' => 'required|min_length[2]|max_length[2]',
        'cep' => 'required|min_length[8]|max_length[8]',
        'cargo' => 'required|min_length[3]|max_length[100]',
        'data_admissao' => 'required|valid_date',
        'salario_base' => 'required|numeric',
        'status' => 'required|in_list[1,0]'
    ];

    protected $validationMessages = [
        'empresa_id' => [
            'required' => 'A empresa é obrigatória.',
            'integer' => 'A empresa deve ser um número inteiro.'
        ],
        'nome' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter no mínimo 3 caracteres.',
            'max_length' => 'O nome deve ter no máximo 100 caracteres.'
        ],
        'cpf' => [
            'required' => 'O CPF é obrigatório.',
            'min_length' => 'O CPF deve ter 11 caracteres.',
            'max_length' => 'O CPF deve ter 11 caracteres.'
        ],
        'rg' => [
            'required' => 'O RG é obrigatório.',
            'min_length' => 'O RG deve ter no mínimo 5 caracteres.',
            'max_length' => 'O RG deve ter no máximo 20 caracteres.'
        ],
        'data_nascimento' => [
            'required' => 'A data de nascimento é obrigatória.',
            'valid_date' => 'A data de nascimento é inválida.'
        ],
        'email' => [
            'required' => 'O e-mail é obrigatório.',
            'valid_email' => 'O e-mail é inválido.',
            'max_length' => 'O e-mail deve ter no máximo 100 caracteres.'
        ],
        'telefone' => [
            'required' => 'O telefone é obrigatório.',
            'min_length' => 'O telefone deve ter no mínimo 10 caracteres.',
            'max_length' => 'O telefone deve ter no máximo 20 caracteres.'
        ],
        'endereco' => [
            'required' => 'O endereço é obrigatório.',
            'min_length' => 'O endereço deve ter no mínimo 5 caracteres.',
            'max_length' => 'O endereço deve ter no máximo 200 caracteres.'
        ],
        'cidade' => [
            'required' => 'A cidade é obrigatória.',
            'min_length' => 'A cidade deve ter no mínimo 3 caracteres.',
            'max_length' => 'A cidade deve ter no máximo 100 caracteres.'
        ],
        'estado' => [
            'required' => 'O estado é obrigatório.',
            'min_length' => 'O estado deve ter 2 caracteres.',
            'max_length' => 'O estado deve ter 2 caracteres.'
        ],
        'cep' => [
            'required' => 'O CEP é obrigatório.',
            'min_length' => 'O CEP deve ter 8 caracteres.',
            'max_length' => 'O CEP deve ter 8 caracteres.'
        ],
        'cargo' => [
            'required' => 'O cargo é obrigatório.',
            'min_length' => 'O cargo deve ter no mínimo 3 caracteres.',
            'max_length' => 'O cargo deve ter no máximo 100 caracteres.'
        ],
        'data_admissao' => [
            'required' => 'A data de admissão é obrigatória.',
            'valid_date' => 'A data de admissão é inválida.'
        ],
        'salario_base' => [
            'required' => 'O salário base é obrigatório.',
            'numeric' => 'O salário base deve ser um número.'
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser 1 (ativo) ou 0 (inativo).'
        ]
    ];
} 