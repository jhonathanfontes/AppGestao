<?php

namespace App\Controllers\Api\Financeiro;

use App\Controllers\Api\ApiController;
use App\Entities\Financeiro\ContaPagar as FinanceiroContaPagar;
use App\Models\Financeiro\ContaPagarModel;
use App\Models\Financeiro\MovimentacaoModel;

class ContaPagar extends ApiController
{
    protected $contaPagarModel;
    protected $movimentacaoModel;
    protected $auditoriaModel;
    protected $validation;

    public function __construct()
    {
        $this->contaPagarModel = new ContaPagarModel();
        $this->movimentacaoModel = new MovimentacaoModel();
        $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->contaPagarModel->getContasPagar();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalPagar" onclick="getEditPagar(' . $value->cod_pagar . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '	<a class="btn btn-xs btn-success ml-2" href="' . base_url('app/financeiro/contapagar/view/' . $value->cod_pagar) . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';

            $response['data'][$key] = array(
                formatDataBR(esc($value->vencimento)),
                formatValorBR(esc($value->valor)),
                formatValorBR(esc($value->cancelado)),
                formatValorBR(esc($value->recebido)),
                formatValorBR(esc($value->saldo)),
                esc($value->des_fornecedor),
                esc($value->referencia),
                esc($value->parcela) . '/' . esc($value->parcela_total),
                $ops,
            );
        }

        return $this->response->setJSON($response);
    }

    public function getCarregaTabelaByFornecedor()
    {
        try {
            $response['data'] = array();
            $result = $this->contaPagarModel->getContasPagarByFornecedor()->findAll();
            if ($result) {
                foreach ($result as $key => $value) {
                    $response['data'][$key] = array(
                        esc($value->des_cliente),
                        formatValorBR(esc($value->pag_valor)),
                        formatValorBR(esc($value->pag_cancelado)),
                        formatValorBR(esc($value->pag_recebido)),
                        formatValorBR(esc($value->pag_saldo)),
                        formatValorBR(esc($value->val_vencida)),
                        ($value->pac_vencida <> 0) ? '<span class="badge badge-danger">PARCELAS ' . esc($value->pac_vencida) . '</span>' : '',
                        formatValorBR(esc($value->val_pendente)),
                        ($value->pac_pendente <> 0) ? '<span class="badge badge-success">PARCELAS ' . esc($value->pac_pendente) . '</span>' : '',
                        '<a class="btn btn-xs btn-success ml-2" href="' . base_url('app/financeiro/contapagar/fornecedor/' . $value->cod_pessoa) . '"><span class="fas fa-tasks"></span> GERENCIAR </a>',
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
            $result = $this->movimentacaoModel->getPagamentosContaPagar($serial, $codigo);

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

        return $this->response->setJSON($response);
    }

    public function findAllWhere()
    {
        try {
            $cod_pagar = $this->request->getPost('cod_pagar');
            $result = $this->contaPagarModel->getContaPagarInCodigo($cod_pagar);
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

        $cod_pagar        = $this->request->getPost("cod_pagar");
        $cad_valor          = formatValorBD($this->request->getPost("cad_valor"));

        $cad_parcela        = $this->request->getPost("cad_parcela");
        $cad_parcela_total  = $this->request->getPost("cad_parcela_total");
        $cad_vencimento     = $this->request->getPost("cad_vencimento");
        $cad_diasparc       = $this->request->getPost("cad_diasparc");
        $serial             = getSerial();

        if ($cod_pagar == '') {

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
                    $pag_vencimento = getDiaUtil(($cad_diasparc * ($x - 1)), $dia, $mes, $ano, false);
                } else {
                    $pag_vencimento = getDiaUtil(($x - 1), $dia, $mes, $ano, true);
                }

                ($x == 1) ? $parc_valor = $parcela + $pac_r : $parc_valor = $parcela;

                $weekend = date('D', strtotime($pag_vencimento));

                $data[$x]['pessoa_id']          = $this->request->getPost('cod_pessoa');
                $data[$x]['subgrupo_id']        = $this->request->getPost('cod_subgrupo');
                $data[$x]['pag_referencia']     = returnNull($this->request->getPost("cad_referencia"), 'S');
                $data[$x]['pag_parcela']        = $x;
                $data[$x]['pag_parcela_total']  = $cad_parcela;
                $data[$x]['pag_vencimento']     = $pag_vencimento;
                $data[$x]['pag_observacao']     = returnNull($this->request->getPost("cad_observacao"), 'S');
                $data[$x]['pag_valor']          = $parc_valor;
                $data[$x]['pag_saldo']          = $parc_valor;
                $data[$x]['situacao']           = 2;
                $data[$x]['serial']             = $serial;
            }
        } else {

            $data['pessoa_id']          = $this->request->getPost('cod_pessoa');
            $data['subgrupo_id']        = $this->request->getPost('cod_subgrupo');
            $data['pag_referencia']     = returnNull($this->request->getPost("cad_referencia"), 'S');
            $data['pag_parcela']        = $cad_parcela;
            $data['pag_parcela_total']  = $cad_parcela_total;
            $data['pag_vencimento']     = $cad_vencimento;
            $data['pag_observacao']     = returnNull($this->request->getPost("cad_observacao"), 'S');
            $data['pag_valor']          = $cad_valor;
            $data['pag_saldo']          = $cad_valor;
            $data['situacao']           = 2;
        }

        // return $this->response->setJSON($data);

        $entityContaPagar = new FinanceiroContaPagar($data);

        if (!empty($this->request->getPost('cod_pagar'))) {
            $data['id_pagar'] = $this->request->getPost('cod_pagar');

            $result = $this->buscaRegistro404($data['id_pagar']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA CONTA A RECENER $result->id_pagar PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();

            $salvarContaPagar = $this->contaPagarModel->save($data);
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityContaPagar->auditoriaInsertAtributos();

            $salvarContaPagar = $this->contaPagarModel->insertBatch($data);
        };

        try {
            if ($salvarContaPagar) {

                $this->auditoriaModel->insertAuditoria('financeiro', 'contapagar', $metedoAuditoria, $dataAuditoria);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A CONTA A PAGAR FOI CADASTRADA!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function show($paramentro)
    {
        $return = $this->contaPagarModel->where('id_pagar', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->contaPagarModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
