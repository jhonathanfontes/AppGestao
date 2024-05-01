<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;
use App\Traits\ConfiguracaoTrait;

class FormaPagamento extends BaseController
{
    use ConfiguracaoTrait;

    public function formaspagamentos()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS FORMAS DE PAGAMENTO CADASTRADAS',
            'formapagamento'     => [
                'maquina' => $this->setMaquinaCartao(),
                'conta' => $this->setContaBancaria()
            ],
        ];

        return view('modulo/configuracao/formaspagamentos', $data);
    }

    public function view(int $codigo = null)
    {
        $data = [
            'card_title'        => 'CADASTRO DA PESSOA' . $codigo,
            'formapagamento'    => $this->setFormaPagamentoSelecionado($codigo),
            'bandeiras'         => $this->setBandeirasCartoes(),
        ];
        return view('modulo/configuracao/formaspagamentos_view', $data);
    }
}
