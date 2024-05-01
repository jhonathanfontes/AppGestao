<?php

namespace App\Controllers\Api\Configuracao;

use App\Controllers\Api\ApiController;
use App\Entities\Configuracao\Usuario as EntitiesUsuario;
use App\Models\Configuracao\UsuarioModel;

class Usuario extends ApiController
{
    protected $usuarioModel;
    private $auditoriaModel;
    protected $validation;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $result = $this->usuarioModel->findAll();

        foreach ($result as $key => $value) {

            $imagem = [
                'src'   => site_url("../../../dist/img/avatar/$value->use_avatar"),
                'class' => 'img-circle list-inline table-avatar',
                'alt'   =>  esc($value->use_nome),
                'width' => '30'
            ];

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalUsuario" onclick="getEditUsuario(' . $value->id . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            // $ops .= '<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalAvatarUsuario" onclick="getEditAvatarUsuario(' . $value->id . ')"><samp class="far fa-edit"></samp> AVATAR</button>';

            $response['data'][$key] = array(
                esc($value->use_nome),
                esc($value->use_apelido),
                esc($value->use_username),
                esc($value->use_email),
                esc($value->use_telefone),
                img($imagem),
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

        $data['use_nome']       = returnNull($this->request->getPost('cad_nome'), 'S');
        $data['use_apelido']    = returnNull($this->request->getPost('cad_apelido'), 'S');
        $data['use_telefone']   = $this->request->getPost('cad_telefone');
        $data['use_email']      = $this->request->getPost('cad_email');
        $data['use_sexo']       = $this->request->getPost('cad_sexo');
        $data['use_username']   = $this->request->getPost('cad_username');
        $data['permissao_id']   = $this->request->getPost('cad_permissao');
        $data['status']         = $this->request->getPost('status');

        $entityUsuario = new EntitiesUsuario($data);

        if (!empty($this->request->getPost('cod_usuario'))) {

            $data['id'] = $this->request->getPost('cod_usuario');
            $result = $this->buscaRegistro404($this->request->getPost('cod_usuario'));

            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON($this->responseUnableSaveRequest("NÃO TEVE ALTERAÇÃO NO USUARIO $result->use_nome PARA SALVAR!"));
            }

            $metedoAuditoria = 'update';
            $dataAuditoria = $result->auditoriaUpdateAtributos();
        } else {

            $metedoAuditoria = 'insert';
            $dataAuditoria = $entityUsuario->auditoriaInsertAtributos();
        };

        try {

            if ($this->usuarioModel->save($data)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'usuario', $metedoAuditoria, $dataAuditoria);

                $cod_usuario = (!empty($this->request->getPost('cod_usuario'))) ? $this->request->getPost('cod_usuario') : $this->usuarioModel->getInsertID();

                $return = $this->buscaRegistro404($cod_usuario);

                return $this->response->setJSON($this->responseSavedSuccessfully("O USUARIO $return->cad_usuario FOI SALVO!"));
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function updatePassword()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        if (!empty($this->request->getPost('cod_usuario'))) {

            $result = $this->buscaRegistro404($this->request->getPost('cod_usuario'));

            if ($result == null) {
                return $this->response->setJSON($this->responseUnableProcessRequest("NÃO FOI LOCALIZADO O USUARIO!"));
            }

            if ($this->request->getPost('cad_password') != $this->request->getPost('confirm_password')) {
                return $this->response->setJSON($this->responseUnableProcessRequest("AS SENHAS INFORMADAS NÃO CONFERE!"));
            }

            $data['use_password'] = password_hash($this->request->getPost('cad_password'), PASSWORD_DEFAULT);

            // $metedoAuditoria = 'update';
            // $dataAuditoria = $result->auditoriaUpdateAtributos();
        }
        try {
            if ($this->usuarioModel->update($this->request->getPost('cod_usuario'), $data)) {
                // $this->auditoriaModel->insertAuditoria('configuracao', 'usuario', $metedoAuditoria, $dataAuditoria);
                return $this->response->setJSON($this->responseSavedSuccessfully("O USUARIO $result->cad_usuario FOI SALVO!"));
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    public function getAll()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->findAll();
        $i = 0;
        foreach ($usuarios as $row) {
            $dados[$i] = array(
                'cad_codigo'        => $row['id'],
                'cad_name'          => $row['use_nome'],
                'cad_apelido'       => $row['use_apelido'],
                'cad_email'         => $row['use_email'],
                'cad_telefone'      => $row['use_telefone'],
                'cad_user'          => $row['use_username'],
                'cad_sexo'          => $row['use_sexo'],
                'cad_avatar'        => $row['use_avatar'],
                'cad_permissao'     => $row['permissao_id'],
                'status'            => $row['status']
            );
            $i++;
        }
        if ($usuarios) {
            return json_encode($dados);
        } else {
            return "'No direct script access allowed'";
        }
    }

    public function show(int $paramentro = 0)
    {
        try {
            $return = $this->buscaRegistro404($paramentro);
            // Verifica se o usuario existe.
            if ($return == null) {
                return $this->response->setJSON($this->responseUnableProcessRequest("NÃO FOI LOCALIZADO O USUARIO!"));
            }
            return $this->response->setJSON($return);
        } catch (\Throwable $th) {
            return $this->response->setJSON($this->responseTryThrowable($th));
        }
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->usuarioModel->getUsuario($codigo)) {
            return null;
        }
        return $resultado;
    }
}
