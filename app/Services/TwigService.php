<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigService
{
    private static $instance = null;
    private $twig;

    private function __construct()
    {
        $loader = new FilesystemLoader(APPPATH . 'Views');
        $this->twig = new Environment($loader, [
            'cache' => WRITEPATH . 'cache/twig',
            'debug' => ENVIRONMENT === 'development',
            'auto_reload' => ENVIRONMENT === 'development',
        ]);

        // Adiciona funções globais
        $this->twig->addGlobal('base_url', base_url());
        $this->twig->addGlobal('site_url', site_url());
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function render($template, $data = [])
    {
        return $this->twig->render($template . '.twig', $data);
    }

    public function addGlobal($name, $value)
    {
        $this->twig->addGlobal($name, $value);
    }

    public function addFunction($name, $callback)
    {
        $this->twig->addFunction(new \Twig\TwigFunction($name, $callback));
    }
} 