<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

class Bandeira extends BaseController
{
    public function bandeiras()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS BANDEIRAS DE CARTÕES CADASTRADOS',
        ];

        return view('modulo/configuracao/bandeiras', $data);
    }
}
