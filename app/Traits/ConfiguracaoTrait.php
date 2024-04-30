<?php

namespace App\Traits;

trait ConfiguracaoTrait
{
    public function setBancos()
    {
        try {
            $model = new \App\Models\Configuracao\BancoModel();
            return $model->select('id_banco, ban_codigo, ban_descricao')->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setEmpresas()
    {
        try {
            $model = new \App\Models\Configuracao\EmpresaModel();
            return $model->select('id_empresa, emp_razao')->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setMaquinaCartao()
    {
        try {
            $model = new \App\Models\Configuracao\MaquinaCartaoModel();
            return $model->select('id_maquina as cod_maquina, maq_descricao')->where('status', 1)->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaBancaria()
    {
        try {
            $model = new \App\Models\Configuracao\ContaBancariaModel();
            return $model->select('id_conta as cod_conta, con_descricao, con_agencia, con_conta, con_tipo')->where('status', 1)->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaBancariaPagamentos()
    {
        try {
            $model = new \App\Models\Configuracao\ContaBancariaModel();
            return $model->select('id_conta as cod_conta, con_descricao, con_agencia, con_conta, con_tipo')->where('con_pagar', 'S')->where('status', 1)->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaBancariaRecebimentos()
    {
        try {
            $model = new \App\Models\Configuracao\ContaBancariaModel();
            return $model->select('id_conta as cod_conta, con_descricao, con_agencia, con_conta, con_tipo')->where('con_receber', 'S')->where('status', 1)->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setBandeirasCartoes()
    {
        try {
            $model = new \App\Models\Configuracao\BandeiraModel();
            return $model->select('id_bandeira, ban_descricao')->where('status', 1)->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setFormaPagamentoSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Configuracao\FormaPagamentoModel();
                return $model->getFormaPagamento($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaPagarSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Financeiro\ContaPagarModel();
                return $model->getContaPagar($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaReceberSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Financeiro\ContaReceberModel();
                return $model->getContaReceber($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setUsuarios()
    {
        try {
            $model = new \App\Models\Configuracao\UsuarioModel();
            return $model->select('id_usuario, use_nome, use_username')->where('status', 1)->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
