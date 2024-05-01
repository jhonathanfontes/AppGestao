<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;
use App\Traits\ConfiguracaoTrait;

class Vendedor extends BaseController
{
    use ConfiguracaoTrait;
    use CadastroTrait;
    
    public function vendedores()
    {
        $data = [
            'card_title'    => 'RELAÇÃO DOS VENDEDORES CADASTRADOS',
            'fornecedores'  => $this->setPessoasFornecedores(),
            'usuarios'      => $this->setUsuarios(),
        ];

        return view('modulo/configuracao/vendedores', $data);
    }
}
