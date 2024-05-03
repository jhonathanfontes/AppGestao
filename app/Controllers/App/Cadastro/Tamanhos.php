<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class Tamanhos extends BaseController
{
    public function index()
    {
        $data['card_title'] = 'RELAÇÃO DOS TAMANHOS/UNIDADES MEDIDAS CADASTRADOS';
        return view('modulo/cadastro/tamanhos', $data);
    }
}
