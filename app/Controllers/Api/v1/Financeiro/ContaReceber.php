<?php

namespace App\Controllers\Api\Financeiro;

use App\Controllers\Api\ApiController;
use App\Entities\Financeiro\ContaReceber as FinanceiroContaReceber;
use App\Models\Financeiro\ContaReceberModel;
use App\Models\Financeiro\MovimentacaoModel;
use CodeIgniter\Model;

class ContaReceber extends ApiController
{
    protected $contaReceberModel;
    protected $movimentacaoModel;
    protected $formaParcelamento;
    protected $caixaModel;
    protected $pagamentoModel;
    protected $pagamentoDetalheModel;

    protected $auditoriaModel;
    protected $validation;

    public function __construct()
    {
        $this->contaReceberModel = new ContaReceberModel();
        $this->movimentacaoModel = new MovimentacaoModel();

        $this->formaParcelamento = new \App\Models\Configuracao\FormaParcelamentoModel();

        $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = [];

        $result = $this->contaReceberModel->getContasReceber();

        try {
            if ($result) {
                foreach ($result as $key => $value) {

                    $response['data'][$key] = array(
                        formatDataBR(esc($value->vencimento)),
                        formatValorBR(esc($value->valor)),
                        formatValorBR(esc($value->cancelado)),
                        formatValorBR(esc($value->recebido)),
                        formatValorBR(esc($value->saldo)),
                        esc($value->des_cliente),
                        esc($value->referencia),
                        esc($value->parcela) . '/' . esc($value->parcela_total),
                        ($value->cod_orcamento != null) ? '<span class="badge badge-pill badge-secondary">NÃO PERMITIDO</span>' : '<button type="button" class="btn btn-xs btn-warning text-left" data-toggle="modal" data-target="#modalReceber" onclick="getEditReceber(' . $value->cod_receber . ')"><samp class="far fa-edit"></samp> EDITAR</button>',
                        '<a class="btn btn-xs btn-success ml-2 text-right" href="' . base_url('app/financeiro/contareceber/view/' . $value->cod_receber) . '"><span class="fas fa-tasks"></span> GERENCIAR </a>'
                    );
                }
            }
            return $this->response->setJSON($response);
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function getCarregaTabelaByCliente()
    {
        try {
            $response['data'] = [];
            $result = $this->contaReceberModel->getContasReceberByCliente();

            if ($result) {
                foreach ($result as $key => $value) {

                    $response['data'][$key] = array(
                        esc($value->des_cliente),
                        formatValorBR(esc($value->rec_valor)),
                        formatValorBR(esc($value->rec_cancelado)),
                        formatValorBR(esc($value->rec_recebido)),
                        formatValorBR(esc($value->rec_saldo)),
                        formatValorBR(esc($value->val_vencida)),
                        ($value->pac_vencida <> 0) ? '<span class="badge badge-danger">PARCELAS ' . esc($value->pac_vencida) . '</span>' : '',
                        formatValorBR(esc($value->val_pendente)),
                        ($value->pac_pendente <> 0) ? '<span class="badge badge-success">PARCELAS ' . esc($value->pac_pendente) . '</span>' : '',
                        '<a class="btn btn-xs btn-success ml-2 text-right" href="' . base_url('app/financeiro/contareceber/cliente/' . $value->cod_pessoa) . '"><span class="fas fa-tasks"></span> GERENCIAR </a>'
                    );
                }
            }
            return $this->response->setJSON($response);
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function getPagamentosTabela()
    {
        $response = array();

        $serial = $this->request->getPost('serial');
        $codigo = $this->request->getPost('codigo');

        if (!empty($serial) && !empty($codigo)) {
            $response['data'] = [];

            $result = $this->movimentacaoModel->getPagamentosContaReceber($serial, $codigo);
            if ($result) {
                foreach ($result as $key => $value) {

                    $ops = '<button type="button" class="btn btn-xs btn-danger ml-2" onclick="cancelarPagamento(' . $value->codigo . ')"><samp class="fa fa-times"></samp> CANCELAR</button>';

                    $response['data'][$key] = array(
                        formatDataBR(esc($value->mov_data)),
                        formatValorBR(esc($value->mov_valor)),
                        convertFormarPagamento($value->mov_formapagamento),
                        esc($value->mov_documento),
                        esc($value->usuario),
                        $ops,
                    );
                }
            }
        }
        return $this->response->setJSON($response);
    }

    public function findAllWhere()
    {
        try {
            $codigos = $this->request->getPost('cod_receber');
            if (empty($codigos)) {
                return $this->response->setJSON($this->responseUnableProcessRequest('NÃO FOI LOCALIZADO A CONTA A RECEBER.'));
            }
            $result = $this->contaReceberModel->getContaReceberInCodigo($codigos);
            return $this->response->setJSON($result);
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        // return $this->response->setJSON($this->request->getPost());

        $cod_receber        = $this->request->getPost("cod_receber");
        $cad_valor          = formatValorBD($this->request->getPost("cad_valor"));

        $cad_parcela        = $this->request->getPost("cad_parcela");
        $cad_parcela_total  = $this->request->getPost("cad_parcela_total");
        $cad_vencimento     = $this->request->getPost("cad_vencimento");
        $cad_diasparc       = $this->request->getPost("cad_diasparc");
        $serial             = getSerial();

        if ($cod_receber == '') {

            if ($this->request->getPost("cad_vencimento") != null) {
                $des_vencimento = explode("-", $cad_vencimento);
                $dia = $des_vencimento[2];
                $mes = $des_vencimento[1];
                $ano = $des_vencimento[0];
            } else {
                $dia = date("d");
                $mes = date("m");
                $ano = date("Y");
            }

            $pac_r = number_format(($cad_valor - (number_format(($cad_valor / $cad_parcela), 2, '.', '') * $cad_parcela)), 2, '.', '');
            $parcela = number_format(($cad_valor / $cad_parcela), 2, '.', '');

            for ($x = 1; $x <= $cad_parcela; $x++) {

                if ($cad_diasparc != null) {
                    $rec_vencimento = getDiaUtil(($cad_diasparc * ($x - 1)), $dia, $mes, $ano, false);
                } else {
                    $rec_vencimento = getDiaUtil(($x - 1), $dia, $mes, $ano, true);
                }

                ($x == 1) ? $parc_valor = $parcela + $pac_r : $parc_valor = $parcela;

                $weekend = date('D', strtotime($rec_vencimento));

                $data[$x]['pessoa_id']          = $this->request->getPost('cod_pessoa');
                $data[$x]['subgrupo_id']        = $this->request->getPost('cod_subgrupo');
                $data[$x]['rec_referencia']     = returnNull($this->request->getPost("cad_referencia"), 'S');
                $data[$x]['rec_parcela']        = $x;
                $data[$x]['rec_parcela_total']  = $cad_parcela;
                $data[$x]['rec_vencimento']     = $rec_vencimento;
                $data[$x]['rec_observacao']     = returnNull($this->request->getPost("cad_observacao"), 'S');
                $data[$x]['rec_valor']          = $parc_valor;
                $data[$x]['rec_saldo']          = $parc_valor;
                $data[$x]['situacao']           = 2;
                $data[$x]['serial']             = $serial;
            }
        } else {

            $data['pessoa_id']          = $this->request->getPost('cod_pessoa');
            $data['subgrupo_id']        = $this->request->getPost('cod_subgrupo');
            $data['rec_referencia']     = returnNull($this->request->getPost("cad_referencia"), 'S');
            $data['rec_parcela']        = $cad_parcela;
            $data['rec_parcela_total']  = $cad_parcela_total;
            $data['rec_vencimento']     = $cad_vencimento;
            $data['rec_observacao']     = returnNull($this->request->getPost("cad_observacao"), 'S');
            $data['rec_valor']          = $cad_valor;
            $data['rec_saldo']          = $cad_valor;
            $data['situacao']           = 2;
        }

        // return $this->response->setJSON($data);

        $entityContaReceber = new FinanceiroContaReceber($data);

        if (!empty($this->request->getPost('cod_receber'))) {
            $data['id_receber'] = $this->request->getPost('cod_receber');

            $result = $this->buscaRegistro404($data['id_receber']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA CONTA A RECENER $result->id_receber PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();

            $salvarContaReceber = $this->contaReceberModel->save($data);
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityContaReceber->auditoriaInsertAtributos();

            $salvarContaReceber = $this->contaReceberModel->insertBatch($data);
        };

        try {
            if ($salvarContaReceber) {

                $this->auditoriaModel->insertAuditoria('financeiro', 'contareceber', $metedoAuditoria, $dataAuditoria);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A CONTA A RECEBER FOI CADASTRADA!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function savePayment()
    {
        try {
            if (!$this->request->isAJAX()) {
                return redirect()->back();
            }

            $this->caixaModel = new \App\Models\Venda\CaixaModel();

            //  return $this->response->setJSON($this->request->getPost());

            $cod_conta          = $this->request->getPost('id_conta');
            $pag_valor          = formatValorBd($this->request->getPost('pag_valor'));
            $pag_formapagamento = $this->request->getPost('pag_forma');
            $pag_contaPgamento  = $this->request->getPost('pag_conta');
            $pag_bandeira       = $this->request->getPost('pag_bandeira');
            $pag_parcela        = $this->request->getPost('pag_parcela');
            $pag_documento      = returnNull($this->request->getPost('pag_documento'), 'S');

            $user_id        = getUsuarioID();
            $datatime       = getDatetimeAtual();

            $serialPagamento    = getSerial();

            $caixa  = $this->caixaModel->where('serial', $this->request->getPost('serial_caixa'))->first();

            if ($caixa == null || $caixa->situacao != 'A') {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => ($caixa == null) ? "NÃO FOI LOCALIZADO O CAIXA!" : "O CAIXA INFORMADO NÃO ESTA ABERTO!"
                    ]
                ]);
            }

            $pagData['caixa_id']            = $caixa->id_caixa;

            // VERIFICA SE O PAGAMENTO FOI POR CARTÃO
            if ($pag_formapagamento == '3' || $pag_formapagamento == '4') {
                $formaParcelamento      = $this->formaParcelamento->getFormaBandeiraParcela($pag_contaPgamento, $pag_bandeira, $pag_parcela);
                $pagData['formapac_id'] = $formaParcelamento->cod_formapac;
            }

            // VERIFICA SE O PAGAMENTO FOI POR TRANSFERENCIA
            if ($pag_formapagamento == '2') {
                $pagData['conta_id']    = $pag_contaPgamento;
            }

            $pagData['pag_formapagamento']  = $pag_formapagamento;
            $pagData['pag_valor']           = $pag_valor;
            $pagData['pag_documento']       = $pag_documento;
            $pagData['pag_parcela']         = ($pag_parcela == NULL) ? 1 : $pag_parcela;
            $pagData['serial']              = '';
            $pagData['situacao']            = 2;
            $pagData['created_user_id']     = $user_id;
            $pagData['created_at']          = $datatime;
            // $pagData VARIAVEL PARA GRAVAÇÃO NA TABELA fin_pagamento

            $this->pagamentoModel = new \App\Models\Financeiro\PagamentoModel();

            if ($this->pagamentoModel->save($pagData)) {
                // RETORNA O id_pagamento PARA INSERIR NAS DEMAIS TABELAS
                $pagamento_id = $this->pagamentoModel->getInsertID();
            }

            //  return $this->response->setJSON($pagamento_id);

            $valPagamento   = formatValorBd($this->request->getPost('pag_valor'));

            $resultContas = $this->contaReceberModel->getContaReceberInCodigo($cod_conta);

            // GERA AS BAIXAS DOS PAGAMENTOS POR PARCELA
            for ($i = 0; $i < count($resultContas); $i++) {
                if ($valPagamento > 0) {

                    $data[$i]['pagamento_id']   = $pagamento_id;
                    $data[$i]['receber_id']     = $resultContas[$i]->cod_receber;
                    $data[$i]['serial']         = $serialPagamento;
                    // $data[$i]['divida'] = $resultContas[$i]->saldo;

                    if ($i == count($resultContas) - 1) {
                        $pagParcelaValor = $valPagamento;
                    } else {
                        if ($resultContas[$i]->saldo <= $valPagamento) {
                            $pagParcelaValor = $resultContas[$i]->saldo;
                        } else {
                            $pagParcelaValor = (($valPagamento - $resultContas[$i]->saldo) <= 0) ? $valPagamento : 0;
                        }
                    }

                    $data[$i]['det_valor'] = $pagParcelaValor;

                    $valPagamento = number_format($valPagamento - $pagParcelaValor, 2, '.', '');
                    // $data[$i]['restante'] = $valPagamento;

                    // $data[$i]['created_user_id'] = $user_id;
                    // $data[$i]['created_at'] = $datatime;
                }
            }

            $this->pagamentoDetalheModel = new \App\Models\Financeiro\PagamentoDetalheModel();

            try {
                if ($this->pagamentoDetalheModel->insertBatch($data)) {
                    // RETORNA O id_pagamento PARA INSERIR NAS DEMAIS TABELAS
                    $detalhe_id = $this->pagamentoDetalheModel->getPagamentosContaReceber($serialPagamento, $pagamento_id);
                }
            } catch (\Throwable $th) {
                return $this->response->setJSON($this->responseTryThrowable($th));
            }

            return $this->response->setJSON($data);

            // return $this->response->setJSON($this->request->getPost('id_conta'));
            return $this->response->setJSON($resultContas);
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function show($paramentro)
    {
        try {
            $return = $this->contaReceberModel->where('id_receber', $paramentro)
                ->first();
            return $this->response->setJSON($return);
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function removerPagamento($codigo = null)
    {
        $movimento = $this->contaReceberModel->where('id_receber', $codigo)
            ->where('situacao', 1)
            ->first();

        if ($movimento === null) {
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
            if ($this->contaReceberModel->deletarRegistro($codigo)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO DELETADO COM SUCESSO!',
                        'description' => "O PAGAMENTO $movimento->id_receber FOI REMOVIDO!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    private function buscaRegistro404(int $codigo = null)
    {
        try {
            if (!$codigo || !$resultado = $this->contaReceberModel->withDeleted(true)->find($codigo)) {
                return null;
            }
            return $resultado;
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    private function buscaPagamentoSerial(string $serial = null)
    {
        try {
            $this->pagamentoModel = new \App\Models\Financeiro\PagamentoModel();
            if (!$serial || !$resultado = $this->pagamentoModel->withDeleted(true)->where('serial', $serial)->find()) {
                return null;
            }
            return $resultado;
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }
}
