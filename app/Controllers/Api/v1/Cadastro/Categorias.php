<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\Api\ApiController;

use App\Entities\Cadastro\Categoria;

class Categorias extends ApiController
{

    private $categoriaModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->categoriaModel = new \App\Models\Cadastro\CategoriaModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->categoriaModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();
        try {

            if (empty($result)):
                return $this->response->setJSON($response);
            endif;
            
            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalCategoria" onclick="getEditCategoria(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'categoria'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

                $response['data'][$key] = array(
                    esc($value->cat_descricao),
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
        $data['cat_tipo'] = $this->request->getPost('cad_tipo');
        $data['cat_descricao'] = returnNull($this->request->getPost('cad_categoria'), 'S');
        $data['status'] = $this->request->getPost('status');

        $entityCategoria = new Categoria($data);

        if (!empty($this->request->getPost('cod_categoria'))) {
            $data['id'] = $this->request->getPost('cod_categoria');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA CATEGORIA $result->cad_categoria PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            // $dataAuditoria = $result->auditoriaUpdateAtributos();

        } else {

            $metedoAuditoria = 'insert';
            // $dataAuditoria = $entityCategoria->auditoriaInsertAtributos();

        }
        ;

        try {
            if ($this->categoriaModel->save($data)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'categoria', $metedoAuditoria, $dataAuditoria);

                $cod_categoria = (!empty($this->request->getPost('cod_categoria'))) ? $this->request->getPost('cod_categoria') : $this->categoriaModel->getInsertID();

                $return = $this->categoriaModel->returnSave($cod_categoria);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A CATEGORIA $return->cad_categoria FOI SALVAR!"
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
        $return = $this->categoriaModel
            ->where('status', 1)
            ->orderBy('cat_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->categoriaModel->where('id', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $categoria = $this->categoriaModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($categoria === null) {
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
            if ($this->categoriaModel->arquivarRegistro($paramentro)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'categoria', 'arquivar', $categoria->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A CATEGORIA $categoria->cad_categoria FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->categoriaModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
