<?php

namespace App\Controllers\App\Projeto;

use App\Controllers\BaseController;

use App\Traits\ProjetoTrait;

class Obra extends BaseController
{
    use ProjetoTrait;
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
            'card_title' => 'GESTÃO DA OBRA: ' . completeComZero($codigo, 8),
            'obra' => $this->setObra($codigo),
            'locais' => $this->setLocalObra($codigo),
        ];
        return view('modulo/projeto/obra_view', $data);
    }
    public function view_local(int $cod_obra = null, int $cod_local = null)
    {
        $local = $this->setLocal($cod_obra, $cod_local);
        if (!isset($local)) {
            echo 'Local Não existe';
        }
        $data = [
            'card_title' => 'CADASTRO DA PESSOA ' . $cod_obra . ' CADASTRO DA PESSOA ' . $cod_local,
            'obra' => $this->setObra($cod_obra),
            'local' => $this->setLocal($cod_obra, $cod_local),
        ];
        return view('modulo/projeto/obra_local_view', $data);
    }

}
