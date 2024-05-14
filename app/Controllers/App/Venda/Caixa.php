<?php

namespace App\Controllers\App\Venda;

use App\Controllers\BaseController;
use App\Traits\FinanceiroTrait;
use CodeIgniter\View\View;

class Caixa extends BaseController
{
    use FinanceiroTrait;

    public function index(string $serial = null)
    {
        if ($serial == null) {
            $caixas = $this->setCaixasAbertos();
        }

        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        if (count($caixas) == 0) {

            $data = [
                'card_title' => 'RELAÇÃO DOS CAIXAS CADASTRADOS',
                'hostname' => $hostname,
                'caixas' => $this->setCaixasAbertos(),

            ];

            return View('modulo/venda/caixa_closet', $data);

        } else {

            if (count($caixas) === 1) {

                return $this->response->redirect(site_url('app/caixa/' . $caixas[0]->serial));
            } else {

                foreach ($caixas as $row) {
                    if ($row->cai_logged === $hostname) {
                        $serialCaixa = $row->serial;
                    }
                }

                if (isset($serialCaixa)) {
                    return $this->response->redirect(site_url('app/caixa/' . $serialCaixa));
                }

                $data = [
                    'card_title' => 'RELAÇÃO DOS CAIXAS CADASTRADOS',
                    'hostname' => $hostname,
                    'caixas' => $this->setCaixasAbertos(),
                ];

                return view('modulo/venda/caixa_open', $data);
            }
        }
    }
    public function caixaAbertoTerminal(string $serial = null)
    {

        $caixaSelecionado = $this->setCaixaSelecionado()->where('pdv_caixa.serial', $serial)->first();
        // d($caixaSelecionado);
        // dd($this->listarVendasAReceber()->where('pdv_venda.situacao', 1)->get()->getResult()); //->where('pdv_caixa.serial', $serial));

        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = [
            'card_title' => 'RELAÇÃO DOS CAIXAS CADASTRADOS',
            'hostname' => $hostname,
            'caixa' => $caixaSelecionado,
            'res_movimento' => $this->resumoCaixa()->where('pdv_caixa.serial', $serial)->first(),
            // 'res_venda'     => $this->resumoVenda()->where('pdv_caixa.serial', $serial)->findAll(),
            // 'res_retirada'  => $this->resumoRetirada()->where('pdv_caixa.serial', $serial)->findAll(),
            // 'res_devolucao' => $this->resumoDevolucao()->where('pdv_devolucao.caixa_id', $caixaSelecionado->id)->findAll(),
            'movimentacoes' => $this->resumoMovimentoCaixa()->where('fin_movimentacao.caixa_id', $caixaSelecionado->id)->findAll(),
            // 'res_rebecer'   => $this->resumoCaixaRecebimentos()->where('cod_caixa', $caixaSelecionado->id)->get()->getResult(),
            // 'res_pagar'     => $this->resumoCaixaPagamentos()->where('cod_caixa', $caixaSelecionado->id)->get()->getResult(),
            'sum_movimento' => array('suplemento' => 0, 'sangria' => 0),
            'sum_vendas'    => array('dinheiro' => 0, 'transferencia' => 0, 'debito' => 0, 'credito' => 0, 'boleto' => 0, 'creditofinanceiro' => 0),
            'sum_rebecer'   => array('dinheiro' => 0, 'transferencia' => 0, 'debito' => 0, 'credito' => 0, 'boleto' => 0, 'creditofinanceiro' => 0),
            'sum_pagar'     => array('dinheiro' => 0, 'transferencia' => 0),
            // 'a_receber'     => $this->listarVendasAReceber()->where('pdv_venda.situacao', 1)->get()->getResult(),
            'formaPagmento' => $this->listarFormaPagamento()->where('for_forma', 1)->where('status', 1)->findAll()

        ];

        return view('modulo/venda/caixa_opem_terminal', $data);
    }
    public function caixaReceberVenda(string $serial = null)
    {
        $orcamento = $this->listarOrcamentos()
            ->where('serial', $serial)
            ->first();

        $venda = $this->listarVendasAReceber()
            ->where('orcamento_id', $orcamento->cod_orcamento)
            ->first();

        $recebimentoReceber = $this->listarReceberCaixaRecebimento($orcamento->cod_orcamento);
        $recebimentoMovimento = $this->listarMovimentoCaixaRecebimento($orcamento->cod_orcamento);

        try {

            if ($venda->situacao == 4) {
                // dd($venda);
                return $this->response->redirect(site_url('app/venda/orcamento/selling/' . $venda->serial));
            }

            $data = [
                'card_title' => 'ORÇAMENTO Nº ' . $orcamento->cod_orcamento . '/' . date("Y", strtotime($orcamento->orc_data)),
                'caixas' => $this->setCaixasAbertos(),
                'orcamento' => $orcamento,
                'rec_o' => $recebimentoReceber,
                'rec_c' => $recebimentoMovimento,
                'venda' => $venda,
            ];

            return view('modulo/venda/caixa_receber', $data);
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }
}
