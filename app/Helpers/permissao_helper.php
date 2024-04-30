<?php

use App\Models\Configuracao\EmpresaModel;
use App\Models\Configuracao\PermissaoModel;

function permissaoMenu($modulo, $action = null)
{
    $permissaoModel = new PermissaoModel();
    $permissaoGrupo = 1;
    $permissao = $permissaoModel->getAcessoPermitido($modulo, $permissaoGrupo);
    if ($permissao) {
        if ($action != null) {
            if ($action == 'edit') {
                if ($permissao['per_editar'] == 'S') {
                    return true;
                } else {
                    return false;
                }
                if ($permissao['per_deletar'] == 'S') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            if (!empty($permissao['per_acesso'])) {
                if ($permissao['per_acesso'] == 'S') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}
function testePermissao2($modulo, $action = null)
{
    $permissaoModel = new PermissaoModel();
    $permissao = $permissaoModel->getModulos($modulo);
    return $permissao;
}
// Carrega a Função do usuario
function funcaoAdm()
{
    $session = \Config\Services::session();
    $user_permissao = $session->get('jb_grupo');
    return serviceConect('v301/configuracao/permissao/' . $user_permissao);
}
// Carrega usuario Logado
function usuarioLogado()
{
    return serviceConect('v301/configuracao/perfil/usuario');
}
// Carrega os dados da Empresa
function dadosEmpresa(int $cod_empresa = 1)
{
    $EmpresaModel = new EmpresaModel();
    $empresa = $EmpresaModel->where('id', $cod_empresa)->first();

    if ($empresa) {
        return $empresa;
    } else {
        return (object)[
            'emp_fantasia' => 'JB SYSTEM',
            'emp_icone' => ''
        ];
    }
}
function setTitle($descricao)
{
    return 'Sistema de Vendas - ' . $descricao;
}

function activeMenu($menu, $referencia, $return)
{
    if ($menu == $referencia) {
        return $return;
    } else {
        return '';
    }
}

function serviceConect($url)
{
    $urlApi = getenv('app.apiURL');

    $session = \Config\Services::session();
    $jb_token = $session->get('jb_token');

    $client = \Config\Services::curlrequest();
    $headers = [
        "content-type" => "application/json",
        'Authorization' => $jb_token,
    ];
    try {
        // $response = $client->request('GET', $urlApi . $url, [
        //     'headers' => $headers
        // ]);
        // return json_decode($response);
    } catch (Exception $th) {
        return $th->getMessage();
        //  die();
    }
}
