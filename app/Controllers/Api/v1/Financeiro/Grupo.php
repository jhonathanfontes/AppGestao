<?php

namespace App\Controllers\Api\v1\Financeiro;

use App\Controllers\BaseController;
use App\Models\Financeiro\GrupoModel;

class Grupo extends BaseController
{
    protected $grupoModel;
    protected $validation;

    public function __construct()
    {
        $this->grupoModel = new GrupoModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->grupoModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();

        try {

            if (empty($result)) {
                return $this->response->setJSON($response);
            }

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalGrupo" onclick="getEditGrupo(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'grupo'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

                $response['data'][$key] = array(
                    esc($value->gru_descricao),
                    convertTipoGrupo($value->gru_tipo),
                    convertClassificacao($value->gru_classificacao),
                    convertStatus($value->status),
                    $ops,
                );
            }

            return $this->response->setJSON($response);

        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['gru_tipo'] = returnNull($this->request->getPost('cad_tipo'), 'S');
        $data['gru_descricao'] = returnNull($this->request->getPost('cad_grupo'), 'S');
        $data['gru_classificacao'] = $this->request->getPost('cad_classificacao');
        $data['status'] = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_grupo'))) {

            $data['id'] = $this->request->getPost('cod_grupo');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA GRUPO $result->cad_grupo PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->grupoModel->save($data)) {

                $cod_grupo = (!empty($this->request->getPost('cod_grupo'))) ? $this->request->getPost('cod_grupo') : $this->grupoModel->getInsertID();

                $return = $this->grupoModel->returnSave($cod_grupo);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A GRUPO $return->cad_grupo FOI SALVAR!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function findAll()
    {
        $return = $this->grupoModel
            ->where('status', 1)
            ->orderBy('gru_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->grupoModel->where('id', $paramentro)
            ->whereIn('status', ['1', '2'])
            ->first();

        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $grupo = $this->grupoModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 9)
            ->first();

        if ($grupo === null) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL ARQUIVAR O REGISTRO!',
                        'description' => 'REGISTRO INFORMADO NÃO FOI LOCALIZADO!'
                    ]
                ]
            );
        }

        try {
            if ($this->grupoModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O GRUPO $grupo->cad_grupo FOI ARQUIVADO!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL ARQUIVAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->grupoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
