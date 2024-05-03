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

}
