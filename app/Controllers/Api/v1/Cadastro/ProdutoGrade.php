<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;

use App\Entities\Cadastro\ProdutoGrade as Grade;

class ProdutoGrade extends BaseController
{
    protected $produtoGradeModel;
    protected $tamanhoModel;
    protected $validation;

    public function __construct()
    {
        $this->produtoGradeModel = new \App\Models\Cadastro\ProdutoGradeModel();
        $this->tamanhoModel = new \App\Models\Cadastro\TamanhoModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela(int $cod_produto)
    {
        $response = array();

        $result = $this->produtoGradeModel->getTamanhosProdutoGrade($cod_produto);

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalProdutoGrade" onclick="getEditProdutoGrade(' . $value->cod_produtograde . ')"><samp class="far fa-edit"></samp> EDITAR</button>';

            $response['data'][$key] = array(
                esc($value->des_tamanho),
                formatValorBR($value->valor_custo),
                formatValorBR($value->valor_avista),
                formatValorBR($value->valor_aprazo),
                esc($value->estoque),
                convertStatus($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($response);
    }

    public function addGradeProduto(int $cod_produto)
    {
        $response = $this->tamanhoModel->select('id_tamanho, tam_descricao')
            ->where('status', 1)
            ->whereNotIn('id_tamanho', static fn (BaseBuilder $builder) => $builder->select('tamanho_id')->from('pdv_produtograde')->where('produto_id', $cod_produto))
            ->orderBy('tam_descricao', 'DESC')
            ->findAll();

        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['tamanho_id']         = $this->request->getPost('cod_gradetamanho');
        $data['produto_id']         = $this->request->getPost('cod_produto');
        $data['valor_custo']        = formatValorBD($this->request->getPost('cad_custo'));
        $data['valor_vendaavista']  = formatValorBD($this->request->getPost('cad_avista'));
        $data['valor_vendaprazo']   = formatValorBD($this->request->getPost('cad_aprazo'));
        $data['codigobarra']        = $this->request->getPost('cad_codbarras');

        $entityGrade = new Grade($data);

        if (!empty($this->request->getPost('grade'))) {
            $data['codigo'] = $this->request->getPost('grade');

            $result = $this->buscaRegistro404($data['codigo']);
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
            if ($this->produtoGradeModel->save($data)) {

                return $this->response->setJSON([
                    'status' => true,
                    'data' => $data,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!'
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

    public function getGradesProduto()
    {
        $cod_produto    = $this->request->getPost('cod_produto');
        $result = $this->produtoGradeModel->getProdutoGrade()
            ->where('pdv_produtograde.produto_id', $cod_produto)
            ->where('pdv_produtograde.status', 1)
            ->findAll();

        $option = "<option value=''>SELECIONE A GRADE</option>";

        //dd($result);

        if ($result) {
            foreach ($result as $row) {
                $option = $option . "<option value='$row->cod_produtograde'>$row->des_tamanho / ESTOQUE: $row->estoque </option>" . PHP_EOL;
            }
        } else {
            $option = "<option value=''>PRODUTO SEM ESTOQUE</option>";
        }

        echo $option;
    }

    public function getGradeProduto()
    {
        $cod_grade    = $this->request->getPost('cod_grade');
        $result = $this->produtoGradeModel->getProdutoGrade()
            ->where('pdv_produtograde.codigo', $cod_grade)
            ->where('pdv_produtograde.status', 1)
            ->findAll();

        echo json_encode($result);
    }

    public function selectBuscaProdutosGrade($busca = null)
    {
        $cod_produto = str_replace('_', '%', $busca);

        $produto = $this->produtoGradeModel->getProdutoGrade()
            ->where('pdv_produtograde.status', 1)
            ->where('cad_produto.status', 1)
                ->groupStart()
                    ->where('cad_produto.pro_descricao LIKE', '%' . $cod_produto . '%')
                    ->orWhere('cad_produto.pro_descricao_pvd LIKE', '%' . $cod_produto . '%')
                    ->orWhere(' cad_produto.pro_codigobarras LIKE', '%' . $cod_produto . '%')
                ->groupEnd()
            ->orderBy('cad_produto.pro_descricao', 'ASC')
            ->findAll();

        echo json_encode($produto);
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->produtoGradeModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
