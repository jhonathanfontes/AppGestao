<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($arguments)) {
            return;
        }

        $permission = $arguments[0];
        
        if (!auth()->hasPermission($permission)) {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar esta página.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não precisa fazer nada após a requisição
    }
} 