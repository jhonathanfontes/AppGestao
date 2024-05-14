<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class Categorias extends BaseController
{
    public function produto()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CATEGORIAS DOS PRODUTOS CADASTRADAS',
            'cad_tipo' => 1
        ];
        return view('modulo/cadastro/categorias', $data);
    }

    public function servico()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CATEGORIAS DOS SERVIÇOS CADASTRADAS',
            'cad_tipo' => 2
        ];
        return view('modulo/cadastro/categorias', $data);
    }
}
