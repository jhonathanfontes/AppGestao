<?php

namespace App\Controllers\Api\v1\Projeto;

use App\Controllers\Api\ApiController;
use App\Entities\Projeto\Local;

class Locais extends ApiController
{
    private $localModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->localModel = new \App\Models\Projeto\LocalModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->localModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();
        try {

            if (empty($result)):
                return $this->response->setJSON($response);
            endif;

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalLocal" onclick="getEditLocal(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                // $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'local'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
                $ops .= ' <a class="btn btn-xs btn-success" href="local/view/' . $value->id . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';

                $response['data'][$key] = array(
                    esc($value->obr_descricao),
                    esc($value->obr_datainicio) ? esc(formatDataBR($value->obr_datainicio)) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>',
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

        $data['loc_descricao'] = returnNull($this->request->getPost('cad_local'), 'S');
        $data['loc_datainicio'] = returnNull(esc($this->request->getPost('cad_datainicio')));
        $data['obra_id'] = $this->request->getPost('cod_obra');

        $entityLocal = new Local($data);
        // return $this->response->setJSON($data);
        if (!empty($this->request->getPost('cod_local'))) {
            $data['id'] = $this->request->getPost('cod_local');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA OBRA $result->cad_local PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            // $dataAuditoria = $result->auditoriaUpdateAtributos();

        } else {

            $metedoAuditoria = 'insert';
            // $dataAuditoria = $entityLocal->auditoriaInsertAtributos();

        }
        try {
            if ($this->localModel->save($data)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'local', $metedoAuditoria, $dataAuditoria);

                $cod_local = (!empty($this->request->getPost('cod_local'))) ? $this->request->getPost('cod_local') : $this->localModel->getInsertID();

                $return = $this->localModel->returnSave($cod_local);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A OBRA $return->cad_local FOI SALVAR!"
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
        $return = $this->localModel
            ->where('status', 1)
            ->orderBy('cat_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->localModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $local = $this->localModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($local === null) {
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
            if ($this->localModel->arquivarRegistro($paramentro)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'local', 'arquivar', $local->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A OBRA $local->cad_local FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->localModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
