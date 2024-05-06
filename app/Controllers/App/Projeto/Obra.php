<?php

namespace App\Controllers\App\Projeto;

use App\Controllers\BaseController;

class Obra extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS PROJETOS',
        ];
        return view('modulo/projeto/obra', $data);
    }
    public function show($paramentro)
    {
        return $paramentro;
    }

    public function view(int $codigo = null)
    {
        $data = [
            'card_title' => 'CADASTRO DA PESSOA' . $codigo,
            // 'pessoa'     => $this->setPessoaSelecionado($codigo),
        ];
        return view('modulo/projeto/obra_view', $data);
    }

}
