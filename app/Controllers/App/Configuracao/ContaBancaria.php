<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;

use App\Traits\ConfiguracaoTrait;

class ContaBancaria extends BaseController
{
    use ConfiguracaoTrait;

    public function contasbancarias()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CONTAS BANCÁRIAS CADASTRADAS',
            'bancos'     => $this->setBancos(),
            'empresas'    => $this->setEmpresas(),
        ];

        return view('modulo/configuracao/contasbancarias', $data);
    }
    
}
