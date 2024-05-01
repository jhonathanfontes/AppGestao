<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

class GruposDeAcesso extends BaseController
{
    public function gruposdeacesso()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS GRUPOS DE ACESSO CADASTRADOS',
        ];

        return view('modulo/configuracao/gruposdeacesso', $data);
    }

    public function view(int $codigo = null)
    {
        $data = [
            'card_title'        => 'GRUPOS DE ACESSO - ' . $codigo,
        ];

        return view('modulo/configuracao/gruposdeacesso', $data);
    }
}
