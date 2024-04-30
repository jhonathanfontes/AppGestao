<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class Profissoes extends BaseController
{
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS PROFISSÕES',
        ];
        return view('modulo/cadastro/profissoes', $data);
    }
}
