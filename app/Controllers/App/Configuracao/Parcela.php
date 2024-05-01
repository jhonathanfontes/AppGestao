<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

class Parcela extends BaseController
{
   
    public function parcela()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS PARCELAS CADASTRADAS',
        ];

        return view('modulo/configuracao/parcela', $data);
    }
    
}
