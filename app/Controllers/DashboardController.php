<?php

namespace App\Controllers;

use App\Models\ColaboradorModel;
use App\Models\ValeModel;
use App\Models\SalarioModel;

class DashboardController extends BaseController
{
    protected $colaboradorModel;
    protected $valeModel;
    protected $salarioModel;

    public function __construct()
    {
        $this->colaboradorModel = new ColaboradorModel();
        $this->valeModel = new ValeModel();
        $this->salarioModel = new SalarioModel();
    }

    public function index()
    {
        $this->verificarEmpresa();

        $empresaId = $this->getEmpresaId();

        $data = [
            'total_colaboradores' => $this->colaboradorModel->where('empresa_id', $empresaId)->countAllResults(),
            'total_vales' => $this->valeModel->where('empresa_id', $empresaId)->countAllResults(),
            'total_salarios' => $this->salarioModel->where('empresa_id', $empresaId)->countAllResults(),
            'vales_pendentes' => $this->valeModel->where('empresa_id', $empresaId)
                ->where('status', 'pendente')
                ->countAllResults(),
            'salarios_pendentes' => $this->salarioModel->where('empresa_id', $empresaId)
                ->where('status', 'pendente')
                ->countAllResults()
        ];

        return view('dashboard/index', $data);
    }
} 