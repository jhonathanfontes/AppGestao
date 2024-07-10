<?php

namespace App\Controllers\AppDespacho;

use App\Controllers\AppDespacho\DespachoBaseController;


class Dashboard extends DespachoBaseController
{
    public function index()
    {

        // $autenticacao = service('autenticacao');
        //  dd(getUsuarioID());
        // dd(session()->get('jb_usuarioApelido'));

        $data = array(
            'MODULOS' => [
                'CONTROLLER' => 'home',
                'ICONE' => 'home',
                'TITULO' => 'home',
                'DESCRICAO' => 'home',
            ],
            'TITLE' => "Início"
        );
        // echo $this->twig->render('despacho/dashboard/dashboard.twig', $data);
        echo view('despacho/dashboard', $data);
        // echo view('dashboard', $data);
    }
}
