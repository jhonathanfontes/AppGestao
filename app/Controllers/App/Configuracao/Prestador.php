<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;
use App\Traits\ConfiguracaoTrait;

class Prestador extends BaseController
{
    use ConfiguracaoTrait;
    use CadastroTrait;
    
    public function prestadores()
    {
        $data = [
            'card_title'    => 'RELAÇÃO DOS PRESTADORES DE SERVIÇO CADASTRADOS',
            'fornecedores'  => $this->setPessoasFornecedores(),
            'usuarios'      => $this->setUsuarios(),
        ];

        return view('modulo/configuracao/prestadores', $data);
    }
}
