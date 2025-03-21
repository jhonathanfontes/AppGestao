<?php

namespace App\Libraries;

use App\Models\UsuarioModel;
use App\Models\UsuarioEmpresaModel;

class Auth
{
    protected $usuarioModel;
    protected $usuarioEmpresaModel;
    protected $usuario;
    protected $logado = false;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->usuarioEmpresaModel = new UsuarioEmpresaModel();
    }

    public function login(string $email, string $senha): bool
    {
        $usuario = $this->usuarioModel->where('email', $email)->first();

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            return false;
        }

        $this->usuario = $usuario;
        $this->logado = true;

        // Busca as empresas do usuário
        $empresas = $this->usuarioEmpresaModel->where('usuario_id', $usuario['id'])
            ->where('status', 1)
            ->findAll();

        // Se o usuário tiver apenas uma empresa, seleciona automaticamente
        if (count($empresas) === 1) {
            $empresa = $empresas[0];
            session()->set([
                'empresa_id' => $empresa['empresa_id'],
                'empresa_nome' => $empresa['empresa_nome']
            ]);
        }

        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario_nome' => $usuario['nome'],
            'usuario_email' => $usuario['email']
        ]);

        return true;
    }

    public function logout(): void
    {
        session()->destroy();
        $this->usuario = null;
        $this->logado = false;
    }

    public function getUsuario(): ?array
    {
        return $this->usuario;
    }

    public function getLogado(): bool
    {
        return $this->logado;
    }

    public function getEmpresaId(): ?int
    {
        return session('empresa_id');
    }

    public function getEmpresaNome(): ?string
    {
        return session('empresa_nome');
    }
} 