<?php

namespace App\Controllers\Api\v1\Cadastro;

use App\Controllers\BaseController;
use App\Models\Cadastro\PessoaModel;

use App\Entities\Cadastro\Pessoa;

class Pessoas extends BaseController
{
    protected $pessoaModel;
    protected $validation;

    public function __construct()
    {
        $this->pessoaModel = new PessoaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $data['data'] = array();

        $result = $this->pessoaModel->whereIn('status', ['1', '2'])->withDeleted()->findAll();

        foreach ($result as $key => $value) {

            $documento = null;
            // $ops = '<div class="btn-group">';
            $ops = '	<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalPessoa" onclick="getEditPessoa(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '	<a class="btn btn-xs btn-success" href="pessoas/view/' . $value->id . '"><span class="fas fa-tasks"></span> GERENCIAR </a>';
            // $ops .= '</div>';

            if ($value->tipo_cliente == '1') :
                $tipo_cliente =  '<label class="badge badge-success">' . convertPessoa($value->tipo_cliente) . '</label>';
            elseif ($value->tipo_cliente == '2') :
                $tipo_cliente =  '<label class="badge badge-primary"> ' . convertPessoa($value->tipo_cliente) . '</label>';
            elseif ($value->tipo_cliente == '3') :
                $tipo_cliente =  '<label class="badge badge-warning">' . str_replace('/', '<br>', convertPessoa($value->tipo_cliente)) . '</label>';
            endif;

            if ($value->pes_tiponatureza == 'F') :
                $documento = formatCnpjCpf($value->pes_cpf);
            elseif ($value->pes_tiponatureza == 'J') :
                $documento = formatCnpjCpf($value->pes_cnpj);
            endif;

            if ($value->pes_telefone <> null && $value->pes_celular <> null) :
                $pes_telefone = esc($value->pes_telefone) . ' <br> ' . $value->pes_celular;
            elseif ($value->pes_telefone <> null && $value->pes_celular == null) :
                $pes_telefone = esc($value->pes_telefone);
            elseif ($value->pes_telefone == null && $value->pes_celular <> null) :
                $pes_telefone = esc($value->pes_celular);
            else :
                $pes_telefone = '';
            endif;

            $data['data'][$key] = array(
                esc(abreviaNome($value->pes_nome)),
                esc(abreviaNome($value->pes_apelido)),
                $tipo_cliente,
                esc($documento),
                esc($value->pes_email),
                $pes_telefone,
                convertStatus($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }

    public function findAll()
    {
        $pessoaModel = new pessoaModel();
        $return = $pessoaModel->findAll();
        return $this->response->setJSON($return);
    }

    public function clientes()
    {
        $pessoaModel = new pessoaModel();
        $return = $pessoaModel->getClientes();
        return $this->response->setJSON($return);
    }

    public function fornecedores()
    {
        $pessoaModel = new pessoaModel();
        $return = $pessoaModel->getFornecedores();
        return $this->response->setJSON($return);
    }


    public function getPessoaFind($cod_pessoa = null)
    {
        $response = array();

        if (isset($cod_pessoa)) {
            if ($this->validation->check($cod_pessoa, 'required|numeric')) {
                $result = $this->pessoaModel->where('id', $cod_pessoa)->first();
                if (!empty($result)) {

                    $response = array(
                        'cod_pessoa'        => $result->id,
                        'cad_tipopessoa'    => $result->tipo_cliente,
                        'cad_natureza'      => $result->pes_tiponatureza,
                        'cad_cpf'           => esc($result->pes_cpf),
                        'cad_cnpj'          => esc($result->pes_cnpj),
                        'cad_nascimeto'     => esc($result->pes_datanascimento),
                        'cad_rg'            => esc($result->pes_rg),
                        'cad_apelido'       => esc($result->pes_apelido),
                        'cad_nome'          => esc($result->pes_nome),
                        'cad_cep'           => esc($result->pes_cep),
                        'cad_endereco'      => esc($result->pes_endereco),
                        'cad_numero'        => esc($result->pes_numero),
                        'cad_setor'         => esc($result->pes_setor),
                        'cad_cidade'        => esc($result->pes_cidade),
                        'cad_estado'        => esc($result->pes_estado),
                        'cad_complemento'   => esc($result->pes_complemento),
                        'cad_telefone'      => esc($result->pes_telefone),
                        'cad_celular'       => esc($result->pes_celular),
                        'cad_email'         => esc($result->pes_email),
                        'cod_profissao'     => esc($result->profissao_id),
                        'status'            => $result->status,
                    );
                    return $this->response->setJSON($response);
                } else {
                    return true;
                }
            } else {
                throw new \CodeIgniter\Exceptions\PageNotFoundException();
            }
        }
    }

    public function checkDocumento()
    {
        $response = array();
        $cad_documento = $this->request->getPost('cad_documento');
        if (isset($cad_documento)) {
            if ($this->validation->check($cad_documento, 'required|numeric')) {
                $where = "pes_cpf = $cad_documento OR pes_cnpj = $cad_documento";
                $data = $this->pessoaModel->where($where)->first();
                if (!empty($data)) {
                    $response = array(
                        'cod_pessoa'    => $data->id,
                        'cad_nome'      => esc($data->pes_nome)
                    );
                    return $this->response->setJSON($response);
                } else {
                    return false;
                }
            } else {
                throw new \CodeIgniter\Exceptions\PageNotFoundException();
            }
        }
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['pes_apelido']        = returnNull(esc($this->request->getPost('cad_apelido')), 'S');
        $data['pes_celular']        = returnNull(esc($this->request->getPost('cad_celular')));
        $data['pes_cep']            = returnNull(esc($this->request->getPost('cad_cep')));
        $data['pes_cidade']         = returnNull(esc($this->request->getPost('cad_cidade')), 'S');
        $data['pes_complemento']    = returnNull(esc($this->request->getPost('cad_complemento')), 'S');
        $data['pes_email']          = returnNull(esc($this->request->getPost('cad_email')), 'N');
        $data['pes_endereco']       = returnNull(esc($this->request->getPost('cad_endereco')), 'S');
        $data['pes_estado']         = returnNull(esc($this->request->getPost('cad_estado')), 'S');
        $data['pes_tiponatureza']   = $this->request->getPost('cad_natureza');
        $data['pes_nome']           = returnNull(esc($this->request->getPost('cad_nome')), 'S');
        $data['pes_setor']          = returnNull(esc($this->request->getPost('cad_setor')), 'S');
        $data['pes_numero']         = returnNull(esc($this->request->getPost('cad_numero')));
        $data['pes_telefone']       = returnNull(esc($this->request->getPost('cad_telefone')));
        $data['tipo_cliente']       = $this->request->getPost('cad_tipopessoa');
        $data['profissao_id']       = $this->request->getPost('cod_profissao');
        $data['status']             = $this->request->getPost('status');

        if ($this->request->getPost('cad_natureza') === 'F') {
            $data['pes_cpf']            = limparCnpjCpf(esc($this->request->getPost('cad_documento')));
            $data['pes_datanascimento'] = returnNull(esc($this->request->getPost('cad_nascimeto')));
            $data['pes_rg']             = returnNull(esc($this->request->getPost('cad_rg')), 'S');
        }
        if ($this->request->getPost('cad_natureza') === 'J') {
            $data['pes_cnpj']           = limparCnpjCpf(esc($this->request->getPost('cad_documento')));
        }

        if (!empty($this->request->getPost('cod_pessoa'))) {
            $data['id'] = $this->request->getPost('cod_pessoa');
            $result = $this->buscaRegistro404($data['id']);

            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NO CADASTRO $result->cad_nome PARA SALVAR!"
                    ]
                ]);
            }
        }

