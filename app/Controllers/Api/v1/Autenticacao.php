<?php

namespace App\Controllers\Api\v1;

use App\Controllers\BaseController;
use App\Models\Configuracao\UsuarioModel;

class Autenticacao extends BaseController
{
    protected $usuarioModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }
    public function login()
    {

        // return json_encode($this->request->getPost());

        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $validation = \Config\Services::validation();

        // $validation->setRule('username', 'Username', 'required|max_length[30]|min_length[3]');

        $validation->setRules(
            [
                'credencial' => [
                    'label' => 'e-mail',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'O {field} deve ser informado',
                    ],
                ],
                'password' => [
                    'label' => 'senha',
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'A {field} deve ser informado',
                        'min_length' => 'A {field} deve conter no minimo {param} caracteres',
                    ],
                ],
            ]
        );


        $validation->withRequest($this->request)->run();
        $errors = $validation->getErrors();

        $resposta = [];
        if ($errors) {
            $resposta = [
                'status' => false,
                'error' => $errors,
                'menssagem' => [
                    'status' => 'error',
                    'heading' => 'ACESSO NEGADO',
                    'description' => $errors['password']

                ]
            ];
            return json_encode($resposta);
        } else {

            $use_email = $this->request->getPost('credencial');
            $use_password = $this->request->getPost('password');

            $autenticacao = service('autenticacao');

            $login = $autenticacao->login($use_email, $use_password);

            if ($login) {
                
                $usuario = $autenticacao->usuarioLogado();
                $msg_usuairo = ($usuario->cad_sexo == 'F') ? 'SEJA BEM VINDA SENHORA ' . strtoupper($usuario->cad_apelido) : 'SEJA BEM VINDO SENHOR ' . strtoupper($usuario->cad_apelido);

                $resposta = [
                    'status' => true,
                    'error' => null,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'ACESSO PERMITIDO',
                        'description' => $msg_usuairo
                    ]
                ];
                return json_encode($resposta);
            } else {
                $resposta = [
                    'status' => false,
                    'error' => null,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ACESSO NEGADO',
                        'description' => 'NÃO FOI POSSIVEL ACESSAR O SISTEMA, VERIFIQUE SUAS CREDENCIAIS!'

                    ]
                ];
            }
            return json_encode($resposta);
        }
    }

    public function esqueciSenha()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $response['token'] = csrf_hash();
        $use_email = $this->request->getPost('email');
        $usuario = $this->usuarioModel->getUsuarioEmail($use_email);

        if ($usuario === null) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'CONTA DE USUARIO NÃO LOCALIZADA!',
                        'description' => "O E-MAIL INFORMADO NÃO FOI ENCONTRADO NA BASE DE DADOS!"
                    ]
                ]
            );
        }
        if ($usuario->status != 1) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'USUARIO COM A CONTA BLOQUEADA!',
                        'description' => "PROCURE O ADMINISTRADOR DO SISTEMA!"
                    ]
                ]
            );
        }

        $usuario->iniciaPasswordReset();

        $this->usuarioModel->save($usuario);

        $email = $this->sendEmailRedefinicao($usuario);
        return $this->response->setJSON($email);

        return $this->response->setJSON([
            'status' => true,
            'menssagem' => [
                'status' => 'success',
                'heading' => 'E-MAIL DE RECUPERAÇÃO ENVIADO!',
                'description' => 'VERIFIQUE SUA CAIXA DE ENTRADA!'
            ]
        ]);
    }

    private function sendEmailRedefinicao(object $data): void
    {
        $email = service('email');

        $email->setFrom(getenv('email.SMTPUser'), 'Deloris');
        $email->setTo($data->cad_email);
        $email->setSubject('Redefinição da Senha!');
        $mensagem = view('emails/email_reset_password', [
            'usuario' => $data->cad_usuario,
            'email' => $data->cad_email,
            'token' => $data->reset_token
        ]);
        $email->setMessage($mensagem);
        $email->send();
    }
}
