<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\TwigService;

class TwigFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Configura o Twig como view renderer padrão
        $twig = TwigService::getInstance();
        
        // Adiciona funções úteis
        $twig->addFunction('csrf_field', function() {
            return csrf_field();
        });
        
        $twig->addFunction('csrf_token', function() {
            return csrf_token();
        });
        
        $twig->addFunction('old', function($key, $default = '') {
            return old($key, $default);
        });
        
        $twig->addFunction('session', function($key = null) {
            return session($key);
        });
        
        $twig->addFunction('auth', function() {
            return auth();
        });
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não precisa fazer nada após a requisição
    }
} 