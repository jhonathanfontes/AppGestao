<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
abstract class ApiController extends Controller
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
     * @var array
     */
    protected $helpers = ['permissao', 'jbsystem', 'form', 'html', 'xml', 'autenticacao'];

    /**
     * Constructor.
     */

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    protected function responseSavedSuccessfully($message = null)
    {
        return [
            'status' => true,
            'menssagem' => [
                'status' => 'success',
                'heading' => 'REGISTRO SALVO COM SUCESSO!',
                'description' => $message
            ]
        ];
    }

    protected function responseUnableSaveRequest($message = null)
    {
        return [
            'status' => true,
            'menssagem' => [
                'status' => 'error',
                'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                'description' => $message
            ]
        ];
    }

    protected function responseUnableProcessRequest($message = null)
    {
        return [
            'status' => true,
            'menssagem' => [
                'status' => 'error',
                'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                'description' => $message
            ]
        ];
    }

    protected function responseTryThrowable($th = null)
    {
        return [
            'status' => false,
            'menssagem' => [
                'status' => 'error',
                'heading' => 'NÃO FOI POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                'description' => $th->getMessage()
            ]
        ];
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

    protected function carregarArquivo($arquivo)
    {
    }
}
