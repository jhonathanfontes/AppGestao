<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

class Usuarios extends BaseController
{
    public function usuarios()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS USUARIOS CADASTRADOS',
        ];

        return view('modulo/configuracao/usuarios', $data);
    }
}
