<?php

namespace App\Controllers\Api\v1\Projeto;

use App\Controllers\Api\ApiController;
use App\Entities\Projeto\Local;

class Locais extends ApiController
{
    private $localModel;
    private $detalheProdutoModel;

    private $produtoModel;

    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->localModel = new \App\Models\Projeto\LocalModel();
        $this->detalheProdutoModel = new \App\Models\Estoque\DetalheModel();
        $this->produtoModel = new \App\Models\Cadastro\ProdutoModel;
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->localModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();
        try {

            if (empty($result)):
                return $this->response->setJSON($response);
            endif;

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalLocal" onclick="getEditLocal(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                // $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'local'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
                $ops .= ' <a class="btn btn-xs btn-success" href="local/view/' . $value->id . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';

                $response['data'][$key] = array(
                    esc($value->obr_descricao),
                    esc($value->obr_datainicio) ? esc(formatDataBR($value->obr_datainicio)) : '<label class="badge badge-danger">SEM DATA PREVISTA</label>',
                    $ops,
                );
            }

            return $this->response->setJSON($response);

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

    public function getCarregaTabelaLocalProduto()
    {
        $response['data'] = array();

        $cod_local = $this->request->getPost('cod_local');

        $result = $this->detalheProdutoModel
            ->getProdutoDetalhe()
            ->where('cad_produto.pro_tipo', 1)
            ->where('local_id', $cod_local)
            ->whereIn('situacao', ['1', '2', '4'])
            ->withDeleted()
            ->findAll();

        $resultSum = $this->detalheProdutoModel
            ->getSumProdutoDetalhe()
            ->where('cad_produto.pro_tipo', 1)
            ->where('local_id', $cod_local)
            ->whereIn('situacao', ['1', '2', '4'])
            ->withDeleted()
            ->groupBy('est_movimentacao.local_id')
            ->groupBy('cad_produto.pro_tipo')
            ->first();

        try {
            if (empty($result)) {
                return $this->response->setJSON($response);
            }

            $sequencia = 0;

            foreach ($result as $key => $value) {
                // Botões de operações
                $editButton = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalProdutoLocalServico" onclick="getEditProdutoLocalServico(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

                $checkbox = '<div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"
                                id="deleteCheckbox[1' . $sequencia . ']" name="cod_detalhe[]"
                                value="' . $value->id . '">
                            <label for="deleteCheckbox[1' . $sequencia . ']"
                                class="custom-control-label"></label>
                        </div>';

                $response['data'][$key] = array(
                    esc($value->produto_id),
                    esc($value->pro_descricao) . ' - ' . esc($value->tam_abreviacao),
                    esc($value->qtn_produto),
                    formatValorBR(esc($value->val1_unad)),
                    formatValorBR(esc($value->val1_total)),
                    $editButton,
                    $checkbox
                );
                $sequencia++;
            }

            $response['totalizador'] = $resultSum;



            return $this->response->setJSON($response);

        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSÍVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function getCarregaTabelaLocalServico()
    {
        $response['data'] = array();

        $cod_local = $this->request->getPost('cod_local');

        $result = $this->detalheProdutoModel
            ->getProdutoDetalhe()
            ->where('cad_produto.pro_tipo', 2)
            ->where('local_id', $cod_local)
            ->whereIn('situacao', ['1', '2', '4'])
            ->withDeleted()
            ->findAll();

        $resultSum = $this->detalheProdutoModel
            ->getSumProdutoDetalhe()
            ->where('cad_produto.pro_tipo', 2)
            ->where('local_id', $cod_local)
            ->whereIn('situacao', ['1', '2', '4'])
            ->withDeleted()
            ->groupBy('est_movimentacao.local_id')
            ->groupBy('cad_produto.pro_tipo')
            ->first();

        try {
            if (empty($result)) {
                return $this->response->setJSON($response);
            }

            $sequencia = 0;

            foreach ($result as $key => $value) {
                // Botões de operações
                $editButton = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalProdutoLocalServico" onclick="getEditProdutoLocalServico(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

                $checkbox = '<div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"
                                id="deleteCheckbox[2' . $sequencia . ']" name="cod_detalhe[]"
                                value="' . $value->id . '">
                            <label for="deleteCheckbox[2' . $sequencia . ']"
                                class="custom-control-label"></label>
                        </div>';

                $response['data'][$key] = array(
                    esc($value->produto_id),
                    esc($value->pro_descricao) . ' - ' . esc($value->tam_abreviacao),
                    esc($value->qtn_produto),
                    formatValorBR(esc($value->val1_unad)),
                    formatValorBR(esc($value->val1_total)),
                    $editButton,
                    $checkbox
                );

                $response['totalizador'] = $resultSum;

                $sequencia++;
            }

            return $this->response->setJSON($response);

        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSÍVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function getCarregaResumoLocal()
    {
        $response['data'] = array();

        $cod_local = $this->request->getPost('cod_local');

        $result = $this->detalheProdutoModel
            ->getSumProdutoDetalhe()
            ->where('local_id', $cod_local)
            ->whereIn('situacao', ['1', '2', '4'])
            ->withDeleted()
            ->first();
        if ($result) {
            $response['data'] = $result;
        }
        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }     

        $data['loc_descricao'] = returnNull($this->request->getPost('cad_local'), 'S');
        $data['loc_datainicio'] = returnNull(esc($this->request->getPost('cad_datainicio')));
        $data['loc_observacao'] = returnNull($this->request->getPost('cad_observacao'));
        $data['obra_id'] = $this->request->getPost('cod_obra');

        $entityLocal = new Local($data);
        // return $this->response->setJSON($data);
        if (!empty($this->request->getPost('cod_local'))) {
            $data['id'] = $this->request->getPost('cod_local');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA OBRA $result->cad_local PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            // $dataAuditoria = $result->auditoriaUpdateAtributos();

        } else {

            $metedoAuditoria = 'insert';
            // $dataAuditoria = $entityLocal->auditoriaInsertAtributos();

        }
        try {
            if ($this->localModel->save($data)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'local', $metedoAuditoria, $dataAuditoria);

                $cod_local = (!empty($this->request->getPost('cod_local'))) ? $this->request->getPost('cod_local') : $this->localModel->getInsertID();

                $return = $this->localModel->returnSave($cod_local);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A OBRA $return->cad_local FOI SALVAR!"
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
        $return = $this->localModel
            ->where('status', 1)
            ->orderBy('cat_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->localModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $local = $this->localModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($local === null) {
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
            if ($this->localModel->arquivarRegistro($paramentro)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'local', 'arquivar', $local->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A OBRA $local->cad_local FOI ARQUIVADA!"
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

    public function addProdutoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $quantidade = $this->request->getPost('quantidade');
            $produto = $this->produtoModel->where('id', $this->request->getPost('cod_produto'))->first();
            
            $orcamentoObra = $this->localModel->getOrcamentoObraLocal()
                ->where('ger_local.id', $this->request->getPost('cod_local'))
                ->first();

            if (!empty($this->request->getPost('cod_detalhe'))) {
                $valor = formatValorBD($this->request->getPost("valor_desc"));

                $data['id'] = $this->request->getPost('cod_detalhe');
                $data['val1_un'] = bcadd($valor, '0', 2);
                $data['val1_unad'] = bcadd($valor, '0', 2);
                $data['val1_total'] = bcadd(($valor * $quantidade), '0', 2);

            } else {
                $data['val1_un'] = bcadd($produto->cad_valor1, '0', 2);
                $data['val1_unad'] = bcadd($produto->cad_valor1, '0', 2);
                $data['val1_total'] = bcadd(($produto->cad_valor1 * $quantidade), '0', 2);
            }

            $data['orcamento_id'] = $orcamentoObra->cod_orcamento;
            $data['local_id'] = $this->request->getPost('cod_local');
            $data['produto_id'] = $produto->id;
            $data['del_tipo'] = 'S';
            $data['qtn_produto'] = $quantidade;
            $data['qtn_saldo'] = $quantidade;


            $data['val2_un'] = bcadd($produto->cad_valor2, '0', 2);
            $data['val2_unad'] = bcadd($produto->cad_valor2, '0', 2);
            $data['val2_total'] = bcadd(($produto->cad_valor2 * $quantidade), '0', 2);

            $data['situacao'] = '4';
            $data['serial'] = $orcamentoObra->serial;

            // return $this->response->setJSON($data);

            if ($this->detalheProdutoModel->save($data)) {

                $cod_detalhe = (!empty($this->request->getPost('cod_detalhe'))) ? $this->request->getPost('cod_detalhe') : $this->detalheProdutoModel->getInsertID();

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O PRODUTO FOI ADICIONADO COM SUCESSO!"
                    ],
                    'data' => [
                        'cod_obra' => $this->request->getPost('cod_obra'),
                        'cod_local' => $this->request->getPost('cod_local')
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

        // return $this->response->setJSON(
        //     [
        //         'data' => $data,
        //         'orcamento' => $orcamento,
        //         'produto' => $produto,
        //         'post' => $this->request->getPost()
        //     ]
        // );
    }

    public function addGradeProduto($cod_produto = null)
    {
        $return = $this->detalheProdutoModel->getProdutoDetalhe()
            ->where('est_movimentacao.id', $cod_produto)
            ->first();
        return $this->response->setJSON($return);
    }

    public function updateProdutoOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {

            $cod_detalhe = $this->request->getPost('cod_detalhe');
            $cod_local = $this->request->getPost('cod_local');
            $detalhe = $this->detalheProdutoModel->where('id', $cod_detalhe)->where('local_id', $cod_local)->first();

            $quantidade = $this->request->getPost('qnt_produto');
            $valor_desc = formatValorBD($this->request->getPost('valor_desc'));


            $data['qtn_produto'] = $quantidade;
            $data['qtn_saldo'] = $quantidade;
            $data['val1_unad'] = bcadd($valor_desc, '0', 2);
            $data['val1_total'] = bcadd(($valor_desc * $quantidade), '0', 2);

            if ($this->detalheProdutoModel->save($data)) {

                $cod_detalhe = (!empty($this->request->getPost('cod_detalhe'))) ? $this->request->getPost('cod_detalhe') : $this->detalheProdutoModel->getInsertID();

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O PRODUTO FOI ATUALIZADO COM SUCESSO!"
                    ],
                    'data' => [
                        'cod_obra' => $this->request->getPost('cod_obra'),
                        'cod_local' => $this->request->getPost('cod_local')
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

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->localModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
