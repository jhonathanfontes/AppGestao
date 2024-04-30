<?php

namespace App\Controllers\App\Financeiro;

use App\Controllers\BaseController;

class Grupo extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CONTAS A RECEBER',
        ];
        return view('modulo/financeiro/grupo', $data);
    }
    public function show($paramentro)
    {
        return $paramentro;
    }

}
