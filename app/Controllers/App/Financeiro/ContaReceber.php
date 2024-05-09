<?php

namespace App\Controllers\App\Financeiro;

use App\Controllers\BaseController;
use App\Traits\CadastroTrait;
use App\Traits\FinanceiroTrait;

class ContaReceber extends BaseController
{
    use FinanceiroTrait;
    use CadastroTrait;

    public function index()
    {
        $data = [
            'card_title' => 'RELAÇÃO DAS CONTAS A RECEBER',
        ];
        return view('modulo/financeiro/contasareceber', $data);
    }

    public function view(int $cod_pessoa = null)
    {
        $contaReceberSelecionado = $this->setContaReceberSelecionado($cod_pessoa);

        if ($contaReceberSelecionado == null) {
            session()->setFlashdata('MsnError', "A CONTA A RECEBER Nº $cod_pessoa, NÃO FOI LOCALIZADA!");
            return $this->response->redirect(site_url('app/financeiro/contareceber'));
        }

        $data = [
            'card_title' => 'CONTA A RECEBER' . $cod_pessoa,
            'conta'      => $contaReceberSelecionado,
        ];
        return view('modulo/financeiro/contasareceber_view', $data);
    }

    public function viewCliente(int $codPessoa = null)
    {
        $contaReceberSelecionado    = $this->setContaPessoaSelecionado($codPessoa);
        $pessoaSelecionada          = $this->setPessoaSelecionado($codPessoa);
       // $pagamentoSelecionado       = $this->setRecebimentoClienteSelecionado($codPessoa);

        if ($contaReceberSelecionado == null) {
            session()->setFlashdata('MsnError', "A CONTA A RECEBER Nº $codPessoa, NÃO FOI LOCALIZADA!");
            return $this->response->redirect(site_url('app/financeiro/contareceber'));
        }

        $data = [
            'card_title' => 'CONTA A RECEBER ' . $pessoaSelecionada->pes_nome,
            'cliente'    => $pessoaSelecionada,
            'contas'     => $contaReceberSelecionado,
            'caixa'      => $this->setCaixasAbertos(),
            'pagamentos' => ''
        ];
        return view('modulo/financeiro/contasareceber_viewCliente', $data);
    }
}
