<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\BaseController;
use App\Models\Cadastro\TamanhoModel;

class Tamanhos extends BaseController
{
    protected $tamanhoModel;
    protected $validation;

    public function __construct()
    {
        $this->tamanhoModel = new TamanhoModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->tamanhoModel
            ->whereIn('status', ['1', '2'])
            ->withDeleted()
            ->findAll();

        if (empty($result)):
            return $this->response->setJSON($response);
        endif;

        try {

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalTamanho" onclick="getEditTamanho(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
                $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'tamanho'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

                $response['data'][$key] = array(
                    esc($value->tam_descricao),
                    esc($value->tam_abreviacao),
                    esc($value->tam_quantidade),
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

        $data['tam_descricao'] = returnNull($this->request->getPost('cad_tamanho'), 'S');
        $data['tam_abreviacao'] = returnNull($this->request->getPost('cad_abreviacao'), 'S');
        $data['tam_quantidade'] = returnNull($this->request->getPost('cad_embalagem'), 'S');
        $data['status'] = $this->request->getPost('status');

        if (!empty($this->request->getPost('cod_tamanho'))) {
            $data['id'] = $this->request->getPost('cod_tamanho');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO TAMANHO $result->cad_tamanho PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->tamanhoModel->save($data)) {
                $cod_tamanho = (!empty($this->request->getPost('cod_tamanho'))) ? $this->request->getPost('cod_tamanho') : $this->tamanhoModel->getInsertID();
                $return = $this->tamanhoModel->returnSave($cod_tamanho);
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O TAMANHO $return->cad_tamanho FOI SALVO!"
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
        $return = $this->tamanhoModel
            ->whereIn('status', ['1'])
            ->findAll();

        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->tamanhoModel
            ->where('id', $paramentro)
            ->whereIn('status', ['1', '2'])
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $categoria = $this->tamanhoModel->where('id', $paramentro)
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
            if ($this->tamanhoModel->arquivarRegistro($paramentro)) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O TAMANHO $categoria->cad_tamanho FOI ARQUIVADO!"
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
        if (!$codigo || !$resultado = $this->tamanhoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
