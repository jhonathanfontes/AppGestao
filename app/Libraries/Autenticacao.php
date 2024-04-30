<?php

namespace App\Libraries;

class Autenticacao
{
    private $usuario;
    private $usuarioModel;
    private $permissaoModel;

    public function __construct()
    {
        $this->usuarioModel = new \App\Models\Configuracao\UsuarioModel();
        $this->permissaoModel = new \App\Models\Configuracao\PermissaoModel();
    }

    public function login(string $email, string $password): bool
    {
        $usuario = $this->usuarioModel->getUsuarioEmail($email);

        if ($usuario === null) {
            return false;
        }

        if ($usuario->verificaPassword($password) == false) {
            return false;
        }

        if ($usuario->status <> 1) {
            return false;
        }

        $this->logaUsuario($usuario);

        return true;
    }

    public function logout(): void
    {
        session()->destroy();
    }

    public function usuarioLogado()
    {
        if ($this->usuario === null) {
            $this->usuario = $this->usuarioLogadoSession();
        }
   

        $usuario = $this->usuarioModel->getUsuarioId(session()->get('jb_usuarioID'));

        if ($usuario === null) {
            return null;
        }
        if ($usuario->status <> 1) {
            return null;
        }

        return $usuario;
    }

    public function getlogado(): bool
    {
        return $this->usuarioLogado() !== null;
    }

    private function logaUsuario(object $usuario): void
    {
        $session = session();

        //$session->regenerate();  // <--- NÃO USEM ESSE MÉTODO DA CLASSE SESSION. Nos testes que eu fiz, ele remove da sessão o 'usuario_id', quando há o redirect

        $_SESSION['__ci_last_regenerate'] = time(); // UTILIZEM essa instrução que o efeito é o mesmo e funciona perfeitamente.

        $session->set('jb_usuarioID', $usuario->id_usuario);
    }

    private function usuarioLogadoSession()
    {
        if (session()->has('jb_usuarioID') == false) {
            return null;
        }

        $usuario = $this->usuarioModel->find(session()->get('jb_usuarioID'));

        if ($usuario == null || $usuario->status <> 1) {
            return null;
        }

        return $usuario;
    }

    private function isAdmin(): bool
    {
        $admin = $this->permissaoModel->getPermissaoAdmin(session()->get('jb_usuarioID'));
        if ($admin == null) {
            return false;
        }
        return true;
    }
}
