<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmpresaModel;
use App\Models\UsuarioEmpresaModel;

class EmpresasController extends BaseController
{
    protected $empresaModel;
    protected $usuarioEmpresaModel;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
        $this->usuarioEmpresaModel = new UsuarioEmpresaModel();
    }

    public function selecionar()
    {
        if (!$this->request->is('post')) {
            $usuarioId = auth()->id();
            $empresas = $this->usuarioEmpresaModel->select('con_empresa.*')
                ->join('con_empresa', 'con_empresa.id = cad_usuario_empresa.empresa_id')
                ->where('cad_usuario_empresa.usuario_id', $usuarioId)
                ->where('cad_usuario_empresa.status', 1)
                ->where('cad_usuario_empresa.deleted_at IS NULL')
                ->findAll();

            return view('empresas/selecionar', ['empresas' => $empresas]);
        }

        $empresaId = $this->request->getPost('empresa_id');
        
        if (!$empresaId) {
            return redirect()->back()->with('error', 'Por favor, selecione uma empresa.');
        }

        // Verifica se o usuário tem acesso à empresa selecionada
        $temAcesso = $this->usuarioEmpresaModel->where('usuario_id', auth()->id())
            ->where('empresa_id', $empresaId)
            ->where('status', 1)
            ->where('deleted_at IS NULL')
            ->first();

        if (!$temAcesso) {
            return redirect()->back()->with('error', 'Você não tem acesso a esta empresa.');
        }

        // Salva a empresa selecionada na sessão
        session()->set('empresa_id', $empresaId);
        
        // Busca os dados da empresa
        $empresa = $this->empresaModel->find($empresaId);
        session()->set('empresa_nome', $empresa['nome']);

        return redirect()->to(base_url('app/dashboard'))->with('success', 'Empresa selecionada com sucesso.');
    }

    public function trocar()
    {
        return $this->selecionar();
    }
} 