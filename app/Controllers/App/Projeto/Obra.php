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

    public function andamento()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS OBRAS EM ANDAMENTO',
        ];
        return view('modulo/projeto/andamento', $data);
    }

    public function andamento_view(string $serial = null)
    {
        $obra = $this->setObra(null, $serial);

        $data = [
            'card_title' => 'GESTÃO DA OBRA: ' . date("Y", strtotime($obra->created_at)) . completeComZero(esc($obra->id), 8),
            'obra' => $obra,
            'locais' => $this->setLocalObra($obra->id),
        ];
        return view('modulo/projeto/obra_view', $data);
    }

    public function finalizada()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS OBRAS FINALIZADAS',
        ];
        return view('modulo/projeto/finalizada', $data);
    }

    public function finalizada_view(string $serial = null)
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
