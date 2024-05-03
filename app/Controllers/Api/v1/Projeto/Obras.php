<?php

namespace App\Controllers\Api\v1\Projeto;

use App\Controllers\Api\ApiController;

use App\Entities\Projeto\Obra;
use App\Models\Projeto\ObraModel;

class Obras extends ApiController
{

    private $obraModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->obraModel = new ObraModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->obraModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();
        try {

            if (empty($result)):
                return $this->response->setJSON($response);
            endif;

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalObra" onclick="getEditObra(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                // $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'obra'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
                $ops .= ' <a class="btn btn-xs btn-success" href="obra/view/' . $value->id . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';

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

        $data['obr_descricao'] = returnNull($this->request->getPost('cad_obra'), 'S');
        $data['obr_datainicio'] = returnNull(esc($this->request->getPost('cad_datainicio')));

        $entityObra = new Obra($data);

        if (!empty($this->request->getPost('cod_obra'))) {
            $data['id'] = $this->request->getPost('cod_obra');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA OBRA $result->cad_obra PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            // $dataAuditoria = $result->auditoriaUpdateAtributos();

        } else {

            $metedoAuditoria = 'insert';
            // $dataAuditoria = $entityObra->auditoriaInsertAtributos();

        }
        try {
            if ($this->obraModel->save($data)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'obra', $metedoAuditoria, $dataAuditoria);

                $cod_obra = (!empty($this->request->getPost('cod_obra'))) ? $this->request->getPost('cod_obra') : $this->obraModel->getInsertID();

                $return = $this->obraModel->returnSave($cod_obra);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A OBRA $return->cad_obra FOI SALVAR!"
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
        $return = $this->obraModel
            ->where('status', 1)
            ->orderBy('cat_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->obraModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $obra = $this->obraModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($obra === null) {
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
            if ($this->obraModel->arquivarRegistro($paramentro)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'obra', 'arquivar', $obra->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A OBRA $obra->cad_obra FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->obraModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
