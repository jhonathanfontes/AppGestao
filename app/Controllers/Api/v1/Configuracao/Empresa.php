<?php

namespace App\Controllers\Api\v1\Configuracao;

use App\Controllers\Api\ApiController;

class Empresa extends ApiController
{

    private $empresaModel;
    private $enderecoModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {

        $this->empresaModel = new \App\Models\Configuracao\EmpresaModel();
        $this->enderecoModel = new \App\Models\EnderecoModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->empresaModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalEmpresa" onclick="getEditEmpresa(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<a class="btn btn-xs btn-success ml-2" href="empresas/view/' . $value->id . '"><span class="fas fa-tasks"></span> PARAMETRO </a>';

            $response['data'][$key] = array(
                esc($value->emp_razao),
                esc($value->emp_fantasia),
                esc($value->emp_slogan),
                esc($value->emp_cnpj),
                esc($value->emp_icone),
                $ops
            );
        }

        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        if (!empty($this->request->getPost('cod_endereco'))) {
            $endereco['id'] = $this->request->getPost('cod_endereco');
        }

        if (!empty($this->request->getPost('cad_endereco'))) {
            $endereco['end_endereco'] = returnNull($this->request->getPost('cad_endereco'), 'S');
            $endereco['end_numero'] = returnNull($this->request->getPost('cad_numero'), 'S');
            $endereco['end_setor'] = returnNull($this->request->getPost('cad_setor'), 'S');
            $endereco['end_cidade'] = returnNull($this->request->getPost('cad_cidade'), 'S');
            $endereco['end_estado'] = returnNull($this->request->getPost('cad_estado'), 'S');
            $endereco['end_complemento'] = returnNull($this->request->getPost('cad_complemento'), 'S');
            $endereco['end_cep'] = returnNull($this->request->getPost('cad_cep'), 'S');

            if ($this->enderecoModel->save($endereco)) {
                $data['endereco_id'] = (!empty($this->request->getPost('cod_endereco'))) ? $this->request->getPost('cod_endereco') : $this->enderecoModel->getInsertID();
            }
        }

        $data['emp_razao'] = returnNull($this->request->getPost('cad_nome'), 'S');
        $data['emp_fantasia'] = returnNull($this->request->getPost('cad_apelido'), 'S');
        $data['emp_slogan'] = returnNull($this->request->getPost('cad_slogan'), 'S');
        $data['emp_cnpj'] = limparCnpjCpf(returnNull($this->request->getPost('cad_documento'), 'S'));
        $data['emp_email'] = returnNull($this->request->getPost('cad_email'));
        $data['emp_telefone'] = returnNull($this->request->getPost('cad_telefone'), 'S');
        $data['status'] = returnNull($this->request->getPost('status'));


        if (!empty($this->request->getPost('cod_empresa'))) {

            $data['id'] = $this->request->getPost('cod_empresa');
            $result = $this->buscaRegistro404($this->request->getPost('cod_empresa'));

            $result->fill($data);

            if ($result->hasChanged() == false && empty($this->request->getPost('cod_endereco'))) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA EMPRESA $result->cad_razao PARA SALVAR!"
                    ]
                ]);
            }

            // $this->auditoriaModel->insertAuditoria('configuracao', 'empresa', 'atualizar', $result->auditoriaUpdateAtributos());
        }
        ;

        try {

            if ($this->empresaModel->save($data)) {
                $cod_empresa = (!empty($this->request->getPost('cod_empresa'))) ? $this->request->getPost('cod_empresa') : $this->empresaModel->getInsertID();
                $return = $this->empresaModel->returnSave($cod_empresa);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A EMPRESA $return->emp_razao FOI SALVA!"
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
        $return = $this->empresaModel->getEmpresa()
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($cod_empresa = null)
    {
        $return = $this->empresaModel->getEmpresa()
            ->where('con_empresa.id', $cod_empresa)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $empresa = $this->empresaModel->where('id', $paramentro)->first();

        if ($empresa === null) {
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
            if ($this->empresaModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'empresa', 'arquivar', $empresa->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A EMPRESA $empresa->cad_banco FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->empresaModel->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
