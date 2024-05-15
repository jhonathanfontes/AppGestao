<?php

namespace App\Controllers\App\Financeiro;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;
use App\Traits\FinanceiroTrait;

class ContaPagar extends BaseController
{
    use FinanceiroTrait;
    use CadastroTrait;

    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CONTAS A PAGAR',
        ];
        return view('modulo/financeiro/contasapagar', $data);
    }

    public function view(int $codigo = null)
    {
        $data = [
            'card_title'    => 'CONTA A PAGAR' . $codigo,
            'conta'         => $this->setContaPagarSelecionado($codigo),
        ];
        return view('modulo/financeiro/contasapagar_view', $data);
    }

    public function viewFornecedor(int $codPessoa = null)
    {
        $contaPagarSelecionado    = $this->setContaPessoaSelecionado($codPessoa, 2);
        $pessoaSelecionada          = $this->setPessoaSelecionado($codPessoa);

        if ($contaPagarSelecionado == null) {
            session()->setFlashdata('MsnError', "A CONTA A PAGAR DO FORNECEDOR $pessoaSelecionada->pes_nome, NÃO FOI LOCALIZADA!");
            return $this->response->redirect(site_url('app/financeiro/contapagar'));
        }

        // dd($this->setCaixasAbertos());

        $data = [
            'card_title'    => 'CONTA A PAGAR ' . $pessoaSelecionada->pes_nome,
            'cliente'       => $pessoaSelecionada,
            'contas'        => $contaPagarSelecionado,
            'caixa'         => $this->setCaixasAbertos(),
        ];
        return view('modulo/financeiro/contasapagar_viewFornecedor', $data);
    }

    // contasapagar_viewFornecedor
}
