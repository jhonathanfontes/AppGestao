<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class SubCategorias extends BaseController
{
    public function index()
    {
        $data['card_title'] = 'RELAÇÃO DAS SUBCATEGORIAS CADASTRADOS';
        return view('modulo/cadastro/subcategorias', $data);
    }
}
