<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

class MaquinaCartao extends BaseController
{
   
    public function maquinascartoes()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS MAQUINAS DE CARTÕES CADASTRADAS',
        ];

        return view('modulo/configuracao/maquinascartoes', $data);
    }
    
}
