<?php

namespace App\Controllers;

use App\Models\ColaboradorModel;

class ColaboradoresController extends BaseController
{
    protected $colaboradorModel;

    public function __construct()
    {
        $this->colaboradorModel = new ColaboradorModel();
    }

    public function index()
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $colaboradores = $this->colaboradorModel->where('empresa_id', $empresaId)->findAll();

        return view('colaboradores/index', ['colaboradores' => $colaboradores]);
    }

    public function criar()
    {
        $this->verificarEmpresa();

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['empresa_id'] = $this->getEmpresaId();

            if ($this->colaboradorModel->insert($data)) {
                return redirect()->to(base_url('colaboradores'))->with('success', 'Colaborador cadastrado com sucesso!');
            }

            return redirect()->back()->with('error', 'Erro ao cadastrar colaborador.');
        }

        return view('colaboradores/criar');
    }

    public function editar($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $colaborador = $this->colaboradorModel->where('empresa_id', $empresaId)->find($id);

        if (!$colaborador) {
            return redirect()->to(base_url('colaboradores'))->with('error', 'Colaborador não encontrado.');
        }

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['empresa_id'] = $empresaId;

            if ($this->colaboradorModel->update($id, $data)) {
                return redirect()->to(base_url('colaboradores'))->with('success', 'Colaborador atualizado com sucesso!');
            }

            return redirect()->back()->with('error', 'Erro ao atualizar colaborador.');
        }

        return view('colaboradores/editar', ['colaborador' => $colaborador]);
    }

    public function excluir($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $colaborador = $this->colaboradorModel->where('empresa_id', $empresaId)->find($id);

        if (!$colaborador) {
            return redirect()->to(base_url('colaboradores'))->with('error', 'Colaborador não encontrado.');
        }

        if ($this->colaboradorModel->delete($id)) {
            return redirect()->to(base_url('colaboradores'))->with('success', 'Colaborador excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao excluir colaborador.');
    }

    public function visualizar($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $colaborador = $this->colaboradorModel->where('empresa_id', $empresaId)->find($id);

        if (!$colaborador) {
            return redirect()->to(base_url('colaboradores'))->with('error', 'Colaborador não encontrado.');
        }

        return view('colaboradores/visualizar', ['colaborador' => $colaborador]);
    }
} 