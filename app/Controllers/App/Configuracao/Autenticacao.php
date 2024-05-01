<?php

namespace App\Controllers\App\Configuracao;

use CodeIgniter\HTTP\IncomingRequest;
use App\Controllers\BaseController;
use App\Models\Configuracao\UsuarioModel;

class Autenticacao extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $data = [];
        helper(['form']);
        echo view('autenticacao/login', $data);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/app/autenticacao/login'));
    }

    public function getlogar()
    {
        if ((bool)session()->get('jb_isLoggedIn') != true) {
            return redirect()->to(base_url('/autenticacao/login'));
        }else{
            return redirect()->to(base_url('/app/dashboard'));
        }
    }

    public function logar()
    {
        $session = session();
        $validation =  \Config\Services::validation();
        $validation->setRules(
            [
                'email' => [
                    'label'  => 'e-mail',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'O {field} deve ser informado',
                    ],
                ],
                'password'    => [
                    'label'  => 'senha',
                    'rules'  => 'required|min_length[6]',
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
                'menssagem' => null
            ];
            return json_encode($resposta);
        } else {
            $use_email = $this->request->getPost('email');
            $use_password = $this->request->getPost('password');

            $dados = $this->checkUserDB($use_email);
            if ($dados) {
                if ($dados[0]['status'] == 1) {
                    $pass = $dados[0]['use_password'];
                    if (password_verify($use_password, $pass)) {
                        $data = [
                            'jb_userId'     => $dados[0]['id_usuario'],
                            'jb_apelido'    => $dados[0]['use_apelido'],
                            'jb_nome'       => $dados[0]['use_nome'],
                            'jb_grupo'      => $dados[0]['permissao_id'],
                            'jb_isLoggedIn' => true
                        ];

                        $session->set($data);

                        $msg_usuairo = ($dados[0]['use_sexo'] == 'F') ? 'SEJA BEM VINDA SENHORA ' . strtoupper($dados[0]['use_nome']) : 'SEJA BEM VINDO SENHOR ' . strtoupper($dados[0]['use_nome']);

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
                                'description' => 'O USUARIO OU A SENHA INFORMADA INCORRETA'
                            ]
                        ];
                    }
                } else {
                    $resposta = [
                        'status' => false,
                        'error' => null,
                        'menssagem' => [
                            'status' => 'warning',
                            'heading' => 'ATENÇÃO',
                            'description' => 'ESTE USUARIO NÃO ESTA HABILITADO!'

                        ]
                    ];
                }
            } else {
                $resposta = [
                    'status' => false,
                    'error' => null,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ACESSO NEGADO',
                        'description' => 'O USUARIO OU A SENHA INFORMADA INCORRETA'

                    ]
                ];
            }
            return json_encode($resposta);
        }
    }
    private function checkUserDB($email = null)
    {
        $userModel = new UsuarioModel();
        $user = $userModel->where('use_email', $email)->find();
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
}
