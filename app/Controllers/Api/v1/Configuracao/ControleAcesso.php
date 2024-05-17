<?php

namespace App\Controllers\Api\v1\Configuracao;

use App\Controllers\Api\ApiController;
use App\Entities\Configuracao\Permissao;
use App\Models\Configuracao\AcessoModel;

use CodeIgniter\API\ResponseTrait;

class ControleAcesso extends ApiController
{
    use ResponseTrait;

    protected $controleAcessoModel;
    protected $permissaoModel;
    private $auditoriaModel;
    protected $validation;

    public function __construct()
    {
        $this->permissaoModel = new \App\Models\Configuracao\PermissaoModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->permissaoModel->withDeleted()->findAll();

        foreach ($result as $key => $value) {

            //$ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalFabricante" onclick="getEditFabricante(' . $value->cod_permissao . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            //$ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'fabricante'" . ',' . $value->cod_permissao . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalGrupoAcesso" onclick="getEditGrupoAcesso(' . $value->cod_permissao . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

            $response['data'][$key] = array(
                esc($value->cad_permissao),
                $ops
                //'<a class="btn btn-xs btn-success" href="gruposdeacesso/view/' . $value->cod_permissao . '"><span class="fas fa-tasks"></span> GERENCIAR </a>',
            );
        }

        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['per_descricao'] = returnNull($this->request->getPost('cad_grupodeacesso'), 'S');

        $entityPermissao = new Permissao($data);

        if (!empty($this->request->getPost('cod_grupodeacesso'))) {
            $data['id'] = $this->request->getPost('cod_grupodeacesso');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO GRUPO DE ACESSO $result->cad_permissao PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityPermissao->auditoriaInsertAtributos();
        };

        try {
            if ($this->permissaoModel->save($data)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'grupodeacesso', $metedoAuditoria, $dataAuditoria);

                $cod_grupodeacesso = (!empty($this->request->getPost('cod_grupodeacesso'))) ? $this->request->getPost('cod_grupodeacesso') : $this->permissaoModel->getInsertID();

                $return = $this->permissaoModel->returnSave($cod_grupodeacesso);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O GRUPO DE ACESSO $return->cad_permissao FOI SALVAR!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->responseTryThrowable($th);
        }
    }

    public function getPermissao()
    {
        $permissaoModel = new PermissaoModel();
        $permissoes = $permissaoModel->findAll();
        $i = 0;
        foreach ($permissoes as $row) {
            $dados[$i] = array(
                'cod_permisao'      => $row['id'],
                'cad_descricao'     => $row['per_descricao']
            );
            $i++;
        }
        if ($permissoes) {
            return json_encode($dados);
        } else {
            return "'No direct script access allowed'";
        }
    }

    public function getPermissoes()
    {
        $permissaoModel = new PermissaoModel();
        $return = $permissaoModel->orderBy('per_descricao', 'ASC')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function getPermissaoShow($cod_permisao)
    {
        $permissaoModel = new PermissaoModel();
        $permissoe = $permissaoModel->find($cod_permisao);

        $dados = array(
            'cod_permisao'      => $permissoe['id'],
            'cad_descricao'     => $permissoe['per_descricao']
        );

        if ($permissoe) {
            return json_encode($dados);
        } else {
            return "'No direct script access allowed'";
        }
    }

    public function postPermissao()
    {
        $cod_permisao = $this->request->getPost('cod_permisao');

        $permissaoModel = new PermissaoModel();
        $permissoes = $permissaoModel->getModulos($cod_permisao);
        return json_encode($permissoes);
        $i = 0;
        foreach ($permissoes as $row) {
            $dados[$i] = array(
                'cod_permisao'      => $row['id'],
                'cad_descricao'     => $row['per_descricao']
            );
            $i++;
        }
        if ($permissoes) {
            return json_encode($dados);
        } else {
            return "'No direct script access allowed'";
        }
    }
    public function getPermissaoModulos($cod_permisao)
    {
        $permissaoModel = new PermissaoModel();
        $permissoes = $permissaoModel->getModulosPermissao($cod_permisao);
        if ($permissoes) {
            return json_encode($permissoes);
        } else {
            return "'No direct script access allowed'";
        }
    }
    public function grupoSave()
    {
        try {
            $permissaoModel = new PermissaoModel();

            $cod_permisao   = $this->request->getPost('cod_permissao');
            $cad_descricao  = $this->request->getPost('cad_descricao');

            $dados = array(
                'id'      => $cod_permisao,
                'per_descricao'     => $cad_descricao
            );

            if ($permissaoModel->save($dados)) {
                if ($cod_permisao != null) {
                    $resposta = [
                        'status' => true,
                        'error' => null,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'SUCESSO',
                            'description' => 'GRUPO ATUALIZADO!'
                        ]
                    ];
                } else {
                    $resposta = [
                        'status' => true,
                        'error' => null,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'SUCESSO',
                            'description' => 'GRUPO CADASTRADO!'
                        ]
                    ];
                }
            } else {
                $resposta = [
                    'status' => false,
                    'error' => null,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'OPS!',
                        'description' => 'NÃO FOI POSSIVEL REALIZAR ESTÁ AÇÃO.'
                    ]
                ];
            }
        } catch (\Exception $e) {
            $resposta = [
                'status' => false,
                'error' => null,
                'menssagem' => [
                    'status' => 'error',
                    'heading' => 'OPS!',
                    'description' => $e->getMessage()
                ]
            ];
        }

        return json_encode($resposta);
    }
    public function getModulo($permissao = 0)
    {
        $permissaoModel = new PermissaoModel();
        $permissoes = $permissaoModel->findAll();
        $i = 0;
        foreach ($permissoes as $row) {
            $dados[$i] = array(
                'cod_permisao'      => $row['id'],
                'cad_descricao'     => $row['per_descricao']
            );
            $i++;
        }
        if ($permissoes) {
            return json_encode($dados);
        } else {
            return "'No direct script access allowed'";
        }
    }
    public function permissaoSave()
    {
        $acessoModel = new AcessoModel();

        try {

            $cod_permisao = $this->request->getPost('cod_permissao');
            $cod_modulo = $this->request->getPost('cod_modulo');
            $cad_metodo = $this->request->getPost('cad_metodo');
            $cad_valor = $this->request->getPost('cad_valor');

            $return = $acessoModel->atualizaAcesso($cod_permisao, $cod_modulo, $cad_metodo, $cad_valor);
            if ($return) {
                $resposta = [
                    'status' => true,
                    'error' => null,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'SUCESSO',
                        'description' => 'PERMISSÃO ATUALIZADA!'
                    ]
                ];
            } else {
                $resposta = [
                    'status' => false,
                    'error' => null,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'OPS!',
                        'description' => 'NÃO FOI POSSIVEL REALIZAR ESTÁ AÇÃO.'
                    ]
                ];
            }
        } catch (\Throwable $e) {
            $resposta = [
                'status' => false,
                'error' => null,
                'menssagem' => [
                    'status' => 'error',
                    'heading' => 'OPS!',
                    'description' => $e->getMessage()
                ]
            ];
        }

        return json_encode($resposta);
    }

    public function findAll()
    {
        $return = $this->permissaoModel
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->permissaoModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->permissaoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
