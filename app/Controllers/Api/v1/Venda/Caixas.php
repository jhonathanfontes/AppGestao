<?php

namespace App\Controllers\Api\v1\Venda;

use App\Controllers\Api\ApiController;
use App\Entities\Venda\Caixa;

class Caixas extends ApiController
{
    protected $caixaModel;
    protected $validation;

    private $pessoaModel;
    private $orcamentoModel;

    private $pagamentoModel;
    private $formaPagamentoModel;
    private $formaPacelamentoModel;

    private $contaReceberModel;

    private $subgrupoModel;

    private $auditoriaModel;
    private $movimentoFinanceiroModel;


    public function __construct()
    {
        $this->caixaModel               = new \App\Models\Venda\CaixaModel();
        // $this->auditoriaModel           = new \App\Models\AuditoriaModel();
        $this->movimentoFinanceiroModel = new \App\Models\Financeiro\MovimentacaoModel();
        $this->validation               =  \Config\Services::validation();
    }

    public function getCarregaTabelaFechado()
    {
        $response = array();

        $result = $this->caixaModel->getCaixas();

        foreach ($result as $key => $value) {

            $ops = '<a class="btn btn-xs btn-primary" href="caixa/' . $value->serial . '"><span class="far fa-eye"></span> VISUALIZAR </a>';
            $ops .= '<a class="btn btn-xs btn-outline-info ml-2" href="pessoas/view/' . $value->serial . '"><span class="fas fa-print"></span> IMPRIMIR </a>';

            $response['data'][$key] = array(
                esc($value->id),
                formatDataTimeBR(esc($value->created_at)),
                formatValorBR(esc($value->total)),
                esc($value->use_abertura),
                formatDataTimeBR(esc($value->fec_at)),
                formatValorBR(esc($value->f_total)),
                esc($value->use_fechamento),
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

        $data['gru_tipo']           = returnNull($this->request->getPost('cad_tipo'), 'S');
        $data['gru_descricao']      = returnNull($this->request->getPost('cad_caixa'), 'S');
        $data['gru_classificacao']  = $this->request->getPost('cad_classificacao');
        $data['status']             = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_caixa'))) {
            $data['id'] = $this->request->getPost('cod_caixa');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA GRUPO $result->cad_caixa PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->caixaModel->save($data)) {

                $cod_caixa = (!empty($this->request->getPost('cod_caixa'))) ? $this->request->getPost('cod_caixa') : $this->caixaModel->getInsertID();

                $return = $this->caixaModel->returnSave($cod_caixa);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A GRUPO $return->cad_caixa FOI SALVAR!"
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
        $return = $this->caixaModel
            ->where('status', 1)
            ->orderBy('gru_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->caixaModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $caixa = $this->caixaModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($caixa === null) {
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
            if ($this->caixaModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O GRUPO $caixa->cad_caixa FOI ARQUIVADO!"
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

    public function abrirCaixa()
    {
        try {
            if ($this->request->getPost()) {

                // return $this->response->setJSON($this->request->getPost());
                $serial      = getSerial();

                if ($this->caixaModel->where('serial', $serial)->first() == null) {
                    $data['serial'] = $serial;
                } else {
                    $data['serial'] = getSerial();
                }

                $data['moeda_01']     = (empty($this->request->getPost('moeda_01')) ? 0 : $this->request->getPost('moeda_01'));
                $data['moeda_05']     = (empty($this->request->getPost('moeda_05')) ? 0 : $this->request->getPost('moeda_05'));
                $data['moeda_10']     = (empty($this->request->getPost('moeda_10')) ? 0 : $this->request->getPost('moeda_10'));
                $data['moeda_25']     = (empty($this->request->getPost('moeda_25')) ? 0 : $this->request->getPost('moeda_25'));
                $data['moeda_50']     = (empty($this->request->getPost('moeda_50')) ? 0 : $this->request->getPost('moeda_50'));
                $data['moeda_1']      = (empty($this->request->getPost('moeda_1')) ? 0 : $this->request->getPost('moeda_1'));
                $data['total_moeda']   = (empty($this->request->getPost('total_moeda')) ? 0 : $this->request->getPost('total_moeda'));

                $data['cedula_2']     = (empty($this->request->getPost('cedula_2')) ? 0 : $this->request->getPost('cedula_2'));
                $data['cedula_5']     = (empty($this->request->getPost('cedula_5')) ? 0 : $this->request->getPost('cedula_5'));
                $data['cedula_10']    = (empty($this->request->getPost('cedula_10')) ? 0 : $this->request->getPost('cedula_10'));
                $data['cedula_20']    = (empty($this->request->getPost('cedula_20')) ? 0 : $this->request->getPost('cedula_20'));
                $data['cedula_50']    = (empty($this->request->getPost('cedula_50')) ? 0 : $this->request->getPost('cedula_50'));
                $data['cedula_100']   = (empty($this->request->getPost('cedula_100')) ? 0 : $this->request->getPost('cedula_100'));
                $data['total_cedula'] = (empty($this->request->getPost('total_cedula')) ? 0 : $this->request->getPost('total_cedula'));

                $data['situacao']   = '1';

                $data['cai_logged'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);

                // $data['cai_logged'] = $this->request->getPost('cai_logged');

                $data['total']   = (empty($this->request->getPost('abrir_valor')) ? 0 : $this->request->getPost('abrir_valor'));
              
                // return $this->response->setJSON($data);

                if ($this->caixaModel->save($data)) {

                    $return = $this->caixaModel->returnSave($this->caixaModel->getInsertID());

                    return $this->response->setJSON([
                        'status' => true,
                        'data'  => $return,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'REGISTRO SALVO COM SUCESSO!',
                            'description' => "O CAIXA Nº $return->id FOI ABERTO!"
                        ]
                    ]);
                }
            } else {
                return $this->response->setJSON(
                    [
                        'status' => false,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL LOCALIZA O REGISTRO!',
                            'description' => 'REGISTRO NÃO INFORMADO OU NÃO LOCALIZADO!'
                        ]
                    ]
                );
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function fecharCaixa()
    {
        try {
            if ($this->request->getPost()) {

                $caixa_serial  = $this->request->getPost("caixa_serial");
                $caixa_codigo  = $this->request->getPost("caixa_codigo");

                $caixa = $this->caixaModel->where('serial', $caixa_serial)->first();

                if ($caixa->id != $caixa_codigo) {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO FOI LOCALIZADO O CAIXA INFORMADO!"
                        ]
                    ]);
                }

                if ($caixa->situacao != '1') {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "O CAIXA INFORMADO JÁ ESTAR FECHADO!"
                        ]
                    ]);
                }

                // return $this->response->setJSON($this->request->getPost());

                $data['id']       = $caixa->id;

                $data['f_moeda_01']     = (empty($this->request->getPost('moeda_01')) ? 0 : $this->request->getPost('moeda_01'));
                $data['f_moeda_05']     = (empty($this->request->getPost('moeda_05')) ? 0 : $this->request->getPost('moeda_05'));
                $data['f_moeda_10']     = (empty($this->request->getPost('moeda_10')) ? 0 : $this->request->getPost('moeda_10'));
                $data['f_moeda_25']     = (empty($this->request->getPost('moeda_25')) ? 0 : $this->request->getPost('moeda_25'));
                $data['f_moeda_50']     = (empty($this->request->getPost('moeda_50')) ? 0 : $this->request->getPost('moeda_50'));
                $data['f_moeda_1']      = (empty($this->request->getPost('moeda_1')) ? 0 : $this->request->getPost('moeda_1'));
                $data['f_total_moeda']   = (empty($this->request->getPost('total_moeda')) ? 0 : $this->request->getPost('total_moeda'));

                $data['f_cedula_2']     = (empty($this->request->getPost('cedula_2')) ? 0 : $this->request->getPost('cedula_2'));
                $data['f_cedula_5']     = (empty($this->request->getPost('cedula_5')) ? 0 : $this->request->getPost('cedula_5'));
                $data['f_cedula_10']    = (empty($this->request->getPost('cedula_10')) ? 0 : $this->request->getPost('cedula_10'));
                $data['f_cedula_20']    = (empty($this->request->getPost('cedula_20')) ? 0 : $this->request->getPost('cedula_20'));
                $data['f_cedula_50']    = (empty($this->request->getPost('cedula_50')) ? 0 : $this->request->getPost('cedula_50'));
                $data['f_cedula_100']   = (empty($this->request->getPost('cedula_100')) ? 0 : $this->request->getPost('cedula_100'));
                $data['f_total_cedula'] = (empty($this->request->getPost('total_cedula')) ? 0 : $this->request->getPost('total_cedula'));

                $data['situacao']       = '2';

                $data['fec_at']    = getDatetimeAtual();
                $data['f_total']   = (empty($this->request->getPost('fecha_valor')) ? 0 : $this->request->getPost('fecha_valor'));
                $data['fec_user_id']     = getUsuarioID();

                // return $this->response->setJSON($data);

                if ($this->caixaModel->save($data)) {

                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'REGISTRO SALVO COM SUCESSO!',
                            'description' => "O CAIXA Nº $caixa->id FOI FECHADO!"
                        ]
                    ]);
                }
            } else {
                return $this->response->setJSON(
                    [
                        'status' => false,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL LOCALIZA O REGISTRO!',
                            'description' => 'REGISTRO NÃO INFORMADO OU NÃO LOCALIZADO!'
                        ]
                    ]
                );
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function paymentVenda()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $this->pessoaModel          = new \App\Models\Cadastro\PessoaModel();
            $this->orcamentoModel       = new \App\Models\Venda\OrcamentoModel();

            $cod_orcamento  = $this->request->getPost('cod_orcamento');
            $cod_pessoa     = $this->request->getPost('cod_cliente');
            $orcamento      = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();
            $pessoa         = $this->pessoaModel->where('id_pessoa', $cod_pessoa)->first();

            if ($cod_orcamento != $orcamento->id_orcamento) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => "NÃO FOI LOCALIZADO O ORÇAMENTO!"
                    ]
                ]);
            } else {

                // $this->pagamentoModel           = new \App\Models\Financeiro\PagamentoModel();
                $this->formaPagamentoModel      = new \App\Models\Configuracao\FormaPagamentoModel();
                $this->formaPacelamentoModel    = new \App\Models\Configuracao\FormaParcelamentoModel();
                $this->contaReceberModel        = new \App\Models\Financeiro\ContaReceberModel();

                $this->subgrupoModel = new \App\Models\Financeiro\SubGrupoModel();
                $receita = $this->subgrupoModel->where('sub_vendapadrao', 'S')->where('status', 1)->first();

                $caixa  = $this->caixaModel->where('serial', $this->request->getPost('serial_caixa'))->first();

                if ($receita == null) {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO FOI PARAMETRIZADO A RECEITA DE VENDA!"
                        ]
                    ]);
                }

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

                $pag_forma      = $this->request->getPost('pag_forma');
                $cod_orcamento  = $this->request->getPost('cod_orcamento');
                $cod_venda      = $this->request->getPost('cod_venda');
                $cod_cliente    = $this->request->getPost('cod_cliente');
                $pag_valor      = formatValorBd($this->request->getPost('pag_valor'));
                $pag_parcela    = ($this->request->getPost('pag_parcela') == NULL) ? 1 : $this->request->getPost('pag_parcela');
                $pag_conta      = $this->request->getPost('pag_conta');
                $pag_bandeira   = $this->request->getPost('pag_bandeira');
                $pag_documento  = returnNull($this->request->getPost('pag_documento'), 'S');
                $serial         = $this->request->getPost('serial');
                $user_id        = getUsuarioID();
                $datatime       = getDatetimeAtual();

                // $pag['caixa_id']        = $caixa->id;
                // $pag['id_formapac']     = $pag_forma;
                // $pag['conta_id']        = $pag_conta;
                // $pag['bandeira_id']     = $pag_bandeira;
                // $pag['orcamento_id']    = $cod_orcamento;
                // $pag['pag_valor']       = $pag_valor;
                // $pag['pag_documento']   = returnNull($pag_documento, 'S');
                // $pag['pag_parcela']     = $pag_parcela;

                if ($pag_forma != 2) {
                    $formaPagamento = $this->formaPagamentoModel->where('id_forma', $pag_conta)->first();
                } else {
                    $formaPagamento = $this->formaPagamentoModel->where('for_forma', 2)->where('status', 1)->first();
                }

                // return $this->response->setJSON($this->request->getPost());
                // $this->pagamentoModel->save($pag);
                // $pagamento = $this->pagamentoModel->getInsertID();

                switch ($pag_forma) {
                    case '1':
                        $dados['caixa_id']              = $caixa->id;
                        $dados['orcamento_id']          = $cod_orcamento;
                        $dados['forma_id']              = $pag_conta;
                        $dados['mov_caixatipo']         = 3;
                        $dados['mov_descricao']         = 'VE -' . $cod_venda . '-' . date("Y");
                        $dados['mov_formapagamento']    = $pag_forma;
                        $dados['mov_es']                = 'E';
                        $dados['situacao']              = 1;
                        $dados['serial']                = $serial;
                        $dados['tb_origem']             = 'VENDAS';
                        $dados['created_user_id']       = $user_id;
                        $dados['created_at']            = $datatime;
                        $dados['mov_documento']         = 'VE' . $cod_venda . '/' . date("Y") . ' PAG-' . $formaPagamento->cad_descricao . ' CLIENTE-' . abreviaNome($pessoa->cad_nome);
                        $dados['mov_valor']             = $pag_valor;
                        $dados['mov_data']              = $datatime;
                        $dados['concilia_documento']    = $pag_documento;

                        // $tabela = 'fin_movimentacao';
                        break;
                    case '2':

                        $dados['caixa_id']              = $caixa->id;
                        $dados['orcamento_id']          = $cod_orcamento;
                        $dados['forma_id']              = $formaPagamento->id_forma;
                        $dados['mov_caixatipo']         = 3;
                        $dados['mov_caixaconcilia']     = 'S';
                        $dados['mov_descricao']         = 'VE-' . $cod_venda . '/' . date("Y");
                        $dados['mov_formapagamento']    = $pag_forma;
                        $dados['mov_es']                = 'E';
                        $dados['situacao']              = 1;
                        $dados['serial']                = $serial;
                        $dados['tb_origem']             = 'VENDAS';
                        $dados['created_user_id']       = $user_id;
                        $dados['created_at']            = $datatime;
                        $dados['conta_recebimento']     = $pag_conta;
                        $dados['mov_documento']         = 'VE' . $cod_venda . '/' . date("Y") . ' PAG-' . $formaPagamento->cad_descricao . ' CLIENTE-' . abreviaNome($pessoa->cad_nome);
                        $dados['mov_valor']             = $pag_valor;
                        $dados['mov_data']              = $datatime;
                        $dados['concilia_data']         = $datatime;
                        $dados['concilia_valor']        = $pag_valor;
                        $dados['concilia_documento']    = $pag_documento;

                        // $tabela = 'fin_movimentacao';
                        break;
                    case '3':

                        $parcelamento = $this->formaPacelamentoModel
                            ->where('forma_id', $pag_conta)
                            ->where('bandeira_id', $pag_bandeira)
                            ->where('fpc_parcela', $pag_parcela)
                            ->first();

                        $dataconcilia   = getDiaUtil($parcelamento->fpc_prazo, date("d"), date("m"), date("Y"), false);
                        $valor          = $pag_valor;
                        $valor_comissao = number_format(($valor * ($parcelamento->fpc_taxa / 100)), 2, '.', '');
                        $valor_banco    = number_format(($valor - $valor_comissao), 2, '.', '');

                        $dados['caixa_id']              = $caixa->id;
                        $dados['orcamento_id']          = $cod_orcamento;
                        $dados['forma_id']              = $pag_conta;
                        $dados['mov_caixatipo']         = 3;
                        $dados['mov_caixaconcilia']     = 'S';
                        $dados['mov_descricao']         = 'VE-' . $cod_venda . '/' . date("Y");
                        $dados['mov_formapagamento']    = $pag_forma;
                        $dados['mov_es']                = 'E';
                        $dados['situacao']              = 1;
                        $dados['serial']                = $serial;
                        $dados['tb_origem']             = 'VENDAS';
                        $dados['created_user_id']       = $user_id;
                        $dados['created_at']            = $datatime;
                        $dados['conta_recebimento']     = $formaPagamento->cod_conta;
                        $dados['mov_documento']         = 'VE' . $cod_venda . '/' . date("Y") . ' PAG-' . $formaPagamento->cad_descricao . ' CLIENTE-' . abreviaNome($pessoa->cad_nome);
                        $dados['mov_valor']             = $valor;
                        $dados['mov_data']              = $datatime;
                        $dados['concilia_data']         = $dataconcilia;
                        $dados['concilia_ad']           = $valor_comissao;
                        $dados['concilia_valor']        = $valor_banco;
                        $dados['concilia_documento']    = $pag_documento;

                        // $tabela = 'fin_movimentacao';
                        break;
                    case '4':

                        $parcelamento = $this->formaPacelamentoModel
                            ->where('forma_id', $pag_conta)
                            ->where('bandeira_id', $pag_bandeira)
                            ->where('fpc_parcela', $pag_parcela)
                            ->first();

                        $parcela_mensal = number_format(($pag_valor / $pag_parcela), 2, '.', '');
                        $resto_parcelas = number_format(($pag_valor - ($parcela_mensal * $pag_parcela)), 2, '.', '');

                        $dataconcilia = getDiaUtil($parcelamento->fpc_prazo, date("d"), date("m"), date("Y"), false);

                        for ($x = 1; $x <= $pag_parcela; $x++) {

                            if ($formaPagamento->cad_antecipa != 'S') {
                                $dataconcilia = getDiaUtil(($parcelamento->fpc_prazo * $x), date("d"), date("m"), date("Y"), false);
                            }

                            ($x == 1) ? $valor = $parcela_mensal + $resto_parcelas : $valor = $parcela_mensal;
                            $valor_comissao = number_format(($valor * ($parcelamento->fpc_taxa / 100)), 2, '.', '');
                            $valor_banco    = number_format(($valor - $valor_comissao), 2, '.', '');

                            $dados[$x]['caixa_id']              = $caixa->id;
                            $dados[$x]['orcamento_id']          = $cod_orcamento;
                            $dados[$x]['forma_id']              = $pag_conta;
                            $dados[$x]['mov_caixatipo']         = 3;
                            $dados[$x]['mov_caixaconcilia']     = 'S';
                            $dados[$x]['mov_descricao']         = 'VE-' . $cod_venda . '/' . date("Y");
                            $dados[$x]['mov_formapagamento']    = $pag_forma;
                            $dados[$x]['mov_es']                = 'E';
                            $dados[$x]['situacao']              = 1;
                            $dados[$x]['serial']                = $serial;
                            $dados[$x]['tb_origem']             = 'VENDAS';
                            $dados[$x]['created_user_id']       = $user_id;
                            $dados[$x]['created_at']            = $datatime;
                            $dados[$x]['conta_recebimento']     = $formaPagamento->cod_conta;
                            $dados[$x]['mov_documento']         = 'VE' . $cod_venda . '/' . date("Y") . ' PAG-' . $formaPagamento->cad_descricao . ' CLIENTE-' . abreviaNome($pessoa->cad_nome);
                            $dados[$x]['mov_parcela']           = $x;
                            $dados[$x]['mov_parcela_total']     = $pag_parcela;
                            $dados[$x]['mov_valor']             = $valor;
                            $dados[$x]['mov_data']              = $datatime;
                            $dados[$x]['concilia_data']         = $dataconcilia;
                            $dados[$x]['concilia_ad']           = $valor_comissao;
                            $dados[$x]['concilia_valor']        = $valor_banco;
                            $dados[$x]['concilia_documento']    = $pag_documento;
                        } //for
                        $tabela = 'fin_movimentacao';
                        break;
                    case '5':

                        $parcela_mensal = number_format(($pag_valor / $pag_parcela), 2, '.', '');
                        $resto_parcelas = number_format(($pag_valor - ($parcela_mensal * $pag_parcela)), 2, '.', '');

                        for ($x = 1; $x <= $pag_parcela; $x++) {

                            $data = getDiaUtil(($formaPagamento->cad_fprazo * $x), date("d"), date("m"), date("Y"), false);
                            ($x == 1) ? $valor = $parcela_mensal + $resto_parcelas : $valor = $parcela_mensal;

                            $dados[$x]['pessoa_id']             = $cod_cliente;
                            $dados[$x]['orcamento_id']          = $cod_orcamento;
                            $dados[$x]['forma_id']              = $pag_conta;
                            $dados[$x]['subgrupo_id']           = $receita->id_subgrupo;
                            $dados[$x]['forma_id']              = $pag_forma;
                            $dados[$x]['rec_referencia']        = 'VE-' . $cod_venda . '/' . date("Y");
                            $dados[$x]['rec_parcela']           = $x;
                            $dados[$x]['rec_parcela_total']     = $pag_parcela;
                            $dados[$x]['rec_vencimento']        = $data;
                            $dados[$x]['rec_observacao']        = $formaPagamento->cad_descricao . ' ' . $x . '-' . $pag_parcela . ' VE' . $cod_venda . '/' . date("Y");
                            $dados[$x]['rec_valor']             = $valor;
                            $dados[$x]['rec_saldo']             = $valor;
                            $dados[$x]['situacao']              = 1;
                            $dados[$x]['serial']                = $serial;
                            $dados[$x]['created_user_id']       = $user_id;
                            $dados[$x]['created_at']            = $datatime;
                            $dados[$x]['rec_documento']         = $pag_documento;
                        } //for

                        $tabela = 'fin_receber';
                        break;
                    default:
                        $dados = array();
                        break;
                }

                //   return $this->response->setJSON($dados);

                if ($pag_forma <= 3) {
                    $codicao = $this->movimentoFinanceiroModel->save($dados);
                }

                if ($pag_forma >= 4) {
                    if ($tabela === 'fin_movimentacao') {
                        $codicao = $this->movimentoFinanceiroModel->insertBatch($dados);
                    }
                    if ($tabela === 'fin_receber') {
                        $codicao = $this->contaReceberModel->insertBatch($dados);
                    }
                }

                if ($codicao) {
                    $return = $this->orcamentoModel->returnSave($orcamento->id_orcamento);
                    return $this->response->setJSON([
                        'status' => true,
                        'data' => $return,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'ORÇAMENTO ATUALIZADO COM SUCESSO!',
                            'description' => "O ORÇAMENTO Nº $return->id_orcamento FOI ALTERADO!"
                        ]
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO FOI POSSIVEL SALVAR AS ALTERAÇÕES!"
                        ]
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function ultimoCaixaFechado()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'true',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => ''
                    ]
                ]
            );
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function addSuplementoCaixa()
    {
        try {
            if ($this->request->getPost()) {

                $caixa_serial  = $this->request->getPost("caixa_serial");
                $caixa_codigo  = $this->request->getPost("caixa_codigo");

                $caixa = $this->caixaModel->where('serial', $caixa_serial)->first();

                if ($caixa->id != $caixa_codigo) {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO FOI LOCALIZADO O CAIXA INFORMADO!"
                        ]
                    ]);
                }

                if ($caixa->situacao != '1') {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "O CAIXA INFORMADO NÃO ESTA ABERTO!"
                        ]
                    ]);
                }

                $data['caixa_id']               = $caixa->id;
                $data['forma_id']               = $this->request->getPost('sup_forma');
                $data['mov_caixatipo']          = 1;
                $data['mov_descricao']          = 'SUPLEMENTO Nº ' . $caixa->id;
                $data['mov_formapagamento']     = 1;
                $data['mov_es']                 = 'E';
                $data['mov_valor']              = formatValorBD($this->request->getPost('sup_valor'));
                $data['mov_data']               = getDatetimeAtual();
                $data['mov_documento']          = returnNull($this->request->getPost('sup_documento'), 'S');
                $data['serial']                 = $caixa_serial;
                $data['situacao']               = 2;
                $data['tb_origem']              = 'CAIXA';

                if ($this->movimentoFinanceiroModel->save($data)) {

                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'REGISTRO SALVO COM SUCESSO!',
                            'description' => "O CAIXA Nº $caixa->id FOI SUPLEMENTADO!"
                        ]
                    ]);
                }
            } else {
                return $this->response->setJSON(
                    [
                        'status' => false,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL LOCALIZA O REGISTRO!',
                            'description' => 'REGISTRO NÃO INFORMADO OU NÃO LOCALIZADO!'
                        ]
                    ]
                );
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function addSangriaCaixa()
    {
        try {
            if ($this->request->getPost()) {

                // return $this->response->setJSON($this->request->getPost());

                $caixa_serial   = $this->request->getPost("caixa_serial");
                $caixa_codigo   = $this->request->getPost("caixa_codigo");
                $forma_sagria   = $this->request->getPost("forma_sagria");

                $caixa = $this->caixaModel->where('serial', $caixa_serial)->first();

                if ($caixa->id != $caixa_codigo) {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO FOI LOCALIZADO O CAIXA INFORMADO!"
                        ]
                    ]);
                }

                if ($caixa->situacao != '1') {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "O CAIXA INFORMADO NÃO ESTA ABERTO!"
                        ]
                    ]);
                }

                $data['caixa_id']               = $caixa->id;
                $data['forma_id']               = $this->request->getPost('san_forma');
                $data['mov_caixatipo']          = 2;
                $data['mov_descricao']          = (($forma_sagria == 1) ? 'SANGRIA Nº ' : 'DEPOSITO DO CAIXA Nº ') . $caixa->id;
                $data['mov_formapagamento']     = 1;
                $data['mov_es']                 = 'S';
                $data['mov_valor']              = formatValorBD($this->request->getPost('san_valor'));
                $data['mov_data']               = getDatetimeAtual();
                $data['mov_documento']          = returnNull($this->request->getPost('san_documento'), 'S');
                $data['serial']                 = $caixa_serial;
                $data['situacao']               = 2;
                $data['tb_origem']              = 'CAIXA';

                if ($forma_sagria == 2) {
                    $conta_bancaria = $this->request->getPost("cod_conta");

                    $data['mov_caixaconcilia']  = 'S';
                    $data['conta_recebimento']  = $conta_bancaria;
                    $data['concilia_data']      = getDatetimeAtual();
                    $data['concilia_valor']     = formatValorBD($this->request->getPost('san_valor'));
                }

                // return $this->response->setJSON($data);


                if ($this->movimentoFinanceiroModel->save($data)) {

                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'REGISTRO SALVO COM SUCESSO!',
                            'description' => "O CAIXA Nº $caixa->id FOI SUPLEMENTADO!"
                        ]
                    ]);
                }
            } else {
                return $this->response->setJSON(
                    [
                        'status' => false,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL LOCALIZA O REGISTRO!',
                            'description' => 'REGISTRO NÃO INFORMADO OU NÃO LOCALIZADO!'
                        ]
                    ]
                );
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->caixaModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }

    public function removerPagamento($paramentro = null)
    {
        $movimento = $this->movimentoFinanceiroModel->where('codigo', $paramentro)
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
            if ($this->movimentoFinanceiroModel->cancelarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO DELETADO COM SUCESSO!',
                        'description' => "O PAGAMENTO $movimento->codigo FOI REMOVIDO!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function removerBoleto($codigo = null)
    {
        try {

            $this->contaReceberModel        = new \App\Models\Financeiro\ContaReceberModel();

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
}
