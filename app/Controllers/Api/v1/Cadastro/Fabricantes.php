<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\BaseController;
use App\Models\Cadastro\FabricanteModel;

use App\Entities\Cadastro\Fabricante;

class Fabricantes extends BaseController
{
    protected $fabricanteModel;
    protected $validation;

    public function __construct()
    {
        $this->fabricanteModel = new FabricanteModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->fabricanteModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalFabricante" onclick="getEditFabricante(' . $value->id_fabricante . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'fabricante'" . ',' . $value->id_fabricante . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $response['data'][$key] = array(
                esc($value->fab_descricao),
                convertStatus($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['fab_descricao'] = returnNull($this->request->getPost('cad_fabricante'), 'S');
        $data['status']        = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_fabricante'))) {
            $data['id_fabricante'] = $this->request->getPost('cod_fabricante');

            $result = $this->buscaRegistro404($data['id_fabricante']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO FABRICANTE $result->cad_fabricante PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->fabricanteModel->save($data)) {
                $cod_fabricante = (!empty($this->request->getPost('cod_fabricante'))) ? $this->request->getPost('cod_fabricante') : $this->fabricanteModel->getInsertID();
                $return = $this->fabricanteModel->returnSave($cod_fabricante);
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O FABRICANTE $return->cad_fabricante FOI SALVAR!"
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
        $return = $this->fabricanteModel
            ->where('status', 1)
            ->orderBy('fab_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->fabricanteModel->where('id_fabricante', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $result = $this->fabricanteModel->where('id_fabricante', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($result === null) {
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
            if ($this->fabricanteModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O FABRICANTE $result->cad_fabricante FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->fabricanteModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
