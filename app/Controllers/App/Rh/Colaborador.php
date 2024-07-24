<?php

namespace App\Controllers\App\Rh;

use App\Controllers\BaseController;

class Colaborador extends BaseController
{
    public function colaborador()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS COLABORADORES',
            'cad_tipo' => 1
        ];
        return view('modulo/rh/colaborador', $data);
    }

}
