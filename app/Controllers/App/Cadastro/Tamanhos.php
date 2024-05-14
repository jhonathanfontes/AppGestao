<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

class Tamanhos extends BaseController
{
    public function produto()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS TAMANHOS CADASTRADOS',
            'cad_tipo' => 1
        ];
        return view('modulo/cadastro/tamanhos', $data);
    }

    public function servico()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS UNIDADES MEDIDAS CADASTRADOS',
            'cad_tipo' => 2
        ];
        return view('modulo/cadastro/tamanhos', $data);
    }
}
