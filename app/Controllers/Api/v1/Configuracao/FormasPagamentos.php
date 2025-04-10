<?php

namespace App\Controllers\Api\v1\Configuracao;

use App\Entities\Configuracao\FormaPagamento;

class FormasPagamentos extends \App\Controllers\Api\ApiController
{
    private $formaPagamentoModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->formaPagamentoModel = new \App\Models\Configuracao\FormaPagamentoModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->formaPagamentoModel
            ->whereIn('pdv_formapag.status', ['1', '2'])
            ->findAll();


        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalFormaPagamento" onclick="getEditFormaPagamento(' . $value->cod_forma . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            //  $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'formapagamento'" . ',' . $value->cod_forma . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
            // $ops .= '	<a class="btn btn-xs btn-success ml-2" href="formaspagamentos/view/' . $value->cod_forma . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';

            $response['data'][$key] = array(
                esc($value->cad_descricao),
                convertFormarPagamento($value->cad_forma),
                convertSimNao($value->cad_parcela),
                convertSimNao($value->cad_antecipa),
                convertStatus($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($response);
    }

    public function optionFormaPagamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $option = '';

            if ($this->request->getPost('forma') == 3 || $this->request->getPost('forma') == 4) {
                $option = '<option value="">SELEIONE UM FORMA DE PAGAMENTO</option>';
            }

            $contas = $this->formaPagamentoModel->where('status', 1)->where('for_forma', $this->request->getPost('forma'))->orderBy('for_descricao', 'ASC')->findAll();
            foreach ($contas as $row) {
                $option .= "<option value='$row->id'>$row->for_descricao </option>" . PHP_EOL;
            }
            echo $option;
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


    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['for_forma'] = returnNull($this->request->getPost('cad_forma'), 'S');
        $data['for_descricao'] = returnNull($this->request->getPost('cad_descricao'), 'S');

        if ($this->request->getPost('cad_forma') === '3' || $this->request->getPost('cad_forma') === '4') {
            // $data['maquinacartao_id'] = returnNull($this->request->getPost('cad_maquininha'), 'S');
            // $data['conta_id'] = returnNull($this->request->getPost('cad_conta'), 'S');
            $data['for_parcela'] = $this->request->getPost('cad_parcela');
            $data['for_antecipa'] = $this->request->getPost('cad_antecipa');
            $data['for_prazo'] = returnNull($this->request->getPost('cad_fprazo'), 'S');
            $data['for_taxa'] = returnNull($this->request->getPost('cad_ftaxa'), 'S');
        }

        $data['status'] = $this->request->getPost('status');
        // return $this->response->setJSON($data);

        $entityFormaPagamento = new FormaPagamento($data);

        if (!empty($this->request->getPost('cod_formapagamento'))) {
            $data['id'] = $this->request->getPost('cod_formapagamento');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA FORMA DE PAGAMENTO $result->cad_maquinacartao PARA SALVAR!"
                    ]
                ]);
            }
            // $this->auditoriaModel->insertAuditoria('configuracao', 'formapagamento', 'atualizar', $result->auditoriaAtributos());
        }
        ;

        try {
            if ($this->formaPagamentoModel->save($data)) {

                $cod_formapagamento = (!empty($this->request->getPost('cod_formapagamento'))) ? $this->request->getPost('cod_formapagamento') : $this->formaPagamentoModel->getInsertID();

                $return = $this->formaPagamentoModel->returnSave($cod_formapagamento);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A FORMA DE PAGAMENTO $return->cad_descricao FOI SALVAR!"
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
        $return = $this->formaPagamentoModel
            ->where('status', 1)
            ->orderBy('for_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->formaPagamentoModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $formaPagamento = $this->formaPagamentoModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($formaPagamento === null) {
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
            if ($this->formaPagamentoModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'formapagamento', 'arquivar', $formaPagamento->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A FORMA DE PAGAMENTO $formaPagamento->cad_descricao FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->formaPagamentoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
