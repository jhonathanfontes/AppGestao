<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;

class Autenticacao extends BaseController
{
    public function index()
    {
        $data = [];
        helper(['form']);
        return view('autenticacao/login', $data);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('autenticacao'));
    }

    public function EsqueciSenha()
    {
        # code... forgot_password
        $data = [];
        helper(['form']);
        return view('autenticacao/forgot_password', $data);
    }

    public function RedefinirSenha()
    {
        # code... forgot_password
        $data = [];
        helper(['form']);
        return view('autenticacao/recover_password', $data);
    }
}
