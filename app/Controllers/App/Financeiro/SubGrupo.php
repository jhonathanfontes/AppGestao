<?php

namespace App\Controllers\App\Financeiro;

use App\Controllers\BaseController;

class SubGrupo extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS SUBGRUPOS - FINANCEIROS',
        ];
        return view('modulo/financeiro/subgrupo', $data);
    }
    public function show($paramentro)
    {
        return $paramentro;
    }

}
