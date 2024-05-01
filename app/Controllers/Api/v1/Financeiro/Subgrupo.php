<?php

namespace App\Controllers\Api\v1\Financeiro;

use App\Controllers\BaseController;
use App\Models\Financeiro\SubGrupoModel;

class Subgrupo extends BaseController
{
    protected $subgrupoModel;
    protected $validation;

    public function __construct()
    {
        $this->subgrupoModel = new SubGrupoModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->subgrupoModel->getSubGrupos();

        try {

            if (empty($result)) {
                return $this->response->setJSON($response);
            }

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalSubgrupo" onclick="getEditSubgrupo(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'subgrupo'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

                $response['data'][$key] = array(
                    esc($value->sub_descricao),
                    esc($value->cad_grupo),
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

        $data['sub_descricao'] = returnNull($this->request->getPost('cad_subgrupo'), 'S');
        $data['grupo_id'] = $this->request->getPost('cod_grupo');
        $data['status'] = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_subgrupo'))) {
            $data['id'] = $this->request->getPost('cod_subgrupo');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA SUBGRUPO $result->cad_subgrupo PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->subgrupoModel->save($data)) {

                $cod_subgrupo = (!empty($this->request->getPost('cod_subgrupo'))) ? $this->request->getPost('cod_subgrupo') : $this->subgrupoModel->getInsertID();

                $return = $this->subgrupoModel->returnSave($cod_subgrupo);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A SUBGRUPO $return->cad_subgrupo FOI SALVAR!"
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
        $return = $this->subgrupoModel
            ->where('status', 1)
            ->orderBy('sub_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function subgruposReceitas()
    {
        $return = $this->subgrupoModel
            ->getSubgrupoGrupoAtivo()
            ->where('cad_grupo.gru_tipo', 'R')
            ->orderBy('cad_subgrupo.sub_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }
    public function subgruposDespesas()
    {
        $return = $this->subgrupoModel
            ->getSubgrupoGrupoAtivo()
            ->where('cad_grupo.gru_tipo', 'D')
            ->orderBy('cad_subgrupo.sub_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }
    public function show($paramentro)
    {
        $return = $this->subgrupoModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $subgrupo = $this->subgrupoModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 9)
            ->first();

        if ($subgrupo === null) {
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
            if ($this->subgrupoModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A SUBGRUPO $subgrupo->cad_subgrupo FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->subgrupoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
