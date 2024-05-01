<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;


class Empresa extends BaseController
{

    public function empresa()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS EMPRESAS CADASTRADOS',
        ];

        return view('modulo/configuracao/empresa', $data);
    }
}
