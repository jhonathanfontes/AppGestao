<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

class Banco extends BaseController
{
    public function bancos()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS BANCOS CADASTRADOS',
        ];

        return view('modulo/configuracao/bancos', $data);
    }
}
