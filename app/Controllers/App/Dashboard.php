<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {

        // $autenticacao = service('autenticacao');
        //  dd(getUsuarioID());
        // dd(session()->get('jb_usuarioApelido'));

        $data = array();
        echo view('dashboard', $data);
    }
}
