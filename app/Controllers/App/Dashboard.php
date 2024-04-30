<?php

namespace App\Controllers\App;
use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {   
        //  dd(getUsuarioLogado()->use_apelido);

        $data = array();
        echo view('dashboard', $data);
    }
}
