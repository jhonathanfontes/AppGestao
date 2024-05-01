<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\BaseController;
use App\Models\Cadastro\ProdutoModel;

class Produtos extends BaseController
{
    protected $produtoModel;
    protected $validation;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->validation = \Config\Services::validation();
    }
    public function getCarregaTabela()
    {

        $response['data'] = array();
        $result = $this->produtoModel->getProdutos();

        if (empty($result)):
            return $this->response->setJSON($response);
        endif;

        try {
            foreach ($result as $key => $value) {

                $ops = '	<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalProduto" onclick="getEditProduto(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                $ops .= '	<a class="btn btn-xs btn-success" href="produtos/view/' . $value->id . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';

                if ($value->status == '1'):
                    $status = '<label class="badge badge-success">Habilitado</label>';
                elseif ($value->status == '2'):
                    $status = '<label class="badge badge-danger">Desabilitado</label>';
                endif;

                $response['data'][$key] = array(
                    esc($value->id),
                    esc($value->pro_descricao_pvd),
                    esc($value->pro_descricao),
                    esc($value->sub_descricao),
                    esc($value->fab_descricao),
                    esc($value->estoque),
                    convertStatus($value->status),
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
    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['pro_descricao'] = returnNull($this->request->getPost('cad_descricao'), 'S');
        $data['pro_descricao_pvd'] = ($this->request->getPost('cad_descricaopdv') != null) ? returnNull($this->request->getPost('cad_descricaopdv'), 'S') : returnNull($this->request->getPost('cad_descricao'), 'S');
        $data['subcategoria_id'] = $this->request->getPost('pro_subcategoria');
        $data['pro_cod_fabricante'] = $this->request->getPost('cad_codfabricante');
        $data['pro_codigobarras'] = ($this->request->getPost('cad_codbarras') != null) ? returnNull($this->request->getPost('cad_codbarras'), 'S') : getCodigoBarra($this->request->getPost('pro_subcategoria'), $this->request->getPost('pro_frabricante'));
        $data['fabricante_id'] = $this->request->getPost('pro_frabricante');
        $data['status'] = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_produto'))) {
            $data['id'] = $this->request->getPost('cod_produto');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA produto $result->cad_produto PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->produtoModel->save($data)) {

                $cod_produto = (!empty($this->request->getPost('cod_produto'))) ? $this->request->getPost('cod_produto') : $this->produtoModel->getInsertID();

                $return = $this->produtoModel->returnSave($cod_produto);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A produto $return->cad_produto FOI SALVAR!"
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
        return true;
    }

    public function show($paramentro)
    {
        $return = $this->produtoModel->getProduto($paramentro);

        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $result = $this->produtoModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($result === null) {
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
            if ($this->produtoModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O PRODUTO $result->cad_produto FOI ARQUIVADO!"
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

    public function selectBuscaProdutos($busca = null)
    {
        $cod_produto = str_replace('_', '%', $busca);

        $produto = $this->produtoModel->selectProdutos()
            ->where('cad_produto.status', 1)
            ->groupStart()
            ->where('pro_descricao LIKE', '%' . $cod_produto . '%')
            ->orWhere('pro_descricao_pvd LIKE', '%' . $cod_produto . '%')
            ->orWhere('pro_codigobarras LIKE', '%' . $cod_produto . '%')
            ->orWhere('fab_descricao LIKE', '%' . $cod_produto . '%')
            ->groupEnd()
            ->orderBy('pro_descricao', 'ASC')
            ->findAll();

        echo json_encode($produto);
    }

    public function selectBuscaProdutosGrade($busca = null)
    {
        $cod_produto = str_replace('_', '%', $busca);

        $produto = $this->produtoModel->selectProdutos()
            ->where('cad_produto.status', 1)
            ->groupStart()
            ->where('pro_descricao LIKE', '%' . $cod_produto . '%')
            ->orWhere('pro_descricao_pvd LIKE', '%' . $cod_produto . '%')
            ->orWhere('pro_codigobarras LIKE', '%' . $cod_produto . '%')
            ->orWhere('fab_descricao LIKE', '%' . $cod_produto . '%')
            ->groupEnd()
            ->orderBy('pro_descricao', 'ASC')
            ->findAll();

        echo json_encode($produto);
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->produtoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
