<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;

class Modulo extends BaseController
{
    public function cadastro()
    {
       echo view('modulo/cadastro');
    }
    public function configuracao()
    {
       echo view('modulo/configuracao');
    }
    public function financeiro()
    {
       echo view('modulo/financeiro');
    }
    public function venda()
    {
       echo view('modulo/venda');
    }
}
