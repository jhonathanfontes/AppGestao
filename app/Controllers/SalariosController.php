<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SalarioModel;
use App\Models\ColaboradorModel;

class SalariosController extends BaseController
{
    protected $salarioModel;
    protected $colaboradorModel;

    public function __construct()
    {
        $this->salarioModel = new SalarioModel();
        $this->colaboradorModel = new ColaboradorModel();
    }

    public function index()
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $salarios = $this->salarioModel->where('empresa_id', $empresaId)->findAll();

        return view('salarios/index', ['salarios' => $salarios]);
    }

    public function criar()
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $colaboradores = $this->colaboradorModel->where('empresa_id', $empresaId)->findAll();

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['empresa_id'] = $empresaId;

            if ($this->salarioModel->insert($data)) {
                return redirect()->to(base_url('salarios'))->with('success', 'Salário cadastrado com sucesso!');
            }

            return redirect()->back()->with('error', 'Erro ao cadastrar salário.');
        }

        return view('salarios/criar', ['colaboradores' => $colaboradores]);
    }

    public function editar($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $salario = $this->salarioModel->where('empresa_id', $empresaId)->find($id);

        if (!$salario) {
            return redirect()->to(base_url('salarios'))->with('error', 'Salário não encontrado.');
        }

        $colaboradores = $this->colaboradorModel->where('empresa_id', $empresaId)->findAll();

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['empresa_id'] = $empresaId;

            if ($this->salarioModel->update($id, $data)) {
                return redirect()->to(base_url('salarios'))->with('success', 'Salário atualizado com sucesso!');
            }

            return redirect()->back()->with('error', 'Erro ao atualizar salário.');
        }

        return view('salarios/editar', [
            'salario' => $salario,
            'colaboradores' => $colaboradores
        ]);
    }

    public function excluir($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $salario = $this->salarioModel->where('empresa_id', $empresaId)->find($id);

        if (!$salario) {
            return redirect()->to(base_url('salarios'))->with('error', 'Salário não encontrado.');
        }

        if ($this->salarioModel->delete($id)) {
            return redirect()->to(base_url('salarios'))->with('success', 'Salário excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao excluir salário.');
    }

    public function visualizar($id)
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();
        $salario = $this->salarioModel->where('empresa_id', $empresaId)->find($id);

        if (!$salario) {
            return redirect()->to(base_url('salarios'))->with('error', 'Salário não encontrado.');
        }

        return view('salarios/visualizar', ['salario' => $salario]);
    }
} 