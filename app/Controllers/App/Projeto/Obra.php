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

    public function view(string $serial = null)
    {
        $obra = $this->setObra(null, $serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra->created_at)) . completeComZero(esc($obra->id), 8),
            'obra' => $obra,
            'locais' => $this->setLocalObra($obra->id),
        ];
        return view('modulo/projeto/obra_view', $data);
    }

}
