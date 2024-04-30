<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class Usuario extends Entity
{
    protected $datamap = [
        'cod_usuario'   => 'id',
        'cad_usuario'   => 'use_nome',
        'cad_apelido'   => 'use_apelido',
        'cad_username'  => 'use_username',
        'cad_email'     => 'use_email',
        'cad_telefone'  => 'use_telefone',
        'cad_avatar'    => 'use_avatar',
        'cad_sexo'      => 'use_sexo'
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function auditoriaInsertAtributos()
    {
        $attribute['cod_usuario'] = $this->id_usuario;

        $attribute['cad_usuario'] = [
            'new' => $this->use_nome
        ];

        $attribute['cad_apelido'] = [
            'new' => $this->use_apelido
        ];

        $attribute['status'] = [
            'new' => $this->status
        ];

        return serialize($attribute);
    }

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_usuario'] = $this->id_usuario;

        if ($this->hasChanged('use_nome')) {
            $attribute['cad_usuario'] = [
                'old' => $this->original['use_nome'],
                'new' => $this->use_nome
            ];
        }

        if ($this->hasChanged('use_apelido')) {
            $attribute['cad_apelido'] = [
                'old' => $this->original['use_apelido'],
                'new' => $this->use_apelido
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

    public function verificaPassword(string $password = null)
    {
        return password_verify($password, $this->use_password);
    }

}
