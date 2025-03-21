<?php

namespace App\Controllers;

use App\Libraries\Auth;

class AutenticacaoController extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function index()
    {
        if ($this->auth->getLogado()) {
            return redirect()->to(base_url('app/dashboard'));
        }

        return view('autenticacao/login');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        if ($this->auth->login($email, $senha)) {
            // Se o usuário tiver apenas uma empresa, redireciona para o dashboard
            if ($this->auth->getEmpresaId()) {
                return redirect()->to(base_url('app/dashboard'));
            }

            // Caso contrário, redireciona para a seleção de empresa
            return redirect()->to(base_url('empresas/selecionar'));
        }

        return redirect()->back()->with('error', 'Email ou senha inválidos');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->to(base_url('login'));
    }
} 