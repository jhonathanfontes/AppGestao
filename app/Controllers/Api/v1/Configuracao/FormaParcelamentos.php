<?php

namespace App\Controllers\Api\Configuracao;

use App\Controllers\Api\ApiController;
use CodeIgniter\Database\BaseBuilder;

class FormaParcelamentos extends ApiController
{
    private $formaParcelamentoModel;
    private $auditoriaModel;
    private $validation;

    public function __construct()
    {
        $this->formaParcelamentoModel = new \App\Models\Configuracao\FormaParcelamentoModel();
        $this->auditoriaModel = new \App\Models\AuditoriaModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getCarregaTabela()
    {
        $response = array();

        $cod_forma      = $this->request->getPost('cod_forma');
        $cod_bandeira   = $this->request->getPost('cod_bandeira');

        $result = $this->formaParcelamentoModel
            ->where('forma_id', $cod_forma)
            ->where('bandeira_id', $cod_bandeira)
            ->whereIn('status', ['1', '2'])
            ->withDeleted()
            ->orderBy('fpc_parcela', 'asc')
            ->findAll();

        foreach ($result as $key => $value) {

            $ops = '<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalFormaPagamento" onclick="getEditFormaPagamento(' . $value->cod_forma . ')"><samp class="far fa-edit"></samp> EDITAR</button>';
            $ops .= '<button type="button" class="btn btn-xs btn-dark ml-2" onclick="getArquivar(' . "'maquinacartao'" . ',' . $value->cod_forma . ')"><samp class="fa fa-archive"></samp> ARQUIVAR</button>';

            $response['data'][$key] = array(
                esc($value->fpc_parcela),
                esc($value->fpc_prazo),
                esc($value->fpc_taxa),
                convertStatus($value->status),
            );
        }

        return $this->response->setJSON($response);
    }

    public function addParcelaBandeira(int $cod_forma = null, int $cod_bandeira = null)
    {
        $parcelaModal = new \App\Models\Configuracao\ParcelaModel();
        $response = $parcelaModal->setParcelaSemBandeira($cod_forma, $cod_bandeira);
        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data['forma_id']       = $this->request->getPost('cod_forma');
        $data['bandeira_id']    = $this->request->getPost('cad_bandeira');
        $data['fpc_parcela']    = $this->request->getPost('cad_parcela');
        $data['fpc_prazo']      = $this->request->getPost('cad_prazo');
        $data['fpc_taxa']       = $this->request->getPost('cad_taxa');

        if (!empty($this->request->getPost('cod_maquinacartao'))) {
            $data['id_formapac'] = $this->request->getPost('cod_maquinacartao');
            $data['status']      = $this->request->getPost('status');

            $result = $this->buscaRegistro404($data['id_formapac']);
            $result->fill($data);

            if ($result->hasChanged() == false) {
                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'error',
                        'heading' => 'NÃO FOI POSSIVEL SALVAR O REGISTRO!',
                        'description' => "NÃO TEVE ALTERAÇÃO NA PARCELA $result->fpc_parcela PARA SALVAR!"
                    ]
                ]);
            }
            $this->auditoriaModel->insertAuditoria('configuracao', 'formaspagamentos', 'atualizar', $result->auditoriaAtributos());
        };

        try {
            if ($this->formaParcelamentoModel->save($data)) {
                return $this->response->setJSON([
                    'status' => true,
                    'data' => $data,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO SALVO COM SUCESSO!',
                        'description' => "A PARCELA FOI SALVAR!"
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

    public function findAll(int $cod_forma = null, int $cod_bandeira = null)
    {
        $return = $this->formaParcelamentoModel
            ->select('pdv_formapac.*, cad_bandeira.ban_descricao')
            ->join('cad_bandeira', 'cad_bandeira.id_bandeira = pdv_formapac.bandeira_id', 'LEFT')
            ->where('forma_id', $cod_forma)
            ->where('bandeira_id', $cod_bandeira)
            ->whereIn('pdv_formapac.status', ['1', '2'])
            ->withDeleted()
            ->orderBy('fpc_parcela', 'asc')
            ->findAll();

        return $this->response->setJSON($return);
    }

    public function show($paramentro)
    {
        $return = $this->formaParcelamentoModel->where('id_forma', $paramentro)
            ->first();
        return $this->response->setJSON($return);
    }

    public function arquivar($paramentro = null)
    {
        $categoria = $this->formaParcelamentoModel->where('id_forma', $paramentro)
            ->where('status <>', 0)
            ->where('status <>', 3)
            ->first();

        if ($categoria === null) {
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
            if ($this->formaParcelamentoModel->arquivarRegistro($paramentro)) {

                $this->auditoriaModel->insertAuditoria('configuracao', 'maquinacartao', 'arquivar', $categoria->auditoriaAtributos());

                return $this->response->setJSON([
                    'status' => true,
                    'menssagem' => [
                        'status' => 'success',
                        'heading' => 'REGISTRO ARQUIVADO COM SUCESSO!',
                        'description' => "A CATEGORIA $categoria->cad_maquinacartao FOI ARQUIVADA!"
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

    public function showFormaParcelamento($paramentro = null)
    {
        $return =
            $this->formaParcelamentoModel->getFormasParcelamentos()
            ->where('forma_id', $paramentro)
            ->findAll();
        return $this->response->setJSON($return);
    }

    private function buscaRegistro404(int $codigo = null)
    {
        if (!$codigo || !$resultado = $this->formaParcelamentoModel->withDeleted(true)->find($codigo)) {
            return null;
        }
        return $resultado;
    }
}
