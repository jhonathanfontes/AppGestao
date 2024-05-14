<?php

namespace App\Controllers\Api\v1\Configuracao;

use App\Controllers\Api\ApiController;
use App\Models\AuditoriaModel;
use App\Entities\Configuracao\Vendedor as EntitiesVendedor;

class Vendedor extends ApiController
{
    private $vendedorModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->vendedorModel = new \App\Models\Configuracao\VendedorModel();
        $this->auditoriaModel = new AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->vendedorModel->getVendedor()->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalVendedor" onclick="getEditVendedor(' . $value->cod_vendedor . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

            $response['data'][$key] = array(
                esc($value->cod_vendedor),
                esc($value->use_username),
                esc($value->use_apelido),
                esc($value->pessoa),
                esc($value->celular),
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

        $data['pessoa_id']      = $this->request->getPost('cod_pessoa');
        $data['usuario_id']     = $this->request->getPost('cod_usuario');
        $data['status']         = $this->request->getPost('status');


        $entityVendedor = new EntitiesVendedor($data);

        if (!empty($this->request->getPost('cod_vendedor'))) {

            $data['id_vendedor'] = $this->request->getPost('cod_vendedor');
            $result = $this->buscaRegistro404($this->request->getPost('cod_vendedor'));

            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO VENDEDOR $result->pessoa PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityVendedor->auditoriaInsertAtributos();
        };

        try {

            if ($this->vendedorModel->save($data)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'vendedor', $metedoAuditoria, $dataAuditoria);

                $cod_vendedor = (!empty($this->request->getPost('cod_vendedor'))) ? $this->request->getPost('cod_vendedor') : $this->vendedorModel->getInsertID();
                
                $return = $this->vendedorModel->returnSave($cod_vendedor);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O VENDEDOR $return->pessoa FOI SALVO!"
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
        $return = $this->vendedorModel
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->vendedorModel
            ->getVendedor()
            ->where('cad_vendedor.id_vendedor', $paramentro)
            ->first();

        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $banco = $this->vendedorModel->where('id_vendedor', $paramentro)->first();

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
            if ($this->vendedorModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'banco', 'arquivar', $banco->auditoriaAtributos());

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
        if (!$codigo || !$resultado = $this->vendedorModel->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