        try {
            if ($this->pessoaModel->save($data)) {
                $cod_pessoa = (!empty($this->request->getPost('cod_pessoa'))) ? $this->request->getPost('cod_pessoa') : $this->pessoaModel->getInsertID();
                $return = $this->buscaRegistro404($cod_pessoa);
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "O CADASTRO $return->cad_nome FOI SALVO!"
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

    public function show($cod_pessoa = null)
    {
        $response = array();

        if (isset($cod_pessoa)) {
            if ($this->validation->check($cod_pessoa, 'required|numeric')) {
                $result = $this->buscaRegistro404($cod_pessoa);
                if (!empty($result)) {

                    $response = array(
                        'cod_pessoa'        => $result->id,
                        'cad_tipopessoa'    => $result->tipo_cliente,
                        'cad_natureza'      => $result->pes_tiponatureza,
                        'cad_cnpj'          => esc($result->pes_cnpj),
                        'cad_cpf'           => esc($result->pes_cpf),
                        'cad_nascimeto'     => esc($result->pes_datanascimento),
                        'cad_rg'            => esc($result->pes_rg),
                        'cad_nome'          => esc($result->pes_nome),
                        'cad_apelido'       => esc($result->pes_apelido),
                        'cad_cep'           => esc($result->pes_cep),
                        'cad_endereco'      => esc($result->pes_endereco),
                        'cad_numero'        => esc($result->pes_numero),
                        'cad_setor'         => esc($result->pes_setor),
                        'cad_cidade'        => esc($result->pes_cidade),
                        'cad_estado'        => esc($result->pes_estado),
                        'cad_complemento'   => esc($result->pes_complemento),
                        'cad_telefone'      => esc($result->pes_telefone),
                        'cad_celular'       => esc($result->pes_celular),
                        'cad_email'         => esc($result->pes_email),
                        'cod_profissao'     => esc($result->profissao_id),
                        'status'            => $result->status,
                    );
                    return $this->response->setJSON($response);
                } else {
                    return true;
                }
            } else {
                throw new \CodeIgniter\Exceptions\PageNotFoundException();
            }
        }
    }

    public function arquivar($paramentro = null)
    {
        $result = $this->pessoaModel->where('id', $paramentro)
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
            if ($this->pessoaModel->arquivarRegistro($paramentro)) {
                $tipo = convertPessoa($result->tipo_cliente);
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "O $tipo $result->cad_nome FOI ARQUIVADA!"
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
        if (!$codigo || !$resultado = $this->pessoaModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
