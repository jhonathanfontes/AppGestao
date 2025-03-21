<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'cad_usuario';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'nome',
        'email',
        'senha',
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
        'nome' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]|is_unique[cad_usuario.email,id,{id}]',
        'senha' => 'required|min_length[6]|max_length[255]',
        'status' => 'required|in_list[1,0]'
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter no mínimo 3 caracteres.',
            'max_length' => 'O nome deve ter no máximo 100 caracteres.'
        ],
        'email' => [
            'required' => 'O e-mail é obrigatório.',
            'valid_email' => 'O e-mail é inválido.',
            'max_length' => 'O e-mail deve ter no máximo 100 caracteres.',
            'is_unique' => 'Este e-mail já está em uso.'
        ],
        'senha' => [
            'required' => 'A senha é obrigatória.',
            'min_length' => 'A senha deve ter no mínimo 6 caracteres.',
            'max_length' => 'A senha deve ter no máximo 255 caracteres.'
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser 1 (ativo) ou 0 (inativo).'
        ]
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['senha'])) {
            return $data;
        }

        $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        return $data;
    }
} 