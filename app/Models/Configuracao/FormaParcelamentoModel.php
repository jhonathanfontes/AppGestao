<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class FormaParcelamentoModel extends Model
{
    protected $table      = 'pdv_formapac';
    protected $primaryKey = 'id_formapac';
    protected $returnType     = \App\Entities\Configuracao\FormaParcelamento::class;
    protected $allowedFields = [
        'forma_id',
        'bandeira_id',
        'fpc_parcela',
        'fpc_prazo',
        'fpc_taxa',
        'status',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
        'deleted_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert = ['insertAuditoria'];
    protected $beforeUpdate = ['updateAuditoria'];

    protected function insertAuditoria(array $data)
    {
        $data['data']['created_user_id'] = getUsuarioID();
        $data['data']['created_at']      = getDatetimeAtual();
        return $data;
    }

    protected function updateAuditoria(array $data)
    {
        $data['data']['updated_user_id'] = getUsuarioID();
        $data['data']['updated_at']      = getDatetimeAtual();
        return $data;
    }

    public function getFormaBandeiraParcela($codForma = null, $codBandeira = null, $codParcela = null)
    {
        $result = $this->where('forma_id', $codForma)
            ->where('bandeira_id', $codBandeira)
            ->where('fpc_parcela', $codParcela)
            ->first();
        return $result;
    }

    // public function getFormasParcelamentos()
    // {
    //     $atributos = [
    //         'id_forma',
    //         'for_descricao',
    //         'for_forma',
    //         'for_prazo',
    //         'for_taxa',
    //         'for_parcela',
    //         'conta_id',
    //         'pdv_formapag.status',
    //         'cad_contabancaria.con_descricao',
    //         'cad_contabancaria.con_agencia',
    //         'cad_contabancaria.con_conta',
    //         'cad_contabancaria.con_tipo'
    //     ];

    //     $result = $this->select($atributos)
    //         ->join('cad_contabancaria', 'cad_contabancaria.id_conta = pdv_formapag.conta_id', 'LEFT')
    //         ->whereIn('pdv_formapag.status', ['1', '2'])
    //         ->findAll();

    //     return $result;
    // }

    public function getFormasParcelamentos()
    {
        $atributos = [
            'pdv_formapac.id_formapac',
            'pdv_formapac.forma_id',
            'pdv_formapac.bandeira_id',
            'cad_bandeira.ban_descricao',
            'pdv_formapac.fpc_parcela',
            'pdv_formapac.fpc_prazo',
            'pdv_formapac.fpc_taxa',
            'pdv_formapac.status',
        ];
        $result = $this->select($atributos)
            ->join('cad_bandeira', 'cad_bandeira.id_bandeira = pdv_formapac.bandeira_id', 'LEFT');
        return $result;
    }

    public function getBandeiraPagamento($codigoPagamento = null)
    {
        $atributos = [
            'pdv_formapac.forma_id',
            'pdv_formapac.bandeira_id',
            'cad_bandeira.ban_descricao'
        ];
        $result = $this->distinct()
            ->select($atributos)
            ->join('cad_bandeira', 'cad_bandeira.id_bandeira = pdv_formapac.bandeira_id', 'LEFT')
            ->where('pdv_formapac.status', 1)
            ->where('pdv_formapac.forma_id', $codigoPagamento)
            ->findAll();
        return $result;
    }


    public function arquivarRegistro(int $codigo = null)
    {
        if ($codigo != null) {
            $data['status'] = 3;
            return $this->update($codigo, $data);
        }
        return false;
    }

    public function deletarRegistro(int $codigo = null)
    {
        if ($codigo != null) {
            $data['status'] = 0;
            $data['deleted_user_id'] = getUsuarioID();
            $data['deleted_at']      = getDatetimeAtual();
            return $this->update($codigo, $data);
        }
        return false;
    }
}
