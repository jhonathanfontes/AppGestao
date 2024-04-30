<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class Categorias extends BaseController
{
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CATEGORIAS CADASTRADAS',
        ];
        return view('modulo/cadastro/categorias', $data);
    }
}
