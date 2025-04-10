<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Auth;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['permissao', 'jbsystem', 'form', 'html', 'xml', 'autenticacao'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    protected $auth;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->auth = new Auth();
    }

    protected function getRequest()
    {
        if ($this->request instanceof IncomingRequest) {
            return $this->request;
        }

        return new IncomingRequest(
            new CLIRequest(),
            new \CodeIgniter\HTTP\Response()
        );
    }

    protected function getEmpresaId(): ?int
    {
        return $this->auth->getEmpresaId();
    }

    protected function getEmpresaNome(): ?string
    {
        return $this->auth->getEmpresaNome();
    }

    protected function verificarEmpresa(): bool
    {
        if (!$this->getEmpresaId()) {
            return redirect()->to(base_url('empresas/selecionar'));
        }

        return true;
    }

    protected function usuarioLogado()
    {
        return service('autenticacao')->usuarioLogado();
    }

    protected function exibirArquivo(string $destino, string $arquivo)
    {
        $path = WRITEPATH . "uploads/$destino/$arquivo";

        $fileInfo = new \finfo(FILEINFO_MIME);
        $fileType = $fileInfo->file($path);
        $fileSize = filesize($path);

        header("Content-Type: $fileType");
        header("Content-Length: $fileSize");

        readfile($path);
        exit;
    }
}
