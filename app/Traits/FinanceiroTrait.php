<?php

namespace App\Traits;

trait FinanceiroTrait
{
    public function setContaPagarSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Financeiro\ContaModel();
                return $model->getConta()
                    ->where('fin_conta.id', $codigo)
                    ->first();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaPessoaSelecionado(int $codPessoa = null, int $codTipo = null)
    {
        try {
            if ($codPessoa != null) {
                $model = new \App\Models\Financeiro\ContaModel();
                return $model->getConta()
                    ->where('fin_conta.fin_tipoconta', $codTipo)
                    ->where('fin_conta.pessoa_id', $codPessoa)
                    ->findAll();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaReceberSelecionado(int $codigo = null)
    {
        try {
            if ($codigo != null) {
                $model = new \App\Models\Financeiro\ContaModel();
                return $model->getContaReceber($codigo);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setContaReceberClienteSelecionado(int $codPessoa = null)
    {
        try {
            if ($codPessoa != null) {
                $model = new \App\Models\Financeiro\ContaModel();
                return $model->getContaReceberCliente($codPessoa)->findAll();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setRecebimentoClienteSelecionado(int $codPessoa = null)
    {
        try {
            if ($codPessoa != null) {
                $model = new \App\Models\Financeiro\PagamentoModel();
                return $model->getRecebimentoContaReceberCliente($codPessoa)->findAll();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setCaixasAbertos()
    {
        try {
            $model = new \App\Models\Venda\CaixaModel();
            return $model->select('pdv_caixa.*, use_abertura.use_nome as use_abertura, use_fechamento.use_nome as use_fechamento')
                ->join('cad_usuario as use_abertura', 'use_abertura.id = pdv_caixa.created_user_id', 'LEFT')
                ->join('cad_usuario as use_fechamento', 'use_fechamento.id = pdv_caixa.fec_user_id', 'LEFT')
                ->where('situacao', '1')
                ->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getSubgrupos()
    {
        try {
            $subgrupoModel = new \App\Models\Financeiro\SubGrupoModel();
            return $subgrupoModel->rertunSubgrupoGrupo();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setCaixaSelecionado(string $serial = null)
    {
        try {

            $caixaModel = new \App\Models\Venda\CaixaModel();

            return $caixaModel->select('pdv_caixa.*, use_abertura.use_nome as use_abertura, use_fechamento.use_nome as use_fechamento')
                ->join('cad_usuario as use_abertura', 'use_abertura.id = pdv_caixa.created_user_id', 'LEFT')
                ->join('cad_usuario as use_fechamento', 'use_fechamento.id = pdv_caixa.fec_user_id', 'LEFT');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoCaixa()
    {
        try {

            $caixaModel = new \App\Models\Venda\CaixaModel();
            $atributos = [
                'pdv_caixa.id as cod_caixa',
                'pdv_caixa.total as saldo_inicial',
                '(SELECT COALESCE(SUM(fm.mov_valor),0) FROM fin_movimentacao fm WHERE fm.caixa_id = pdv_caixa.id AND fm.situacao = 2 AND fm.mov_caixatipo = 1) AS suplemento',
                '(SELECT COALESCE(SUM(fm.mov_valor),0) FROM fin_movimentacao fm WHERE fm.caixa_id = pdv_caixa.id AND fm.situacao = 2 AND fm.mov_formapagamento = 1 and fm.orcamento_id is not null) AS vendas',
                '(SELECT COALESCE(SUM(fm.mov_valor),0) FROM fin_movimentacao fm WHERE fm.caixa_id = pdv_caixa.id AND fm.situacao = 2 AND fm.mov_caixatipo = 2) AS sagria',
                '(SELECT COALESCE(SUM(fm.mov_valor),0) FROM fin_movimentacao fm WHERE fm.caixa_id = pdv_caixa.id AND fm.situacao = 2 AND fm.mov_formapagamento = 1 AND fm.mov_es = 2 and fm.conta_id is not null) AS pagamentos',
                '(SELECT COALESCE(SUM(fm.mov_valor),0) FROM fin_movimentacao fm WHERE fm.caixa_id = pdv_caixa.id AND fm.situacao = 2 AND fm.mov_formapagamento = 1 AND fm.mov_es = 1 and fm.conta_id  is not null) AS recebimentos'
            ];
            return $caixaModel->select($atributos);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoVenda()
    {
        try {

            $vendaModel = new \App\Models\Venda\VendaModel();

            $atributos = [
                'pdv_venda.id AS cod_venda',
                'pdv_venda.orcamento_id AS cod_orcamento',
                'pdv_venda.caixa_id AS cod_caixa',
                'cad_pessoa.pes_nome AS pessoa',
                '(select cast(coalesce(sum(fm.mov_valor),0) as decimal(9,2)) from fin_movimentacao fm where fm.orcamento_id = pdv_venda.orcamento_id and 
                fm.situacao = 2 and fm.mov_formapagamento = 1 and fm.caixa_id = pdv_venda.caixa_id) AS dinheiro',
                '(select cast(coalesce(sum(fm.mov_valor),0) as decimal(9,2)) from fin_movimentacao fm where fm.orcamento_id = pdv_venda.orcamento_id and 
                fm.situacao = 2 and fm.mov_formapagamento = 2 and fm.caixa_id = pdv_venda.caixa_id) AS transferencia',
                '(select cast(coalesce(sum(fm.mov_valor),0) as decimal(9,2)) from fin_movimentacao fm where fm.orcamento_id = pdv_venda.orcamento_id and 
                fm.situacao = 2 and fm.mov_formapagamento = 3 and fm.caixa_id = pdv_venda.caixa_id) AS debito',
                '(select cast(coalesce(sum(fm.mov_valor),0) as decimal(9,2)) from fin_movimentacao fm where fm.orcamento_id = pdv_venda.orcamento_id and 
                fm.situacao = 2 and fm.mov_formapagamento = 4 and fm.caixa_id = pdv_venda.caixa_id) AS credito',
                '(select cast(coalesce(sum(fm.mov_valor),0) as decimal(9,2)) from fin_movimentacao fm where fm.orcamento_id = pdv_venda.orcamento_id and 
                fm.situacao = 2 and fm.mov_formapagamento = 6 and fm.caixa_id = pdv_venda.caixa_id) AS creditofinanceiro',
                '(select cast(coalesce(sum(fr.rec_valor),0) as decimal(9,2)) from fin_receber fr where fr.orcamento_id = pdv_venda.orcamento_id and fr.situacao in (2,5)) AS boleto'
            ];
            return $vendaModel->select($atributos)
                ->join('pdv_orcamento', 'pdv_orcamento.id_orcamento = pdv_venda.orcamento_id', 'LEFT')
                ->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id', 'LEFT')
                ->join('pdv_caixa', 'pdv_caixa.id = pdv_venda.caixa_id', 'LEFT')
                ->where('pdv_venda.situacao', 2);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoRetirada()
    {
        try {
            $movimentacaoModel = new \App\Models\Financeiro\MovimentacaoModel();
            return $movimentacaoModel->getMovimentacaoRetiradas();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoDevolucao()
    {
        try {
            $devolucaoModel = new \App\Models\Venda\DevolucaoModel();
            return $devolucaoModel->getDevolucoes()
                ->where('pdv_devolucao.situacao', 2);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoCaixaRecebimentos()
    {
        try {
            $contaModel = new \App\Models\Financeiro\ContaModel();
            return $contaModel->resumoReceberCaixa();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarReceberCaixaRecebimento($cod_orcamento = null)
    {
        try {
            $contaModel = new \App\Models\Financeiro\ContaModel();
            return $contaModel->getContaReceberCaixa($cod_orcamento);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarMovimentoCaixaRecebimento($cod_orcamento = null)
    {
        try {
            $movimentacaoModel = new \App\Models\Financeiro\MovimentacaoModel();
            return $movimentacaoModel
                ->whereIn('situacao', ['1', '2'])
                ->where('orcamento_id', $cod_orcamento)
                ->findAll();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoCaixaPagamentos()
    {
        try {
            $contaReceberModel = new \App\Models\Financeiro\ContaPagarModel();
            return $contaReceberModel->resumoPagamentoCaixa();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function resumoMovimentoCaixa()
    {
        try {
            $movimentacaoModel = new \App\Models\Financeiro\MovimentacaoModel();
            return $movimentacaoModel->getSuplementoSangriaCaixa();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarVendasAReceber()
    {
        try {
            $vendaModel = new \App\Models\Venda\VendaModel();
            return $vendaModel->getListarVendas();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarVendaPDV()
    {
        try {
            $vendaModel = new \App\Models\Venda\VendaModel();
            return $vendaModel->getListarVendas();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarOrcamentos()
    {
        try {
            $vendaModel = new \App\Models\Venda\OrcamentoModel();
            return $vendaModel->returnOrcamentos();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarDetalhes()
    {
        try {
            $detalheModel = new \App\Models\Estoque\DetalheModel();
            return $detalheModel->getProdutoDetalhe();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarFormaPagamento()
    {
        try {
            $vendaModel = new \App\Models\Configuracao\FormaPagamentoModel();
            return $vendaModel->select('id, for_descricao');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
