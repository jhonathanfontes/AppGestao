<?php

namespace App\Controllers\App\Cadastro;

use App\Controllers\BaseController;

use App\Traits\CadastroTrait;

class Pessoas extends BaseController
{
    use CadastroTrait;
    
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DE CLIENTES E FORNECEDORES',
        ];
        return view('modulo/cadastro/pessoas', $data);
    }

    public function view(int $codigo = null)
    {
        $data = [
            'card_title' => 'CADASTRO DA PESSOA' . $codigo,
            'pessoa'     => $this->setPessoaSelecionado($codigo),
        ];
        return view('modulo/cadastro/pessoa_view', $data);
    }
}
