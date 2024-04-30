<?php

namespace App\Controllers\Api\Configuracao;

use App\Controllers\Api\ApiController;
use App\Models\AuditoriaModel;
use App\Models\Configuracao\BandeiraModel;

use App\Entities\Configuracao\Bandeira;

class Bandeiras extends ApiController
{
    private $bandeiraModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->bandeiraModel = new BandeiraModel();
        $this->auditoriaModel = new AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->bandeiraModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalBandeira" onclick="getEditBandeira(' . $value->id_bandeira . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

            $response['data'][$key] = array(
                esc($value->ban_descricao),
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

        $data['ban_descricao']  = returnNull($this->request->getPost('cad_bandeira'), 'S');
        $data['status']        = $this->request->getPost('status');

        $entityBandeira = new Bandeira($data);

        if (!empty($this->request->getPost('cod_bandeira'))) {

            $data['id_bandeira'] = $this->request->getPost('cod_bandeira');
            $result = $this->buscaRegistro404($this->request->getPost('cod_bandeira'));

            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO BANCO $result->cad_bandeira PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityBandeira->auditoriaInsertAtributos();
        };

        try {

            if ($this->bandeiraModel->save($data)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'bandeira', $metedoAuditoria, $dataAuditoria);
                $cod_bandeira = (!empty($this->request->getPost('cod_bandeira'))) ? $this->request->getPost('cod_bandeira') : $this->bandeiraModel->getInsertID();

                $return = $this->bandeiraModel->returnSave($cod_bandeira);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O BANCO $return->cad_bandeira FOI SALVO!"
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
        $return = $this->bandeiraModel
            ->orderBy('ban_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $qnt_id = strlen($paramentro);
        switch ($qnt_id) {
            case '1':
                $paramentro = '00' . $paramentro;
                break;
            case '2':
                $paramentro = '0' . $paramentro;
                break;
        }

        $return = $this->bandeiraModel->where('id_bandeira', $paramentro)->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $bandeira = $this->bandeiraModel->where('id_bandeira', $paramentro)->first();

        if ($bandeira === null) {
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
            if ($this->bandeiraModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'bandeira', 'arquivar', $bandeira->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O BANCO $bandeira->cad_bandeira FOI ARQUIVADA!"
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
        $qnt_id = strlen($codigo);
        switch ($qnt_id) {
            case '1':
                $codigo = '00' . $codigo;
                break;
            case '2':
                $codigo = '0' . $codigo;
                break;
        }

        if (!$codigo || !$resultado = $this->bandeiraModel->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
