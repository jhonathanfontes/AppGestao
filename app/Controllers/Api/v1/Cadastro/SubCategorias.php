<?php

namespace App\Controllers\Api\Cadastro;

use App\Controllers\BaseController;
use App\Models\Cadastro\SubCategoriaModel;

class SubCategorias extends BaseController
{
    protected $subcategoriaModel;
    protected $validation;

    public function __construct()
    {
        $this->subcategoriaModel = new SubCategoriaModel();
        $this->validation =  \Config\Services::validation();
    }
    public function getCarregaTabela()
    {
        $response = array();
        $data['data'] = array();
        $result = $this->subcategoriaModel->getSubCategorias();
        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalSubCategoria" onclick="getEditSubCategoria(' . $value->id_subcategoria . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'subcategoria'" . ',' . $value->id_subcategoria . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $response['data'][$key] = array(
                esc($value->sub_descricao),
                esc($value->cat_descricao),
                convertStatus($value->status),
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

        $data['sub_descricao'] = returnNull($this->request->getPost('cad_subcategoria'), 'S');
        $data['categoria_id']  = $this->request->getPost('cod_categoria');
        $data['status']        = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_subcategoria'))) {
            $data['id_subcategoria'] = $this->request->getPost('cod_subcategoria');

            $result = $this->buscaRegistro404($data['id_subcategoria']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA SUBCATEGORIA $result->cod_subcategoria PARA SALVAR!"
                    ]
                ]);
            }
        }



        try {
            if ($this->subcategoriaModel->save($data)) {

                $cod_subcategoria = (!empty($this->request->getPost('cod_subcategoria'))) ? $this->request->getPost('cod_subcategoria') : $this->subcategoriaModel->getInsertID();
                $return = $this->subcategoriaModel->returnSave($cod_subcategoria);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A SUBCATEGORIA $return->cad_subcategoria FOI SALVO!"
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
        $subcategoriaModel = new SubCategoriaModel();
        $return = $subcategoriaModel->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->subcategoriaModel->where('id_subcategoria', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function getCagetoriaFiltro(int $paramentro = null)
    {
        if ($paramentro != null) {
            $return = $this->subcategoriaModel->where('categoria_id', $paramentro)
                ->where('status', 1)
                ->orderBy('sub_descricao', 'asc')
                ->findAll();
            if ($return != null) {
                return $this->response->setJSON($return);
            }
        }
        return $this->response->setJSON([]);
    }

    public function arquivar($paramentro = null)
    {
        $result = $this->subcategoriaModel->where('id_subcategoria', $paramentro)
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
            if ($this->subcategoriaModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A SUBCATEGORIA $result->cad_subcategoria FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->subcategoriaModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
