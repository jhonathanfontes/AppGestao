<?php

namespace App\Controllers\Api\v1\Venda;

use App\Controllers\Api\ApiController;
use App\Entities\Venda\Orcamento;

class Vendas extends ApiController
{
    private $pessoaModel;
    private $orcamentoModel;
    private $vendaModel;
    private $detalheProdutoModel;
    private $produtoModel;
    private $vendedorModel;

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
        $this->detalheProdutoModel = new \App\Models\Estoque\DetalheModel();
        $this->produtoModel = new \App\Models\Cadastro\ProdutoModel;
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
            $cod_detalhe = $this->request->getPost('cod_grade');

            $result = $this->detalheProdutoModel->getProdutoDetalhe()
                ->where('est_movimentacao.id', $cod_detalhe)
                ->whereIn('situacao', ['1', '2', '4'])
                ->withDeleted()
                ->first();

            $orcamento = $this->orcamentoModel->where('id', $result->orcamento_id)->first();

            if ($orcamento != null) {

                $data['cod_detalhe'] = $result->id;
                $data['cod_orcamento'] = $result->orcamento_id;
                $data['cod_produto'] = $result->produto_id;
                $data['qtn_produto'] = $result->qtn_produto;
                $data['qtn_devolvido'] = $result->qtn_devolvido;
                $data['qtn_saldo'] = $result->qtn_saldo;
                $data['produto'] = $result->pro_descricao;
                $data['tamanho'] = $result->tam_abreviacao;

                if ($orcamento->orc_tipopagamento == 1) {
                    $data['cod_tipo'] = 1;
                    $data['val_un'] = $result->val1_un;
                    $data['val_unad'] = $result->val1_unad;
                    $data['total_unad'] = $result->val1_total;
                }
                if ($orcamento->orc_tipopagamento == 2) {
                    $data['cod_tipo'] = 2;
                    $data['val_un'] = $result->val2_un;
                    $data['val_unad'] = $result->val2_unad;
                    $data['total_unad'] = $result->val2_total;
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
                $data['situacao'] = 4;

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
            $produto = $this->produtoModel->where('id', $this->request->getPost('cod_produto'))->first();

            // return $this->response->setJSON($orcamento);

            if (!empty($this->request->getPost('cod_detalhe'))) {
                $valor = formatValorBD($this->request->getPost("valor_desc"));

                $data['id'] = $this->request->getPost('cod_detalhe');

                if ($orcamento->orc_tipopagamento == '1') {
                    $data['val1_un'] = bcadd($valor, '0', 2);
                    $data['val1_unad'] = bcadd($valor, '0', 2);
                    $data['val1_total'] = bcadd(($valor * $quantidade), '0', 2);
                }

                if ($orcamento->orc_tipopagamento == '2') {
                    $data['val2_un'] = bcadd($valor, '0', 2);
                    $data['val2_unad'] = bcadd($valor, '0', 2);
                    $data['val2_total'] = bcadd(($valor * $quantidade), '0', 2);
                }

            } else {
                $data['val1_un'] = bcadd($produto->cad_valor1, '0', 2);
                $data['val1_unad'] = bcadd($produto->cad_valor1, '0', 2);
                $data['val1_total'] = bcadd(($produto->cad_valor1 * $quantidade), '0', 2);

                $data['val2_un'] = bcadd($produto->cad_valor2, '0', 2);
                $data['val2_unad'] = bcadd($produto->cad_valor2, '0', 2);
                $data['val2_total'] = bcadd(($produto->cad_valor2 * $quantidade), '0', 2);
            }

            $data['orcamento_id'] = $orcamento->id;
            $data['produto_id'] = $produto->id;
            $data['del_tipo'] = 'S';
            $data['qtn_produto'] = $quantidade;
            $data['qtn_saldo'] = $quantidade;
            $data['situacao'] = '4';
            $data['serial'] = $orcamento->serial;

            if ($this->detalheProdutoModel->save($data)) {

                $cod_detalhe = (!empty($this->request->getPost('cod_detalhe'))) ? $this->request->getPost('cod_detalhe') : $this->detalheProdutoModel->getInsertID();

                $return = $this->detalheProdutoModel->returnSave($cod_detalhe);

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
                if ($this->detalheProdutoModel->deletarRegistros($cod_detalhe, $orcamento->id_orcamento, null)) {

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

    public function updateProdutoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            // return $this->response->setJSON($this->request->getPost());
            $cod_detalhe = $this->request->getPost('cod_detalhe');

            $cod_orcamento = $this->request->getPost('cod_orcamento');

            $orcamento = $this->orcamentoModel
                ->where('serial', $this->request->getPost('serial'))
                ->first();

        //   return $this->response->setJSON($orcamento);

            if ($cod_orcamento != $orcamento->id) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                        'description' => "NÃO FOI LOCALIZADO O ORÇAMENTO!"
                    ]
                ]);
            } else {
                $detalhe = $this->detalheProdutoModel
                    ->where('id', $this->request->getPost('cod_detalhe'))
                    ->where('orcamento_id', $cod_orcamento)
                    ->first();

                $cod_tipo = $this->request->getPost('cod_tipo');
                $qnt_produto = $this->request->getPost('qnt_produto');

                $valor_desc = formatValorBD($this->request->getPost('valor_desc'));

                if ($cod_tipo != $orcamento->orc_tipopagamento) {
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
   

                $dados['val1_unad'] = ($orcamento->orc_tipopagamento == 1) ? $valor_desc : $detalhe->val1_unad;
                $dados['val1_total'] = ($orcamento->orc_tipopagamento == 1) ? $valor_desc * $qnt_produto : $detalhe->val1_unad * $qnt_produto;

                $dados['val2_unad'] = ($orcamento->orc_tipopagamento == 2) ? $valor_desc : $detalhe->val2_unad;
                $dados['val2_total'] = ($orcamento->orc_tipopagamento == 2) ? $valor_desc * $qnt_produto : $detalhe->val2_unad * $qnt_produto;

                if (
                    $this->detalheProdutoModel->update(
                        [
                            'orcamento_id' => $orcamento->id,
                            'id' => $cod_detalhe
                        ],
                        $dados
                    )
                ) {
                    $return = $this->orcamentoModel->returnSave($orcamento->id);
                    return $this->response->setJSON([
                        'status' => true,
                        'data' => $return,
                        'menssagem' => [
                            'status' => 'success',
                            'heading' => 'ORÇAMENTO ATUALIZADO COM SUCESSO!',
                            'description' => "O ORÇAMENTO Nº $return->id FOI ALTERADO!"
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

                $detalhesOrcamento = $this->detalheProdutoModel->where('orcamento_id', $orcamento->id_orcamento)->where('situacao', 1)->findAll();
                $desc_percentual = (!empty($desc_percentual)) ? $desc_percentual : 0;

                $i = 0;
                if ($orcamento->orc_tipo == 1) {

                    if (!empty($desc_val_final)) {
                        $percentual_valor = returnNull((round(100 - (($desc_val_final / $orcamento->valor_bruto) * 100), 2) / 100));
                    }

                    $percentual_avista = (empty($percentual_valor)) ? $desc_percentual : $percentual_valor;

                    foreach ($detalhesOrcamento as $row) {
                        $val_ad = round($row->mvd_val_un * $percentual_avista, 2);

                        $data[$i]['id'] = $row->id;
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

                        $data[$i]['id'] = $row->id;
                        $data[$i]['mpd_val_ad'] = $val_ad;
                        $data[$i]['mpd_val_unad'] = round($row->mpd_val_un - $val_ad, 2);
                        $data[$i]['mpd_total_unad'] = round(($row->mpd_val_un - $val_ad) * $row->qtn_produto, 2);
                        $i++;
                    }
                }

                if ($this->detalheProdutoModel->updateBatch($data, 'id')) {

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

                $finishEstoque = $this->detalheProdutoModel->finishOrcamento($orcamento->id_orcamento);
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

            // $this->contaReceberModel = new \App\Models\Financeiro\ContaReceberModel();
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
                $finishEstoque = $this->detalheProdutoModel->vendaToOrcamento($orcamento->id_orcamento);
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

            // $this->contaReceberModel = new \App\Models\Financeiro\ContaReceberModel();
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
                // $finishEstoque      = $this->detalheProdutoModel->vendaToOrcamento($orcamento->id_orcamento);
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
