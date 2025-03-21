<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ValeModel;
use App\Models\ColaboradorModel;

class ValesController extends BaseController
{
    protected $valeModel;
    protected $colaboradorModel;

    public function __construct()
    {
        $this->valeModel = new ValeModel();
        $this->colaboradorModel = new ColaboradorModel();
    }

    public function index()
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $vales = $this->valeModel->where('empresa_id', $empresaId)->findAll();

        return view('vales/index', ['vales' => $vales]);
    }

    public function criar()
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $colaboradores = $this->colaboradorModel->where('empresa_id', $empresaId)->findAll();

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['empresa_id'] = $empresaId;

            if ($this->valeModel->insert($data)) {
                return redirect()->to(base_url('vales'))->with('success', 'Vale cadastrado com sucesso!');
            }

            return redirect()->back()->with('error', 'Erro ao cadastrar vale.');
        }

        return view('vales/criar', ['colaboradores' => $colaboradores]);
    }

    public function editar($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $vale = $this->valeModel->where('empresa_id', $empresaId)->find($id);

        if (!$vale) {
            return redirect()->to(base_url('vales'))->with('error', 'Vale não encontrado.');
        }

        $colaboradores = $this->colaboradorModel->where('empresa_id', $empresaId)->findAll();

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['empresa_id'] = $empresaId;

            if ($this->valeModel->update($id, $data)) {
                return redirect()->to(base_url('vales'))->with('success', 'Vale atualizado com sucesso!');
            }

            return redirect()->back()->with('error', 'Erro ao atualizar vale.');
        }

        return view('vales/editar', [
            'vale' => $vale,
            'colaboradores' => $colaboradores
        ]);
    }

    public function excluir($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $vale = $this->valeModel->where('empresa_id', $empresaId)->find($id);

        if (!$vale) {
            return redirect()->to(base_url('vales'))->with('error', 'Vale não encontrado.');
        }

        if ($this->valeModel->delete($id)) {
            return redirect()->to(base_url('vales'))->with('success', 'Vale excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao excluir vale.');
    }

    public function visualizar($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $vale = $this->valeModel->where('empresa_id', $empresaId)->find($id);

        if (!$vale) {
            return redirect()->to(base_url('vales'))->with('error', 'Vale não encontrado.');
        }

        return view('vales/visualizar', ['vale' => $vale]);
    }
} 