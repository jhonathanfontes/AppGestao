<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;

class Servicos extends BaseController
{
    use CadastroTrait;

    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS SERVIÇOS',
        ];
        return view('modulo/cadastro/servicos', $data);
    }
    public function view(int $codigo = null)
    {
        $data = [
            'card_title' => 'CADASTRO DO PRODUTO' . $codigo,
            'produto'   => $this->setProdutoSelecionado($codigo),
            'grade'     => $this->setTamanhosProdutoSelecionado($codigo),
        ];
        return view('modulo/cadastro/servico_view', $data);
    }
}
