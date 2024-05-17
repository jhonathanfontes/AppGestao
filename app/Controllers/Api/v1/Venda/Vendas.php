<?php

namespace App\Controllers\Api\v1\Venda;

use App\Controllers\Api\ApiController;
use App\Entities\Venda\Orcamento;

class Vendas extends ApiController
{
    private $pessoaModel;
    private $orcamentoModel;
    private $vendaModel;
    private $produtoGradeModel;
    private $estoqueModel;
    private $vendedorModel;

    private $pagamentoModel;
    private $formaPagamentoModel;
    private $formaPacelamentoModel;

    private $subgrupoModel;

    private $contaReceberModel;
    private $movimentacaoModel;

    protected $caixaModel;
    private $auditoriaModel;

    private $validation;

    public function __construct()
    {
        $this->pessoaModel = new \App\Models\Cadastro\PessoaModel();
        $this->orcamentoModel = new \App\Models\Venda\OrcamentoModel();
        $this->vendaModel = new \App\Models\Venda\VendaModel();
        $this->produtoGradeModel = new \App\Models\Cadastro\ProdutoGradeModel();
        // $this->estoqueModel = new \App\Models\Estoque\DetalheModel();
        $this->vendedorModel = new \App\Models\Configuracao\VendedorModel();

        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getOrcamentoAbertoTabela()
    {
        $response['data'] = array();

        $result = $this->orcamentoModel->returnOrcamentos()
            ->where('situacao', 4)
            ->where('orc_tipoorcamento', 1)
            ->where('orc_dataorcamento >=', date("Y-m-d", strtotime("- 30 days")))
            ->findAll();

        foreach ($result as $key => $value) {

            $ops = '<a href="orcamento/selling/' . $value->serial . '" class="btn btn-xs btn-success"><span class="fas fa-tasks"></span> GERENCIAR </a>';
            $ops .= '<a href="venda/imprimir/' . $value->serial . '" class="btn btn-xs btn-primary ml-2" target="_blank"><samp class="fas fa-print"></samp> IMPRIMIR</a>';

            $response['data'][$key] = array(
                date("Y", strtotime(esc($value->orc_dataorcamento))) . completeComZero(esc($value->id), 8),
                abreviaNome(esc($value->pessoa)),
                esc($value->usuario),
                formatDataTimeBR(esc($value->orc_dataorcamento)),
                $ops,
            );
        }

        return $this->response->setJSON($response);
    }

    public function getDetalheOrcamento(int $codigo = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $cod_grade = $this->request->getPost('cod_grade');
            $result = $this->estoqueModel->listarDetalhes()->where('id_detalhe', $cod_grade)->first();
            $orcamento = $this->orcamentoModel->where('id_orcamento', $result->cod_orcamento)->first();

            if ($orcamento != null) {

                $data['cod_detalhe'] = $result->cod_detalhe;
                $data['cod_orcamento'] = $result->cod_orcamento;
                $data['cod_produto'] = $result->cod_produto;
                $data['cod_tamanho'] = $result->cod_tamanho;
                $data['qtn_produto'] = $result->qtn_produto;
                $data['qtn_devolvido'] = $result->qtn_devolvido;
                $data['qtn_saldo'] = $result->qtn_saldo;
                $data['presente'] = $result->presente;
                $data['produto'] = $result->produto;
                $data['tamanho'] = $result->tamanho;

                if ($orcamento->orc_tipo == 1) {
                    $data['cod_tipo'] = 1;
                    $data['val_un'] = $result->valor_un;
                    $data['val_ad'] = $result->valor_ad;
                    $data['val_unad'] = $result->valor_unad;
                    $data['total_unad'] = $result->praz_total;
                }
                if ($orcamento->orc_tipo == 2) {
                    $data['cod_tipo'] = 2;
                    $data['val_un'] = $result->praz_valor_un;
                    $data['val_ad'] = $result->praz_valor_ad;
                    $data['val_unad'] = $result->praz_valor_unad;
                    $data['total_unad'] = $result->praz_total_unad;
                }

                $data['usuario'] = $result->usuario;

                return $this->response->setJSON($data);
            } else {

                return $this->response->setJSON($result);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function sale()
    {
        try {
            if ($this->request->getPost()) {

                $cod_pessoa = $this->request->getPost("cod_pessoa");
                $serial = $cod_pessoa . getSerial();

                $data['venda_tipo'] = $this->request->getPost("cod_tipo");
                $data['pessoa_id'] = $cod_pessoa;

                if ($this->buscaRegistro404($serial) == null) {
                    $data['serial'] = $serial;
                } else {
                    $data['serial'] = $cod_pessoa . getSerial();
                }

                // $data['vendedor_id'] = $this->vendedorModel->getVendedorLogado()->id_vendedor;

                $entityOrcamento = new Orcamento($data);

                $metedoAuditoria = 'insert';
                $dataAuditoria = $entityOrcamento->auditoriaInsertAtributos();


                if ($this->orcamentoModel->save($data)) {

                    // $this->auditoriaModel->insertAuditoria('venda', 'orcamento', $metedoAuditoria, $dataAuditoria);
                    $return = $this->orcamentoModel->returnSave($this->orcamentoModel->getInsertID());

                    return $this->response->setJSON([
                        'status' => true,
                        'data' => $return,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'REGISTRO SALVO COM SUCESSO!',
                            'description' => "O ORÇAMENTO Nº $return->id_orcamento FOI SALVO!"
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

    public function pdvSale()
    {
        $orcamento = $this->orcamentoModel->where('venda_tipo', 1)
            ->where('situacao', 4)
            ->where('orc_pdv', 'S')
            ->findAll();

        try {

            if (count($orcamento) == 0) {
                $pessoa = $this->pessoaModel->getPessoaPadrao('F');
                if ($pessoa == null) {
                    return redirect()->to('/');
                }

                $cod_pessoa = $pessoa->id_pessoa;
                $serial = $cod_pessoa . getSerial();

                $data['venda_tipo'] = 1;
                $data['orc_tipo'] = 1;
                $data['orc_pdv'] = 'S';
                $data['pessoa_id'] = $cod_pessoa;

                if ($this->buscaRegistro404($serial) == null) {
                    $data['serial'] = $serial;
                } else {
                    $data['serial'] = $cod_pessoa . getSerial();
                }

                $data['vendedor_id'] = $this->vendedorModel->getVendedorLogado()->id_vendedor;

                $entityOrcamento = new Orcamento($data);

                $metedoAuditoria = 'insert';
                $dataAuditoria = $entityOrcamento->auditoriaInsertAtributos();

                if ($this->orcamentoModel->save($data)) {

                    $this->auditoriaModel->insertAuditoria('venda', 'orcamento', $metedoAuditoria, $dataAuditoria);
                    $return = $this->orcamentoModel->returnSave($this->orcamentoModel->getInsertID());

                    $venda_data['orcamento_id'] = $return->id_orcamento;
                    $venda_data['caixa_id'] = null;
                    $venda_data['ven_data'] = getDatetimeAtual();
                    $venda_data['ven_usuario_id'] = $this->vendedorModel->getVendedorLogado()->id_vendedor;
                    $venda_data['ven_tipo'] = 1;
                    $venda_data['situacao'] = 4;
                    $venda_data['serial'] = $serial;

                    $this->vendaModel->save($venda_data);

                    return $this->response->redirect(site_url('app/venda/pdv/selling/' . $return->serial));
                }
            } else {
                return $this->response->redirect(site_url('app/venda/pdv/selling/' . $orcamento[0]->serial));
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

    public function getVendaReceber()
    {
        try {

            if (!$this->request->isAJAX()) {
                return redirect()->back();
            }

            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();
            $venda = $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first();

            return $this->response->setJSON($venda);
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

    public function addProdutoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $quantidade = $this->request->getPost('quantidade');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();
            $produto = $this->produtoGradeModel->getProdutoGrade()
                ->where('pdv_produtograde.codigo', $this->request->getPost('cat_grade'))
                ->where('pdv_produtograde.status', 1)
                ->first();

            $data['orcamento_id'] = $orcamento->id_orcamento;
            $data['produto_id'] = $produto->produto_id;
            $data['tamanho_id'] = $produto->tamanho_id;
            $data['mvd_tipo'] = 'S';
            $data['qtn_produto'] = $quantidade;
            $data['qtn_saldo'] = $quantidade;

            $data['mvd_val_un'] = bcadd($produto->valor_vendaavista, '0', 2);
            $data['mvd_val_unad'] = bcadd($produto->valor_vendaavista, '0', 2);
            $data['mvd_total'] = bcadd(($produto->valor_vendaavista * $quantidade), '0', 2);
            $data['mvd_total_unad'] = bcadd(($produto->valor_vendaavista * $quantidade), '0', 2);


            $data['mpd_val_un'] = bcadd($produto->valor_vendaprazo, '0', 2);
            $data['mpd_val_unad'] = bcadd($produto->valor_vendaprazo, '0', 2);
            $data['mpd_total'] = bcadd(($produto->valor_vendaprazo * $quantidade), '0', 2);
            $data['mpd_total_unad'] = bcadd(($produto->valor_vendaprazo * $quantidade), '0', 2);

            $data['serial'] = $orcamento->serial;
            $data['fleg_atualiza'] = null;

            if ($this->estoqueModel->save($data)) {

                $cod_detalhe = (!empty($this->request->getPost('cod_detalhe'))) ? $this->request->getPost('cod_detalhe') : $this->estoqueModel->getInsertID();

                $return = $this->estoqueModel->returnSave($cod_detalhe);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O PRODUTO FOI ADICIONADO COM SUCESSO!"
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

        return $this->response->setJSON(
            [
                'data' => $data,
                'orcamento' => $orcamento,
                'produto' => $produto,
                'post' => $this->request->getPost()
            ]
        );
    }

    public function delProdutoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();

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
                $cod_detalhe = $this->request->getPost('cod_detalhe');
                if ($this->estoqueModel->deletarRegistros($cod_detalhe, $orcamento->id_orcamento, null)) {

                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'ORÇAMENTO ATUALIZADO COM SUCESSO!',
                            'description' => "ITENS SELECIONADOS FORAM REMOVIDOS!"
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

        return $this->response->setJSON($this->request->getPost());
    }

    public function updateFormaPagamentoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $cod_tipo = $this->request->getPost('cod_tipo');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();

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
                if ($this->orcamentoModel->update($orcamento->id_orcamento, ['orc_tipo' => $cod_tipo])) {
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

    public function updateClienteOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $cod_pessoa = $this->request->getPost('cod_pessoa');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();

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
                if ($this->orcamentoModel->update($orcamento->id_orcamento, ['pessoa_id' => $cod_pessoa])) {

                    if ($orcamento->orc_pdv == 'S') {
                        $this->contaReceberModel = new \App\Models\Financeiro\ContaReceberModel();
                        $this->contaReceberModel->clienteReceberPDV($orcamento->id_orcamento, $cod_pessoa);
                    }


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

    public function updateVendedorOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $cod_vendedor = $this->request->getPost('cod_vendedor');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();

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
                if ($this->orcamentoModel->update($orcamento->id_orcamento, ['vendedor_id' => $cod_vendedor])) {
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

    public function updateGradeProdutoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $cod_detalhe = $this->request->getPost('id_detalhe');

            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();

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
                $detalhe = $this->estoqueModel->where('id_detalhe', $this->request->getPost('id_detalhe'))->where('orcamento_id', $cod_orcamento)->first();
                // return $this->response->setJSON($orcamento);
                // return $this->response->setJSON($this->request->getPost());

                $cod_tipo = $this->request->getPost('cod_tipo');
                $qnt_produto = $this->request->getPost('qnt_produto');
                $valor_desc = formatValorBD($this->request->getPost('valor_desc'));

                if ($cod_tipo != $orcamento->orc_tipo) {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO O PRODUTO NÃO FOI LOCALIZADO NESTE ORÇAMENTO!"
                        ]
                    ]);
                }

                $dados['qtn_produto'] = $qnt_produto;
                $dados['qtn_saldo'] = $qnt_produto;
                $dados['est_presente'] = $this->request->getPost('presente');

                $dados['mvd_val_ad'] = ($orcamento->orc_tipo == 1) ? $detalhe->mvd_val_un - $valor_desc : $detalhe->mvd_val_ad;
                $dados['mvd_val_unad'] = ($orcamento->orc_tipo == 1) ? $valor_desc : $detalhe->mvd_val_unad;
                $dados['mvd_total_unad'] = ($orcamento->orc_tipo == 1) ? $valor_desc * $qnt_produto : $detalhe->mvd_val_unad * $qnt_produto;
                $dados['mvd_total'] = ($orcamento->orc_tipo == 1) ? $valor_desc * $qnt_produto : $detalhe->mvd_val_unad * $qnt_produto;
                $dados['mpd_val_ad'] = ($orcamento->orc_tipo == 2) ? $detalhe->mpd_val_un - $valor_desc : $detalhe->mpd_val_ad;
                $dados['mpd_val_unad'] = ($orcamento->orc_tipo == 2) ? $valor_desc : $detalhe->mpd_val_unad;
                $dados['mpd_total_unad'] = ($orcamento->orc_tipo == 2) ? $valor_desc * $qnt_produto : $detalhe->mpd_val_unad * $qnt_produto;
                $dados['mpd_total'] = ($orcamento->orc_tipo == 2) ? $valor_desc * $qnt_produto : $detalhe->mpd_val_unad * $qnt_produto;

                if (
                    $this->estoqueModel->update(
                        [
                            'orcamento_id' => $orcamento->id_orcamento,
                            'id_detalhe' => $cod_detalhe
                        ],
                        $dados
                    )
                ) {
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

    public function updateDesconto()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('serial'))->first();

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

                $desc_percentual = returnNull($this->request->getPost('desc_percentual') / 100);
                $desc_val_final = returnNull(formatValorBD($this->request->getPost('desc_val_final')));

                $detalhesOrcamento = $this->estoqueModel->where('orcamento_id', $orcamento->id_orcamento)->where('situacao', 1)->findAll();
                $desc_percentual = (!empty($desc_percentual)) ? $desc_percentual : 0;

                $i = 0;
                if ($orcamento->orc_tipo == 1) {

                    if (!empty($desc_val_final)) {
                        $percentual_valor = returnNull((round(100 - (($desc_val_final / $orcamento->valor_bruto) * 100), 2) / 100));
                    }

                    $percentual_avista = (empty($percentual_valor)) ? $desc_percentual : $percentual_valor;

                    foreach ($detalhesOrcamento as $row) {
                        $val_ad = round($row->mvd_val_un * $percentual_avista, 2);

                        $data[$i]['id_detalhe'] = $row->id_detalhe;
                        $data[$i]['mvd_val_ad'] = $val_ad;
                        $data[$i]['mvd_val_unad'] = round($row->mvd_val_un - $val_ad, 2);
                        $data[$i]['mvd_total_unad'] = round(($row->mvd_val_un - $val_ad) * $row->qtn_produto, 2);
                        $i++;
                    }
                }

                if ($orcamento->orc_tipo == 2) {

                    if (!empty($desc_val_final)) {
                        $percentual_valor = returnNull((round(100 - (($desc_val_final / $orcamento->vpo_bruto) * 100), 2) / 100));
                    }

                    $percentual_prazo = (empty($percentual_valor)) ? $desc_percentual : $percentual_valor;

                    foreach ($detalhesOrcamento as $row) {

                        $val_ad = round($row->mpd_val_un * $percentual_prazo, 2);

                        $data[$i]['id_detalhe'] = $row->id_detalhe;
                        $data[$i]['mpd_val_ad'] = $val_ad;
                        $data[$i]['mpd_val_unad'] = round($row->mpd_val_un - $val_ad, 2);
                        $data[$i]['mpd_total_unad'] = round(($row->mpd_val_un - $val_ad) * $row->qtn_produto, 2);
                        $i++;
                    }
                }

                if ($this->estoqueModel->updateBatch($data, 'id_detalhe')) {

                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'ORÇAMENTO ATUALIZADO COM SUCESSO!',
                            'description' => "O ORÇAMENTO Nº $cod_orcamento FOI ALTERADO!"
                        ]
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                            'description' => "NÃO FOI POSSIVEL SALVAR AS ALTERAÇÕES!"
                        ]
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',

                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function finishOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $cod_orcamento = $this->request->getPost('venda_id');
            $orcamento = $this->orcamentoModel->where('serial', $this->request->getPost('venda_serial'))->first();

            // VERIFICA SE O CODIGO DO ORÇAMENTO E O MESMO DO SERIAL
            if ($cod_orcamento != $orcamento->id_orcamento) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => "NÃO FOI LOCALIZADO O ORÇAMENTO!"
                    ]
                ]);
            }

            $venda = $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first();

            $data['id_venda'] = (!empty($venda)) ? $venda->id_venda : null;
            $data['orcamento_id'] = $orcamento->id_orcamento;
            $data['caixa_id'] = null;
            $data['ven_data'] = getDatetimeAtual();
            $data['ven_usuario_id'] = getUsuarioID();
            $data['ven_tipo'] = $orcamento->orc_tipo;
            $data['val_avista'] = $orcamento->valor_total;
            $data['val_aprazo'] = $orcamento->vpo_total;
            $data['situacao'] = 1;
            $data['serial'] = $orcamento->serial;


            if ($this->vendaModel->save($data)) {

                $finishEstoque = $this->estoqueModel->finishOrcamento($orcamento->id_orcamento);
                $finishOrcamento = $this->orcamentoModel->finishOrcamento($orcamento->id_orcamento, $orcamento->serial);

                if ($finishEstoque && $finishOrcamento) {
                    // return $this->response->setJSON($data);
                }

                return $this->response->setJSON([
                    'status' => true,
                    'data' => $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first(),
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'ORÇAMENTO FINALIZADO COM SUCESSO!',
                        'description' => "O ORÇAMENTO Nº $cod_orcamento FOI FINALIZADO, VOCÊ SERA ENCAMINHADO PARA O CAIXAR!"
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO FOI POSSIVEL SALVAR AS ALTERAÇÕES!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function vendaToOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $this->contaReceberModel = new \App\Models\Financeiro\ContaReceberModel();
            $this->movimentacaoModel = new \App\Models\Financeiro\MovimentacaoModel();

            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $venda_serial = $this->request->getPost('serial');

            $orcamento = $this->orcamentoModel->where('serial', $venda_serial)->first();

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

                $venda = $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first();

                $data['id_venda'] = $venda->id_venda;
                $data['orcamento_id'] = $orcamento->id_orcamento;
                $data['situacao'] = 4;

                $finishVenda = $this->vendaModel->save($data);
                $finishEstoque = $this->estoqueModel->vendaToOrcamento($orcamento->id_orcamento);
                $finishOrcamento = $this->orcamentoModel->vendaToOrcamento($orcamento->id_orcamento, $orcamento->serial);
                $finishAReceber = $this->contaReceberModel->vendaToOrcamento($orcamento->id_orcamento, $orcamento->serial);
                $finishMovimento = $this->movimentacaoModel->vendaToOrcamento($orcamento->id_orcamento, $orcamento->serial);

                $procedimentos = array(
                    'fin_movimentacao' => $finishMovimento,
                    'fin_receber' => $finishAReceber,
                    'pvd_venda' => $finishVenda,
                    'pdv_orcamento' => $finishOrcamento,
                    'est_detalhe' => $finishEstoque,
                );

                if ($procedimentos) {

                    return $this->response->setJSON([
                        'status' => true,
                        'data' => $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first(),
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'ORÇAMENTO RETORNADO COM SUCESSO!',
                            'description' => "O ORÇAMENTO Nº $cod_orcamento FOI RETORNADO, VOCÊ SERA ENCAMINHADO PARA O ORÇAMENTO!"
                        ]
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                            'description' => "NÃO FOI POSSIVEL SALVAR AS ALTERAÇÕES!"
                        ]
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function finishVenda()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $this->contaReceberModel = new \App\Models\Financeiro\ContaReceberModel();
            $this->movimentacaoModel = new \App\Models\Financeiro\MovimentacaoModel();

            $cod_venda = $this->request->getPost('cod_venda');
            $cod_caixa = $this->request->getPost('cod_caixa');
            $cod_orcamento = $this->request->getPost('cod_orcamento');
            $venda_serial = $this->request->getPost('serial');

            //    return $this->response->setJSON($this->request->getPost());

            $orcamento = $this->orcamentoModel->where('serial', $venda_serial)->first();

            if ($cod_orcamento != $orcamento->id_orcamento) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => "NÃO FOI LOCALIZADO O ORÇAMENTO  Nº $cod_orcamento !"
                    ]
                ]);
            } else {

                $venda = $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first();

                if ($cod_venda != $venda->id_venda) {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                            'description' => "NÃO FOI LOCALIZADO A VENDA Nº $cod_venda !"
                        ]
                    ]);
                }

                $data['id_venda'] = $venda->id_venda;
                $data['orcamento_id'] = $orcamento->id_orcamento;
                $data['caixa_id'] = $cod_caixa;
                $data['situacao'] = 2;

                $finishVenda = $this->vendaModel->save($data);
                // $finishEstoque      = $this->estoqueModel->vendaToOrcamento($orcamento->id_orcamento);
                $finishOrcamento = $this->orcamentoModel->finishVenda($orcamento->id_orcamento, $orcamento->serial);
                $finishAReceber = $this->contaReceberModel->finishVenda($orcamento->id_orcamento, $orcamento->serial);
                $finishMovimento = $this->movimentacaoModel->finishVenda($orcamento->id_orcamento, $orcamento->serial);

                $procedimentos = array(
                    'fin_movimentacao' => $finishMovimento,
                    'fin_receber' => $finishAReceber,
                    'pvd_venda' => $finishVenda,
                    'pdv_orcamento' => $finishOrcamento,
                    //    'est_detalhe'       => $finishEstoque,
                );

                if ($procedimentos) {

                    return $this->response->setJSON([
                        'status' => true,
                        'data' => $this->vendaModel->where('orcamento_id', $orcamento->id_orcamento)->first(),
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'VENDA FINALIZADA COM SUCESSO!',
                            'description' => "A VENDA Nº $venda->id_venda FOI FINALIZADA!"
                        ]
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => true,
                        'menssagem' => [
                            'status' => 'error',
                            'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                            'description' => "NÃO FOI POSSIVEL SALVAR AS ALTERAÇÕES!"
                        ]
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',

                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    private function buscaRegistro404(string $codigo = null)
    {
        if (!$codigo || !$resultado = $this->orcamentoModel->withDeleted(true)->where('serial', $codigo)->find()) {
            return null;
        }
        return $resultado;
    }

    private function geraVendaPDV(array $data = null): void
    {
        $this->vendaModel = new \App\Models\Venda\VendaModel();

        if ($data != null) {
            $this->vendaModel->save($data);
        }
    }
}
