<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;
use App\Traits\ConfiguracaoTrait;

class Parametro extends BaseController
{
    use ConfiguracaoTrait;

    public function parametro()
    {
        $data = [
            'card_title'  => 'CONFIGURAÇÃO PADRÃO DO SISTEMA',
            'empresas'    => $this->setEmpresas(),
        ];

        return view('modulo/configuracao/parametro', $data);
    }
}
