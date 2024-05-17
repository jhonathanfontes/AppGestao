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
        ];
        return view('modulo/configuracao/formaspagamentos_view', $data);
    }
}
