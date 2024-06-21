<?php

namespace App\Traits;

trait ProjetoTrait
{
    public function setLocalObra(int $cod_obra = null)
    {
        try {
            if ($cod_obra != null) {
                $model = new \App\Models\Projeto\LocalModel();

                $atributos = [
                    'id',
                    'obra_id',
                    'loc_descricao',
                    'loc_datainicio',
                    'status'
                ];

                return $model->select($atributos)->where('obra_id', $cod_obra)->findAll();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setObra(int $cod_obra = null, string $serial = null)
    {
        try {
            if ($cod_obra != null) {
                $model = new \App\Models\Projeto\ObraModel();
                return $model->getObra()
                    ->where('ger_obra.id', $cod_obra)
                    ->first();
                ;
            }
            if ($serial != null) {
                $model = new \App\Models\Projeto\ObraModel();
                return $model->getObra()
                    ->where('ger_obra.serial', $serial)
                    ->first();
                ;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setArrayObra(string $serial = null)
    {
        try {
            $obraModel = new \App\Models\Projeto\ObraModel();
            if ($serial != null) {
                $obra = $obraModel->withDeleted(true)->where('ger_obra.serial', $serial)->first();
                
                $localModel = new \App\Models\Projeto\LocalModel();

                $locais = $localModel->where('obra_id', $obra->cod_obra)->
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
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setLocal(int $cod_obra = null, int $cod_local = null)
    {
        try {
            if ($cod_obra != null) {
                $model = new \App\Models\Projeto\LocalModel();

                $atributos = [
                    'id',
                    'obra_id',
                    'loc_descricao',
                    'loc_datainicio',
                    'status'
                ];

                return $model->select($atributos)
                    ->where('obra_id', $cod_obra)
                    ->where('id', $cod_local)
                    ->first();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}