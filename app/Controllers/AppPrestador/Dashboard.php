<?php

namespace App\Controllers\AppPrestador;

use App\Controllers\AppPrestador\PrestadorBaseController;


class Dashboard extends PrestadorBaseController
{
    public function index()
    {

        // $autenticacao = service('autenticacao');
        //  dd(getUsuarioID());
        // dd(session()->get('jb_usuarioApelido'));

        $data = array();
        echo view('prestador/dashboard', $data);
    }
}
