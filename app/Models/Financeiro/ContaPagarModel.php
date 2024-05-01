<?php

namespace App\Models\Financeiro;

use CodeIgniter\Model;

class ContaPagarModel extends Model
{
    protected $table      = 'fin_pagar';
    protected $primaryKey = 'id_pagar';
    protected $returnType = \App\Entities\Financeiro\ContaPagar::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'pessoa_id',
        'subgrupo_id',
        'pag_referencia',
        'pag_parcela',
        'pag_parcela_total',
        'pag_vencimento',
        'pag_observacao',
        'pag_valor',
        'pag_recebido',
        'pag_cancelado',
        'pag_saldo',
        'pag_quitado',
        'situacao',
        'serial',
        'agrupar_id',
        'can_data',
        'can_motivo',
        'can_user_id',
        'fleg'
    ];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

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

    public function arquivarRegistro(int $codigo = null)
    {
        if ($codigo != null) {
            $data['situacao'] = 3;
            return $this->update($codigo, $data);
        }
        return false;
    }

    public function deletarRegistro(int $codigo = null)
    {
        if ($codigo != null) {
            $data['situacao'] = 0;
            $data['deleted_user_id'] = getUsuarioID();
            $data['deleted_at']      = getDatetimeAtual();
            return $this->update($codigo, $data);
        }
        return false;
    }

    public function getContaPagar($codigo = null)
    {
        $db      = \Config\Database::connect();

        $attributes = [
            'id_pagar as cod_pagar',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_fornecedor',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'pag_referencia as referencia',
            'pag_parcela as parcela',
            'pag_parcela_total as parcela_total',
            'pag_vencimento as vencimento',
            'pag_observacao as observacao',
            'pag_valor as valor',
            'pag_recebido as recebido',
            'pag_cancelado as cancelado',
            'pag_saldo as saldo',
            'pag_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        $builder = $db->table($this->table);
        $builder->select($attributes);
        $builder->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_pagar.pessoa_id');
        $builder->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_pagar.subgrupo_id');
        $builder->whereIn('fin_pagar.situacao', ['1', '2']);
        $builder->where('fin_pagar.id_pagar', $codigo);
        $result = $builder->get();

        return $result->getRow();
    }

    public function getContasPagar()
    {
        $db      = \Config\Database::connect();

        $attributes = [
            'id_pagar as cod_pagar',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_fornecedor',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'pag_referencia as referencia',
            'pag_parcela as parcela',
            'pag_parcela_total as parcela_total',
            'pag_vencimento as vencimento',
            'pag_observacao as observacao',
            'pag_valor as valor',
            'pag_recebido as recebido',
            'pag_cancelado as cancelado',
            'pag_saldo as saldo',
            'pag_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        $builder = $db->table($this->table);
        $builder->select($attributes);
        $builder->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_pagar.pessoa_id');
        $builder->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_pagar.subgrupo_id');
        $builder->whereIn('fin_pagar.situacao', ['1', '2']);
        $builder->where('fin_pagar.pag_quitado', 'N');
        $result = $builder->get();

        return $result->getResult();
    }

    public function getContasPagarByFornecedor()
    {
        $attributes = [
            'CAST(SUM(pag_valor) AS DECIMAL(9,2)) AS pag_valor',
            'CAST(SUM(pag_recebido) AS DECIMAL(9,2)) AS pag_recebido',
            'CAST(SUM(pag_cancelado) AS DECIMAL(9,2)) AS pag_cancelado',
            'CAST(SUM(pag_saldo) AS DECIMAL(9,2)) AS pag_saldo',
            'CAST(SUM(IF(pag_vencimento < STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), pag_saldo, 0)) AS DECIMAL(9,2)) AS val_vencida',
            'SUM(IF(pag_vencimento < STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), 1, 0)) AS pac_vencida',
            'CAST(SUM(IF(pag_vencimento > STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), pag_saldo, 0)) AS DECIMAL(9,2)) AS val_pendente',
            'SUM(IF(pag_vencimento > STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), 1, 0)) AS pac_pendente',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_cliente',
        ];

        return $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_pagar.pessoa_id')
            ->whereIn('fin_pagar.situacao', ['1', '2'])
            ->where('fin_pagar.pag_quitado', 'N')
            ->groupBy('fin_pagar.pessoa_id');
    }

    public function getContaPagarFornecedor($codPessoa = null)
    {

        $attributes = [
            'id_pagar as cod_pagar',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_fornecedor',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'pag_referencia as referencia',
            'pag_parcela as parcela',
            'pag_parcela_total as parcela_total',
            'pag_vencimento as vencimento',
            'pag_observacao as observacao',
            'pag_valor as valor',
            'pag_recebido as recebido',
            'pag_cancelado as cancelado',
            'pag_saldo as saldo',
            'pag_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        return $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_pagar.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_pagar.subgrupo_id')
            ->whereIn('fin_pagar.situacao', ['1', '2'])
            ->where('fin_pagar.pag_quitado', 'N')
            ->where('fin_pagar.pessoa_id', $codPessoa)
            ->orderBy('fin_pagar.pag_vencimento');
    }

    public function getContaPagarInCodigo($codPagar = null)
    {

        $attributes = [
            'id_pagar as cod_pagar',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_fornecedor',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'pag_referencia as referencia',
            'pag_parcela as parcela',
            'pag_parcela_total as parcela_total',
            'pag_vencimento as vencimento',
            'pag_observacao as observacao',
            'pag_valor as valor',
            'pag_recebido as recebido',
            'pag_cancelado as cancelado',
            'pag_saldo as saldo',
            'pag_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        return $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_pagar.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_pagar.subgrupo_id')
            ->whereIn('fin_pagar.situacao', ['1', '2'])
            ->where('fin_pagar.pag_quitado', 'N')
            ->whereIn('fin_pagar.id_pagar', $codPagar)
            ->orderBy('fin_pagar.pag_vencimento')
            ->findAll();
    }

    public function resumoPagamentoCaixa()
    {
        $db      = \Config\Database::connect();

        $attributes = [
            'fin_pagar.id_pagar AS cod_pagar',
            'fin_pagar.pessoa_id AS cod_cliente',
            'cad_pessoa.pes_nome AS cliente',
            'fin_movimentacao.caixa_id AS cod_caixa',
            'if(fin_movimentacao.mov_formapagamento = 1, CAST(COALESCE(SUM(fin_movimentacao.mov_valor), 0) AS DECIMAL(9,2)), 0) AS dinheiro',
            'if(fin_movimentacao.mov_formapagamento = 2, CAST(COALESCE(SUM(fin_movimentacao.mov_valor), 0) AS DECIMAL(9,2)), 0) AS transferencia'
        ];

        $finPagar = $db->table('fin_pagar')
            ->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_pagar.pessoa_id', 'left')
            ->join('fin_movimentacao', 'fin_movimentacao.pagar_id = fin_pagar.id_pagar', 'left')
            ->where('fin_movimentacao.situacao', 2)
            ->groupBy('fin_pagar.id_pagar, fin_movimentacao.caixa_id, fin_movimentacao.mov_formapagamento');

        $attributes_alias = [
            'cod_pagar',
            'cliente',
            'cod_caixa'
        ];

        return $db->newQuery()
            ->select($attributes_alias)
            ->selectSum('dinheiro')
            ->selectSum('transferencia')
            ->fromSubquery($finPagar, 'asPagar')
            ->groupBy('asPagar.cod_cliente');
    }
}
