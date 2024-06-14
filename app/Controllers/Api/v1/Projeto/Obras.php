<?php

namespace App\Controllers\Api\v1\Projeto;

use App\Controllers\Api\ApiController;
use App\Entities\Projeto\Obra;
use App\Entities\Venda\Venda;
use CodeIgniter\Model;
use Config\App;

class Obras extends ApiController
{
    private $obraModel;
    private $enderecoModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->obraModel = new \App\Models\Projeto\ObraModel();
        $this->enderecoModel = new \App\Models\EnderecoModel();
        // $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response['data'] = array();

        $result = $this->obraModel->getObra()->
            where('ger_obra.situacao', '5')->
            withDeleted()->
            findAll();

        try {
            // return $this->response->setJSON($result);
            if (empty($result)):
                return $this->response->setJSON($response);
            endif;

            foreach ($result as $key => $value) {

                $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalObra" onclick="getEditObra(' . $value->cod_obra . ')"><samp class="far fa-sm fa-edit"></samp> EDITAR</button>';
                // $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'obra'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
                $ops .= ' <a class="btn btn-xs btn-success" href="' . base_url('app/projeto/obra/view/' . $value->serial) . '"><span class="fas fa-sm fa-tasks"></span> GERENCIAR </a>';

                $response['data'][$key] = array(
                    date("Y", strtotime($value->created_at)) . completeComZero(esc($value->cod_obra), 8),
                    esc($value->cad_obra),
                    esc($value->cad_datainicio) ? esc(formatDataBR($value->cad_datainicio)) : '<span class="badge badge-danger">SEM DATA PREVISTA</span>',
                    esc($value->cad_nome),
                    $ops,
                );
            }

            return $this->response->setJSON($response);

        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function getCarregaTabelaAndamento()
    {
        $response['data'] = array();

        $result = $this->obraModel->getObra()->
            where('ger_obra.situacao', '1')->
            withDeleted()->
            findAll();

        try {
            // return $this->response->setJSON($result);
            if (empty($result)):
                return $this->response->setJSON($response);
            endif;

            foreach ($result as $key => $value) {

                // $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'obra'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
                $ops = ' <a class="btn btn-xs btn-success" href="' . base_url('app/projeto/gerenciar/obra/andamento/view/' . $value->serial) . '"><span class="fas fa-sm fa-tasks"></span> GERENCIAR </a>';

                $response['data'][$key] = array(
                    date("Y", strtotime($value->created_at)) . completeComZero(esc($value->cod_obra), 8),
                    esc($value->cad_obra),
                    esc($value->cad_datainicio) ? esc(formatDataBR($value->cad_datainicio)) : '<span class="badge badge-danger">SEM DATA PREVISTA</span>',
                    esc($value->cad_nome),
                    $ops,
                );
            }

            return $this->response->setJSON($response);

        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function getCarregaTabelaFinalizado()
    {
        $response['data'] = array();

        $result = $this->obraModel->getObra()->
            where('ger_obra.situacao', '2')->
            withDeleted()->
            findAll();

        try {
            // return $this->response->setJSON($result);
            if (empty($result)):
                return $this->response->setJSON($response);
            endif;

            foreach ($result as $key => $value) {

                // $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'obra'" . ',' . $value->id . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';
                $ops = ' <a class="btn btn-xs btn-success" href="' . base_url('app/projeto/gerenciar/obra/finalizada/view/' . $value->serial) . '"><span class="fas fa-sm fa-tasks"></span> GERENCIAR </a>';

                $response['data'][$key] = array(
                    date("Y", strtotime($value->created_at)) . completeComZero(esc($value->cod_obra), 8),
                    esc($value->cad_obra),
                    esc($value->cad_datainicio) ? esc(formatDataBR($value->cad_datainicio)) : '<span class="badge badge-danger">SEM DATA PREVISTA</span>',
                    esc($value->cad_nome),
                    $ops,
                );
            }

            return $this->response->setJSON($response);

        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL PROCESSAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }
    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $endereco = [];

        if (!empty($this->request->getPost('cod_endereco'))) {
            $endereco['id'] = $this->request->getPost('cod_endereco');
        }

        if (!empty($this->request->getPost('cad_endereco'))) {
            $endereco['end_endereco'] = returnNull($this->request->getPost('cad_endereco'), 'S');
            $endereco['end_numero'] = returnNull($this->request->getPost('cad_numero'), 'S');
            $endereco['end_setor'] = returnNull($this->request->getPost('cad_bairo'), 'S');
            $endereco['end_cidade'] = returnNull($this->request->getPost('cad_cidade'), 'S');
            $endereco['end_estado'] = returnNull($this->request->getPost('cad_uf'), 'S');
            $endereco['end_complemento'] = returnNull($this->request->getPost('cad_complemento'), 'S');
            $endereco['end_cep'] = returnNull($this->request->getPost('cad_cep'), 'S');

        }

        // return $this->response->setJSON($endereco);

        if (!empty($endereco)) {
            if ($this->enderecoModel->save($endereco)) {
                $data['endereco_id'] = (!empty($this->request->getPost('cod_endereco'))) ? $this->request->getPost('cod_endereco') : $this->enderecoModel->getInsertID();
            }
        }

        $cod_pessoa = returnNull($this->request->getPost("cod_pessoa"));

        $data['pessoa_id'] = $cod_pessoa;
        $data['obr_descricao'] = returnNull($this->request->getPost('cad_obra'), 'S');
        $data['obr_datainicio'] = returnNull(esc($this->request->getPost('cad_datainicio')));
        $data['situacao'] = '5';

        $entityObra = new Obra($data);

        if (!empty($this->request->getPost('cod_obra'))) {

            $data['id'] = $this->request->getPost('cod_obra');

            $result = $this->buscaRegistro404($data['id']);
            $result->fill($data);


            if ($result->hasChanged() == false && empty($this->request->getPost('cod_endereco'))) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA OBRA $result->cad_obra PARA SALVAR!"
                    ]
                ]);
            }

            $metedoAuditoria = 'update';
            // $dataAuditoria = $result->auditoriaUpdateAtributos();

        } else {

            $getSerial = $cod_pessoa . getSerial();

            if ($this->buscaRegistro404Serial($getSerial) == null) {
                $serial = $getSerial;
            } else {
                $serial = $cod_pessoa . getSerial();
            }

            $data['serial'] = $serial;

            $metedoAuditoria = 'insert';
            // $dataAuditoria = $entityObra->auditoriaInsertAtributos();

        }
        try {
            if ($this->obraModel->save($data)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'obra', $metedoAuditoria, $dataAuditoria);
                $cod_obra = (!empty($this->request->getPost('cod_obra'))) ? $this->request->getPost('cod_obra') : $this->obraModel->getInsertID();

                $rowObra = $this->obraModel->getObra()
                    ->where('ger_obra.id', $cod_obra)
                    ->first();

                if (empty($rowObra->cod_orcamento)) {

                    $orcamentoModel = new \App\Models\Venda\OrcamentoModel();

                    $obra['pessoa_id'] = $cod_pessoa;
                    $obra['obra_id'] = $cod_obra;
                    $obra['situacao'] = '5';
                    $obra['serial'] = $serial;

                    $orcamentoModel->save($obra);

                }

                $return = $this->obraModel->returnSave($cod_obra);

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A OBRA $return->cad_obra FOI SALVAR!"
                    ]
                ]);
            }
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

    public function findAll()
    {
        $return = $this->obraModel
            ->where('status', 1)
            ->orderBy('cat_descricao', 'asc')
            ->findAll();
        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->obraModel->getObra()
            ->where('ger_obra.id', $paramentro)
            ->first();

        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $obra = $this->obraModel->where('id', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($obra === null) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL ARQUIVAR O REGISTRO!',
                        'description' => 'REGISTRO INFORMADO NÃO FOI LOCALIZADO!'
                    ]
                ]
            );
        }

        try {
            if ($this->obraModel->arquivarRegistro($paramentro)) {

                // $this->auditoriaModel->insertAuditoria('cadastro', 'obra', 'arquivar', $obra->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A OBRA $obra->cad_obra FOI ARQUIVADA!"
                    ]
                ]);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON(
                [
                    'status' => false,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL ARQUIVAR O REGISTRO!',
                        'description' => $th->getMessage()
                    ]
                ]
            );
        }
    }

    public function geraOrcamento()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $obra = $this->buscaRegistro404Serial($this->request->getPost('serial'));

        if ($this->request->getPost('cod_obra') != $obra->cod_obra or $obra->situacao != '1') {
            return $this->response->setJSON([
                'status' => true,
                'menssagem' => [
                    'status' => 'error',
                    'heading' => 'ERRO, NÃO POSSIVEL PROCESSAR A SOLICITAÇÃO!',
                    'description' => "NÃO FOI LOCALIZADO O ORÇAMENTO!"
                ]
            ]);
        }

        if ($this->obraModel->countProdutoObra($obra->cod_obra)->totalProdutos <= 0) {
            return $this->response->setJSON([
                'status' => true,
                'menssagem' => [
                    'status' => 'warning',
                    'heading' => 'ATENÇÃO, NÃO FOI POSSIVEL GERAR O ORÇAMENTO!',
                    'description' => "NÃO FOI LOCALIZADO PRODUTOS OU SERVIÇOS NESTE ORÇAMENTO!"
                ]
            ]);
        }

        return $this->response->setJSON($this->gerarArrayObra($obra->cod_obra));

    }

    private function gerarArrayObra(int $cod_obra = null)
    {
        if (
            !$cod_obra || !$obra = $this->obraModel->getObra()
                ->where('ger_obra.id', $cod_obra)
                ->first()
        ) {
            return null;
        }
        $localModel = new \App\Models\Projeto\LocalModel();

        $locais = $localModel->where('obra_id', $cod_obra)->
            whereIn('status', ['1', '2'])
            ->withDeleted()
            ->findAll();

        $data['cod_obra'] = $obra->cod_obra;
        $data['cad_obra'] = $obra->cad_obra;
        $data['cod_orcamento'] = $obra->cod_orcamento;
        $data['cod_pessoa'] = $obra->pessoa_id;
        $data['cad_nome'] = $obra->cad_nome;
        $data['cod_endereco'] = $obra->endereco_id;
        $data['cad_endereco'] = $obra->cad_endereco;
        $data['cad_setor'] = $obra->cad_setor;
        $data['cad_numero'] = $obra->cad_numero;
        $data['cad_cidade'] = $obra->cad_cidade;
        $data['cad_estado'] = $obra->cad_estado;
        $data['cad_cep'] = $obra->cad_cep;
        $data['cad_complemento'] = $obra->cad_complemento;
        $data['serial'] = $obra->serial;
        $data['situacao'] = $obra->situacao;
        $data['data'] = $obra->created_at;

        if ($locais) {
            $detalheProdutoModel = new \App\Models\Estoque\DetalheModel();

            $countDetalhe = 0;
            foreach ($locais as $row) {
                $detalhesProdutos = $detalheProdutoModel
                    ->getProdutoDetalhe()
                    ->where('local_id', $row->cod_local)
                    ->whereIn('situacao', ['1', '2', '4'])
                    ->withDeleted()
                    ->orderBy('cad_produto.pro_tipo')
                    ->findAll();

                $data['local'][$countDetalhe] = [
                    'cod_local' => $row->cod_local,
                    'cad_local' => $row->cad_local,
                    'cad_datainicio' => $row->cad_datainicio,
                    'cad_observacao' => $row->cad_observacao,
                    'detalhes' => $detalhesProdutos,
                ];

                $countDetalhe++;
            }
        }

        return $data;
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (
            !$codigo || !$resultado = $this->obraModel->withDeleted(true)
                ->where('id', $codigo)
                ->first()
        ) {
            return null;
        }
        return $resultado;
    }

    private function buscaRegistro404Serial(string $serial = null)
    {
        if (
            !$serial || !$resultado = $this->obraModel->withDeleted(true)
                ->where('serial', $serial)
                ->first()
        ) {
            return null;
        }

        return $resultado;

    }
}
