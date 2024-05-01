<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\BaseController;
use App\Models\Cadastro\ProfissaoModel;

class Profissoes extends BaseController
{
  protected $profisaoModel;
  protected $validation;

  public function __construct()
  {
    $this->profisaoModel = new ProfissaoModel();
    $this->validation = \Config\Services::validation();
  }

  public function getCarregaTabela()
  {
    $response['data'] = array();
    $result = $this->profisaoModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();

    try {

      if (empty($result)) {
        return $this->response->setJSON($response);
      }

      foreach ($result as $key => $value) {

        $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalProfissao" onclick="getEditProfissao(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
        $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'profissao'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

        $response['data'][$key] = array(
          esc($value->pro_descricao),
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

    $data['pro_descricao'] = returnNull($this->request->getPost('cad_profissao'), 'S');
    $data['status'] = $this->request->getPost('status');

    if (!empty($this->request->getPost('cod_profissao'))) {
      $data['id'] = $this->request->getPost('cod_profissao');

      $result = $this->buscaRegistro404($data['id']);
      $result->fill($data);

      if ($result->hasChanged() == false) {
        return $this->response->setJSON([
          'status' => true,
          'menssagem' => [
            'status' => 'error',
            'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
            'description' => "NÃO TEVE ALTERAÇÃO NA PROFISSÃO $result->cad_profissao PARA SALVAR!"
          ]
        ]);
      }
    }

    try {
      if ($this->profisaoModel->save($data)) {
        $cod_profissao = (!empty($this->request->getPost('cod_profissao'))) ? $this->request->getPost('cod_profissao') : $this->profisaoModel->getInsertID();
        $return = $this->profisaoModel->returnSave($cod_profissao);

        return $this->response->setJSON([
          'status' => true,
          'menssagem' => [
            'status' => 'success',
            'heading' => 'REGISTRO SALVO COM SUCESSO!',
            'description' => "A PROFISSÃO $return->cad_profissao FOI SALVAR!"
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
    $return = $this->profisaoModel
      ->where('status', 1)
      ->findAll();
    return $this->response->setJSON($return);
  }

  public function show($paramentro)
  {
    $return = $this->profisaoModel->where('id', $paramentro)->first();
    return $this->response->setJSON($return);
  }

  public function arquivar($paramentro = null)
  {
    $categoria = $this->profisaoModel->where('id', $paramentro)
      ->where('status <>', 0)
      ->where('status <>', 9)
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
      if ($this->profisaoModel->arquivarRegistro($paramentro)) {
        return $this->response->setJSON([
          'status' => true,
          'menssagem' => [
            'status' => 'success',
            'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
            'description' => "A CATEGORIA $categoria->cad_profissao FOI ARQUIVADA!"
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
    if (!$codigo || !$resultado = $this->profisaoModel->withDeleted(true)->find($codigo)) {
      return null;
    }
    return $resultado;
  }
}
