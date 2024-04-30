<?php

namespace App\Traits;

trait CadastroTrait
{
    // Trait Cadastro Produto
    public function setProdutoSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Cadastro\ProdutoModel();
                return $model->getProduto($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setTamanhosProdutoSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Cadastro\ProdutoGradeModel();
                return $model->getTamanhosProdutoGrade($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    // Trait Cadastro Pessoa
    public function setPessoaSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Cadastro\PessoaModel();
                return $model->withDeleted(true)
                    ->find($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    // Trait Cadastro Pessoa
    public function setPessoasClientes()
    {
        try {
            $model = new \App\Models\Cadastro\PessoaModel();
            return $model->getClientes();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    public function setPessoasFornecedores()
    {
        try {
            $model = new \App\Models\Cadastro\PessoaModel();
            return $model->getFornecedores();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

      // Trait Configuração Vendedor
    public function getVendedores()
    {
        try {
            $detalheModel  = new \App\Models\Configuracao\VendedorModel();
            return $detalheModel->getVendedor()
                ->where('cad_vendedor.status', 1)
                ->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
