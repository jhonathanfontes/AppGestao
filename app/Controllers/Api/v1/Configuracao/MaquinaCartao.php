<?php

namespace App\Controllers\Api\Configuracao;

use App\Controllers\Api\ApiController;
use App\Models\Configuracao\MaquinaCartaoModel;
use App\Models\AuditoriaModel;

class MaquinaCartao extends ApiController
{
    private $maquinaCartaoModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->maquinaCartaoModel = new MaquinaCartaoModel();
        $this->auditoriaModel = new AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->maquinaCartaoModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalMaquinaCartao" onclick="getEditMaquinaCartao(' . $value->id_maquina . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'maquinacartao'" . ',' . $value->id_maquina . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $response['data'][$key] = array(
                esc($value->maq_descricao),
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

        $data['maq_descricao'] = returnNull($this->request->getPost('cad_maquinacartao'), 'S');
        $data['status']        = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_maquinacartao'))) {
            $data['id_maquina'] = $this->request->getPost('cod_maquinacartao');

            $result = $this->buscaRegistro404($data['id_maquina']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA MAQUINA $result->cad_maquinacartao PARA SALVAR!"
                    ]
                ]);
            }
            $this->auditoriaModel->insertAuditoria('configuracao', 'maquinacartao', 'atualizar', $result->auditoriaAtributos());
        };

        try {
            if ($this->maquinaCartaoModel->save($data)) {

                $cod_maquinacartao = (!empty($this->request->getPost('cod_maquinacartao'))) ? $this->request->getPost('cod_maquinacartao') : $this->maquinaCartaoModel->getInsertID();

                $return = $this->maquinaCartaoModel->returnSave($cod_maquinacartao);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A MAQUINA $return->cad_maquinacartao FOI SALVAR!"
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
        $return = $this->maquinaCartaoModel
            ->where('status', 1)
            ->orderBy('maq_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->maquinaCartaoModel->where('id_maquina', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $categoria = $this->maquinaCartaoModel->where('id_maquina', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($categoria === null) {
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
            if ($this->maquinaCartaoModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'maquinacartao', 'arquivar', $categoria->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A CATEGORIA $categoria->cad_maquinacartao FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->maquinaCartaoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
