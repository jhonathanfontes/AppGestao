<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'cad_empresa';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'email',
        'telefone',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
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
        'razao_social' => 'required|min_length[3]|max_length[100]',
        'nome_fantasia' => 'required|min_length[3]|max_length[100]',
        'cnpj' => 'required|min_length[14]|max_length[14]',
        'inscricao_estadual' => 'permit_empty|min_length[5]|max_length[20]',
        'inscricao_municipal' => 'permit_empty|min_length[5]|max_length[20]',
        'email' => 'required|valid_email|max_length[100]',
        'telefone' => 'required|min_length[10]|max_length[20]',
        'endereco' => 'required|min_length[5]|max_length[200]',
        'numero' => 'required|min_length[1]|max_length[10]',
        'complemento' => 'permit_empty|max_length[100]',
        'bairro' => 'required|min_length[3]|max_length[100]',
        'cidade' => 'required|min_length[3]|max_length[100]',
        'estado' => 'required|min_length[2]|max_length[2]',
        'cep' => 'required|min_length[8]|max_length[8]',
        'status' => 'required|in_list[1,0]'
    ];

    protected $validationMessages = [
        'razao_social' => [
            'required' => 'A razão social é obrigatória.',
            'min_length' => 'A razão social deve ter no mínimo 3 caracteres.',
            'max_length' => 'A razão social deve ter no máximo 100 caracteres.'
        ],
        'nome_fantasia' => [
            'required' => 'O nome fantasia é obrigatório.',
            'min_length' => 'O nome fantasia deve ter no mínimo 3 caracteres.',
            'max_length' => 'O nome fantasia deve ter no máximo 100 caracteres.'
        ],
        'cnpj' => [
            'required' => 'O CNPJ é obrigatório.',
            'min_length' => 'O CNPJ deve ter 14 caracteres.',
            'max_length' => 'O CNPJ deve ter 14 caracteres.'
        ],
        'inscricao_estadual' => [
            'min_length' => 'A inscrição estadual deve ter no mínimo 5 caracteres.',
            'max_length' => 'A inscrição estadual deve ter no máximo 20 caracteres.'
        ],
        'inscricao_municipal' => [
            'min_length' => 'A inscrição municipal deve ter no mínimo 5 caracteres.',
            'max_length' => 'A inscrição municipal deve ter no máximo 20 caracteres.'
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
        'numero' => [
            'required' => 'O número é obrigatório.',
            'min_length' => 'O número deve ter no mínimo 1 caractere.',
            'max_length' => 'O número deve ter no máximo 10 caracteres.'
        ],
        'complemento' => [
            'max_length' => 'O complemento deve ter no máximo 100 caracteres.'
        ],
        'bairro' => [
            'required' => 'O bairro é obrigatório.',
            'min_length' => 'O bairro deve ter no mínimo 3 caracteres.',
            'max_length' => 'O bairro deve ter no máximo 100 caracteres.'
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
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser 1 (ativo) ou 0 (inativo).'
        ]
    ];
} 