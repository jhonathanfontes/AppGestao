<?php

namespace App\Controllers\Api\v1\Configuracao;

use App\Controllers\Api\ApiController;

use App\Entities\Configuracao\ContaBancaria;

class ContasBancarias extends ApiController
{
    private $contaBancariaModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->contaBancariaModel = new \App\Models\Configuracao\ContaBancariaModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->contaBancariaModel->getContasBancaria()
            ->whereIn('cad_contabancaria.status', ['1', '2'])
            ->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalContaBancaria" onclick="getEditContaBancaria(' . $value->cod_contabancaria . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'contabancaria'" . ',' . $value->cod_contabancaria . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $response['data'][$key] = array(
                esc($value->cad_contabancaria),
                convertTipoConta($value->cad_tipo),
                esc($value->cad_agencia),
                esc($value->cad_conta),
                esc($value->ban_codigo) . ' - ' . esc($value->ban_descricao),
                esc($value->cad_titular),
                convertSimNao($value->cad_pagamento),
                convertSimNao($value->cad_recebimento),
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

        $data['con_natureza'] = $this->request->getPost('cad_natureza');
        $data['banco_id'] = $this->request->getPost('cad_banco');
        $data['con_descricao'] = returnNull($this->request->getPost('cad_contabancaria'), 'S');
        $data['con_agencia'] = returnNull($this->request->getPost('cad_agencia'), 'S');
        $data['con_conta'] = returnNull($this->request->getPost('cad_conta'), 'S');
        $data['con_tipoconta'] = $this->request->getPost('cad_tipo');
        $data['con_documento'] = returnNull($this->request->getPost('cad_documento'), 'S');
        $data['con_titular'] = returnNull($this->request->getPost('cad_titular'), 'S');
        $data['con_pagamento'] = $this->request->getPost('cad_pagamento');
        $data['con_recebimento'] = $this->request->getPost('cad_recebimento');
        $data['empresa_id'] = returnNull($this->request->getPost('cad_empresa'), 'S');
        $data['status'] = $this->request->getPost('status');

        $entityContaBancaria = new ContaBancaria($data);



        if (!empty($this->request->getPost('cod_contabancaria'))) {
            $data['id'] = $this->request->getPost('cod_contabancaria');

            $result = $this->buscaRegistro404($data['id']);

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
            // $dataAuditoria = $result->auditoriaUpdateAtributos();
        } else {

            $metedoAuditoria = 'insert';
            // $dataAuditoria = $entityContaBancaria->auditoriaInsertAtributos();
        }
        ;

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
