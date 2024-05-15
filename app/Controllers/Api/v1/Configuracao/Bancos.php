<?php

namespace App\Controllers\Api\v1\Configuracao;

use App\Controllers\Api\ApiController;
use App\Models\AuditoriaModel;
use App\Models\Configuracao\BancoModel;

use App\Entities\Configuracao\Banco;

class Bancos extends ApiController
{
    private $bancoModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->bancoModel = new BancoModel();
        // $this->auditoriaModel = new AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->bancoModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalBanco" onclick="getEditBanco(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

            $response['data'][$key] = array(
                esc($value->ban_codigo),
                esc($value->ban_descricao),
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

        $data['ban_descricao']  = returnNull($this->request->getPost('cad_banco'), 'S');
        $data['ban_codigo']     = $this->request->getPost('cad_codigo');

        $entityBanco = new Banco($data);

        if (!empty($this->request->getPost('cod_banco'))) {

            $data['id'] = $this->request->getPost('cod_banco');
            $result = $this->buscaRegistro404($this->request->getPost('cod_banco'));

            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO BANCO $result->cad_banco PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();

        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityBanco->auditoriaInsertAtributos();
            
        };

        try {

            if ($this->bancoModel->save($data)) {

                // $this->auditoriaModel->insertAuditoria('configuracao', 'banco', $metedoAuditoria, $dataAuditoria);
                $cod_banco = (!empty($this->request->getPost('cod_banco'))) ? $this->request->getPost('cod_banco') : $this->bancoModel->getInsertID();
                
                $return = $this->bancoModel->returnSave($cod_banco);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O BANCO $return->cad_banco FOI SALVO!"
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
        $return = $this->bancoModel
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

        $return = $this->bancoModel->where('ban_codigo', $paramentro)->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $banco = $this->bancoModel->where('ban_codigo', $paramentro)->first();

        if ($banco === null) {
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
            if ($this->bancoModel->arquivarRegistro($paramentro)) {

                // $this->auditoriaModel->insertAuditoria('configuracao', 'banco', 'arquivar', $banco->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O BANCO $banco->cad_banco FOI ARQUIVADA!"
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

        if (!$codigo || !$resultado = $this->bancoModel->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
