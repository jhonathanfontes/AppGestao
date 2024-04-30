<?php

namespace App\Controllers\Api\Configuracao;

use App\Controllers\Api\ApiController;

use App\Entities\Configuracao\ContaBancaria;

class ContasBancarias extends ApiController
{
    private $contaBancariaModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->contaBancariaModel   = new \App\Models\Configuracao\ContaBancariaModel();
        $this->auditoriaModel       = new \App\Models\AuditoriaModel();
        $this->validation           =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->contaBancariaModel->getContasBancarias();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalContaBancaria" onclick="getEditContaBancaria(' . $value->cod_contabancaria . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'contabancaria'" . ',' . $value->cod_contabancaria . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $response['data'][$key] = array(
                esc($value->con_descricao),
                convertTipoConta($value->con_tipo),
                esc($value->con_agencia),
                esc($value->con_conta),
                esc($value->ban_descricao),
                esc($value->emp_razao),
                convertSimNao($value->con_pagar),
                convertSimNao($value->con_receber),
                convertStatus($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($response);
    }

    public function optionContaBancaria()
    {
        // return $this->response->setJSON($this->request->getPost());

        try {
            $tipoMovimento = $this->request->getPost('tipo');

            $where = ($tipoMovimento == 'P') ? ['con_pagar' => 'S'] : ['con_receber' => 'S'];

            $option = '';
            $contas = $this->contaBancariaModel
                ->where('status', 1)
                ->where($where)
                ->orderBy('con_descricao', 'ASC')
                ->findAll();

            foreach ($contas as $row) {
                $option .= "<option value='$row->id_conta'>$row->con_descricao </option>" . PHP_EOL;
            }
            echo $option;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['banco_id']       = $this->request->getPost('cad_banco');
        $data['con_agencia']    = returnNull($this->request->getPost('cad_agencia'), 'S');
        $data['con_conta']      = returnNull($this->request->getPost('cad_conta'), 'S');
        $data['con_descricao']  = returnNull($this->request->getPost('cad_contabancaria'), 'S');
        $data['con_tipo']       = returnNull($this->request->getPost('cad_tipo'), 'S');
        $data['empresa_id']     = returnNull($this->request->getPost('cad_empresa'), 'S');
        $data['con_pagar']      = returnNull($this->request->getPost('cad_pagamento'), 'S');
        $data['con_receber']    = returnNull($this->request->getPost('cad_recebimento'), 'S');
        $data['tipo_titular']   = returnNull($this->request->getPost('cad_natureza'), 'S');
        $data['con_titular']    = returnNull($this->request->getPost('cad_titular'), 'S');
        $data['con_documento']  = returnNull($this->request->getPost('cad_documento'), 'S');
        $data['status']         = $this->request->getPost('status');

        $entityContaBancaria = new ContaBancaria($data);



        if (!empty($this->request->getPost('cod_contabancaria'))) {
            $data['id_conta'] = $this->request->getPost('cod_contabancaria');

            $result = $this->buscaRegistro404($data['id_conta']);

            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA CONTA $result->con_descricao PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityContaBancaria->auditoriaInsertAtributos();
        };

        try {
            if ($this->contaBancariaModel->save($data)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'contabancaria', $metedoAuditoria, $dataAuditoria);
                $cod_contabancaria = (!empty($this->request->getPost('cod_contabancaria'))) ? $this->request->getPost('cod_contabancaria') : $this->contaBancariaModel->getInsertID();

                $return = $this->contaBancariaModel->returnSave($cod_contabancaria);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A CONTA $return->con_descricao FOI SALVAR!"
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
        $return = $this->contaBancariaModel
            ->where('status', 1)
            ->orderBy('con_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->contaBancariaModel->where('id_conta', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $conta = $this->contaBancariaModel->where('id_conta', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($conta === null) {
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
            if ($this->contaBancariaModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'contabancaria', 'arquivar', $conta->auditoriaUpdateAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A CONTA $conta->con_descricao FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->contaBancariaModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
