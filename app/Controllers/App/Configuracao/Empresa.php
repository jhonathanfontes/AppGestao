<?php

namespace App\Controllers\App\Configuracao;

use App\Controllers\BaseController;


class Empresa extends BaseController
{

    public function empresa()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS EMPRESAS CADASTRADOS',
        ];

        return view('modulo/configuracao/empresa', $data);
    }

    public function view(int $codigo = null)
    {
        $data = [
            'card_title' => 'CADASTRO DO EMPRESA' . $codigo,
            // 'produto' => $this->setProdutoSelecionado($codigo),
            // 'grade' => $this->setTamanhosProdutoSelecionado($codigo),
        ];
        return view('modulo/configuracao/empresa_view', $data);
    }
}
