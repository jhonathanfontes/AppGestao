<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class Fabricantes extends BaseController
{
    public function index()
    {
        $data['card_title'] = 'RELAÇÃO DOS FABRICANTES DOS PRODUTOS';
        return view('modulo/cadastro/fabricantes', $data);
    }
}
