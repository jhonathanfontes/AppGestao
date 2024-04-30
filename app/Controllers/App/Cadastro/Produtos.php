<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;

class Produtos extends BaseController
{
    use CadastroTrait;

    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS PRODUTOS',
        ];
        return view('modulo/cadastro/produtos', $data);
    }
    public function view(int $codigo = null)
    {
        $data = [
            'card_title' => 'CADASTRO DO PRODUTO' . $codigo,
            'produto'   => $this->setProdutoSelecionado($codigo),
            'grade'     => $this->setTamanhosProdutoSelecionado($codigo),
        ];
        return view('modulo/cadastro/produto_view', $data);
    }
}
