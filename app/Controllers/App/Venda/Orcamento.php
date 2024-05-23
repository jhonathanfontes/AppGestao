<?php

namespace App\Controllers\App\Venda;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;
use App\Traits\FinanceiroTrait;

class Orcamento extends BaseController
{
    use CadastroTrait;
    use FinanceiroTrait;

    public function Orcamento()
    {
        $data = [
            'card_title' => 'GERAR NOVO ORÇAMENTO',
            'card_title_orcamento' => 'RELAÇÃO DOS ORÇAMENTOS ABERTOS - ULTIMOS 30 DIAS',
            'clientes' => $this->setPessoasClientes(),
        ];

        return view('modulo/venda/orcamento', $data);
    }

    public function Orcamento_Selling(string $serial = null)
    {
        $orcamento = $this->listarOrcamentos()
            ->where('serial', $serial)
            ->first();

        if ($orcamento === null) {
            session()->setFlashdata('MsnAtencao', 'ORÇMENTO NÃO FOI LOCALIZADO!');
            return redirect()->to(base_url('app/modulo/venda'));
        }

        $detalhes = $this->listarDetalhes()
            ->where('orcamento_id', $orcamento->cod_orcamento)
            ->whereIn('situacao', ['1', '2', '4'])
            ->withDeleted()
            ->findAll();


        try {

            if ($orcamento === null) {
                return redirect()->to(base_url('app/modulo/venda'));
            }

            $data = [
                'card_title' => 'ORÇAMENTO Nº ' . date("Y", strtotime($orcamento->orc_dataorcamento)) . completeComZero(esc($orcamento->id), 8),
                'clientes' => $this->setPessoasClientes(),
                // 'vendedores' => $this->getVendedores(),
                'orcamento' => $orcamento,
                'detalhes' => $detalhes
            ];

            return view('modulo/venda/orcamento_selling', $data);

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

    public function Cancelamento()
    {
        $data = [
            'card_title' => 'RELAÇÃO DOS CANCELAMENTOS DAS VENDAS',
        ];

        return view('modulo/venda/cancelamento', $data);
    }

    public function Devolucao()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS DEVOLUÇÕES VENDAS',
            'clientes' => $this->setPessoasClientes(),
        ];

        return view('modulo/venda/devolucao', $data);
    }

    public function Pdv()
    {
        $orcamento = $this->listarOrcamentos()
            ->where('venda_tipo', 1)
            ->where('situacao', 4)
            ->where('orc_pdv', 'S')
            ->first();

        // dd($orcamento);

        if ($orcamento === null) {
            return redirect()->to(base_url('api/venda/pdv/novo'));
        } else {
            return redirect()->to(base_url('app/venda/pdv/selling/' . $orcamento->serial));
        }
    }

    public function Pdv_Selling(string $serial = null)
    {

        if (count($this->setCaixasAbertos()) == 0) {
            session()->setFlashdata('MsnError', 'PARA USAR O PDV É NECESSARIO QUE O CAIXA ESTEJA ABERTO!');

            return $this->response->redirect(site_url('app/caixa/'));
        }

        $orcamento = $this->listarOrcamentos()
            ->where('orc_pdv', 'S')
            ->where('serial', $serial)
            ->first();

        if ($orcamento === null) {
            return redirect()->to(base_url('app/modulo/venda'));
        }

        $venda = $this->listarVendasAReceber()
            ->where('orcamento_id', $orcamento->cod_orcamento)
            ->first();

        $detalhes = $this->listarDetalhes()
            ->where('est_detalhe.situacao >=', 1)
            ->where('est_detalhe.situacao <=', 2)
            ->where('est_detalhe.orcamento_id', $orcamento->cod_orcamento)
            ->findAll();

        $recebimentoReceber = $this->listarReceberCaixaRecebimento($orcamento->cod_orcamento);
        $recebimentoMovimento = $this->listarMovimentoCaixaRecebimento($orcamento->cod_orcamento);

        try {

            if ($orcamento === null) {
                return redirect()->to(base_url('app/modulo/venda'));
            }

            $data = [
                'card_title' => 'ORÇAMENTO Nº ' . $orcamento->cod_orcamento . '/' . date("Y", strtotime($orcamento->orc_data)),
                'clientes' => $this->setPessoasClientes(),
                'vendedores' => $this->getVendedores(),
                'caixas' => $this->setCaixasAbertos(),
                'orcamento' => $orcamento,
                'venda' => $venda,
                'detalhes' => $detalhes,
                'pag_receber' => $recebimentoReceber,
                'pag_movimento' => $recebimentoMovimento
            ];

            return view('modulo/venda/pdv_selling', $data);
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
