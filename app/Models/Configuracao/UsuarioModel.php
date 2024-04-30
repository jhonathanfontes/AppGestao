<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'cad_usuario';
    protected $primaryKey = 'id';
    protected $returnType     = \App\Entities\Configuracao\Usuario::class;
    protected $allowedFields = [
        'use_nome',
        'use_apelido',
        'use_username',
        'use_password',
        'use_email',
        'use_telefone',
        'use_avatar',
        'use_sexo',
        'reset_hash',
        'reset_expired',
        'status',
        'permissao_id',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
        'deleted_at'
    ];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['use_password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }
        return $data;
    }

    public function getUsuario(int $user_id = null)
    {
        $atributos = [
            'id',
            'use_nome',
            'use_apelido',
            'use_username',
            'use_email',
            'use_telefone',
            'use_avatar',
            'use_sexo',
            'status',
            'permissao_id',
        ];
        return $this->select($atributos)
            ->where('id', $user_id)
            ->first();
    }

    public function getDadosUsuario(int $user_id = null)
    {
        return $this->select('use_nome as nome, use_apelido as apelido, use_sexo as sexo, use_avatar as avatar')->first($user_id);
    }

    public function getUsuarioEmail(string $email = null)
    {
        if ($email == null) {
            return null;
        }
        
        return $this->where('use_email', $email)->where('deleted_at', null)->first();
    }

    public function getUsuarioId(int $user_id = null)
    {
        return $this->where('id', $user_id)->first();
    }
}
