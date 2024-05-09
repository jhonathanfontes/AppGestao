<?php

namespace App\Models\Financeiro;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class ContaModel extends Model
{
    protected $table = 'fin_conta';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\Financeiro\Conta::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'fin_tipoconta',
        'pessoa_id',
        'orcamento_id',
        'subgrupo_id',
        'forma_id',
        'fin_referencia',
        'fin_parcela',
        'fin_parcela_total',
        'fin_vencimento',
        'fin_observacao',
        'fin_valor',
        'fin_recebido',
        'fin_cancelado',
        'fin_saldo',
        'fin_quitado',
        'fin_documento',
        'situacao',
        'serial',
        'agrupar_id',
        'deleted_status',
        'can_data',
        'can_motivo',
        'can_user_id',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;

    protected $beforeInsert = ['insertAuditoria'];
    protected $beforeUpdate = ['updateAuditoria'];

    protected function insertAuditoria(array $data)
    {
        $data['data']['created_user_id'] = getUsuarioID();
        $data['data']['created_at'] = getDatetimeAtual();
        return $data;
    }

    protected function updateAuditoria(array $data)
    {
        $data['data']['updated_user_id'] = getUsuarioID();
        $data['data']['updated_at'] = getDatetimeAtual();
        return $data;
    }

    public function arquivarRegistro(int $codigo = null)
    {
        if ($codigo != null) {
            $data['situacao'] = 9;
            return $this->update($codigo, $data);
        }
        return false;
    }

    public function vendaToOrcamento(int $cod_orcamento = null, string $serial = null): bool
    {
        if ($cod_orcamento != null) {

            $data['situacao'] = 0;
            $data['deleted_status'] = 'A';
            $data['can_data'] = getDatetimeAtual();
            $data['can_motivo'] = 'CANCELAMENTO AUTOMATICO - VENDA RETORNADA PARA ORCAMENTO!';
            $data['can_user_id'] = getUsuarioID();

            return $this->where('orcamento_id', $cod_orcamento)
                ->where('serial', $serial)
                ->where('situacao', 1)
                ->set($data)
                ->update();
        }
        return false;
    }

    public function clienteReceberPDV(int $cod_orcamento = null, int $cod_cliente = null): bool
    {
        if ($cod_orcamento != null) {
            $data['pessoa_id'] = $cod_cliente;
            return $this->where('orcamento_id', $cod_orcamento)
                ->set($data)
                ->update();
        }
        return false;
    }

    public function finishVenda(int $cod_orcamento = null, string $serial = null): bool
    {
        if ($cod_orcamento != null) {

            $data['situacao'] = 2;

            return $this->where('orcamento_id', $cod_orcamento)
                ->where('serial', $serial)
                ->where('situacao', 1)
                ->set($data)
                ->update();
        }
        return false;
    }

    public function deletarRegistro(int $codigo = null)
    {
        if ($codigo != null) {
            $data['situacao'] = 0;
            $data['deleted_user_id'] = getUsuarioID();
            $data['deleted_at'] = getDatetimeAtual();
            return $this->update($codigo, $data);
        }
        return false;
    }

    public function getConta()
    {
        $attributes = [
            'fin_conta.id as cod_conta',
            'pessoa_id as cod_pessoa',
            'orcamento_id as cod_orcamento',
            'cad_pessoa.pes_nome as des_cliente',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'fin_referencia as referencia',
            'fin_parcela as parcela',
            'fin_parcela_total as parcela_total',
            'fin_vencimento as vencimento',
            'fin_observacao as observacao',
            'fin_valor as valor',
            'fin_recebido as recebido',
            'fin_cancelado as cancelado',
            'fin_saldo as saldo',
            'fin_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        $result = $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id = fin_conta.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id = fin_conta.subgrupo_id');

        return $result;
    }


    public function getContasByPessoa()
    {
        $attributes = [
            'CAST(SUM(fin_valor) AS DECIMAL(9,2)) AS valor',
            'CAST(SUM(fin_recebido) AS DECIMAL(9,2)) AS recebido',
            'CAST(SUM(fin_cancelado) AS DECIMAL(9,2)) AS cancelado',
            'CAST(SUM(fin_saldo) AS DECIMAL(9,2)) AS saldo',
            'CAST(SUM(IF(fin_vencimento < STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), fin_saldo, 0)) AS DECIMAL(9,2)) AS val_vencida',
            'SUM(IF(fin_vencimento < STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), 1, 0)) AS pac_vencida',
            'CAST(SUM(IF(fin_vencimento > STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), fin_saldo, 0)) AS DECIMAL(9,2)) AS val_pendente',
            'SUM(IF(fin_vencimento > STR_TO_DATE(CURRENT_DATE, "%Y-%m-%d"), 1, 0)) AS pac_pendente',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_cliente',
        ];

        $result = $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id = fin_conta.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id = fin_conta.subgrupo_id')
            ->whereIn('fin_conta.situacao', ['1', '2'])
            ->where('fin_conta.fin_quitado', 'N')
            ->groupBy('fin_conta.pessoa_id');

        return $result;
    }

    // ALTERAR APARTI DAQUI

    public function getContaReceberCliente($codPessoa = null)
    {

        $attributes = [
            'id_receber as cod_receber',
            'orcamento_id as cod_orcamento',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_cliente',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'rec_referencia as referencia',
            'rec_parcela as parcela',
            'rec_parcela_total as parcela_total',
            'rec_vencimento as vencimento',
            'rec_observacao as observacao',
            'rec_valor as valor',
            'rec_recebido as recebido',
            'rec_cancelado as cancelado',
            'rec_saldo as saldo',
            'rec_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        return $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_receber.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_receber.subgrupo_id')
            ->whereIn('fin_receber.situacao', ['1', '2'])
            ->where('fin_receber.rec_quitado', 'N')
            ->where('fin_receber.pessoa_id', $codPessoa)
            ->orderBy('fin_receber.rec_vencimento', 'ASC');
    }

    public function getContaReceberInCodigo($codReceber = null)
    {

        $attributes = [
            'id_receber as cod_receber',
            'orcamento_id as cod_orcamento',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_cliente',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'rec_referencia as referencia',
            'rec_parcela as parcela',
            'rec_parcela_total as parcela_total',
            'rec_vencimento as vencimento',
            'rec_observacao as observacao',
            'rec_valor as valor',
            'rec_recebido as recebido',
            'rec_cancelado as cancelado',
            'rec_saldo as saldo',
            'rec_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];


        return $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_receber.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_receber.subgrupo_id')
            ->whereIn('fin_receber.situacao', ['1', '2'])
            ->where('fin_receber.rec_quitado', 'N')
            ->whereIn('fin_receber.id_receber', $codReceber)
            ->orderBy('fin_receber.rec_vencimento', 'ASC')
            ->findAll();
    }
    public function getContasReceber()
    {
        $db = \Config\Database::connect();

        $attributes = [
            'id_receber as cod_receber',
            'orcamento_id as cod_orcamento',
            'pessoa_id as cod_pessoa',
            'cad_pessoa.pes_nome as des_cliente',
            'subgrupo_id as cod_subgrupo',
            'cad_subgrupo.sub_descricao as des_subgrupo',
            'rec_referencia as referencia',
            'rec_parcela as parcela',
            'rec_parcela_total as parcela_total',
            'rec_vencimento as vencimento',
            'rec_observacao as observacao',
            'rec_valor as valor',
            'rec_recebido as recebido',
            'rec_cancelado as cancelado',
            'rec_saldo as saldo',
            'rec_quitado as quitado',
            'situacao',
            'serial',
            'agrupar_id as cod_agrupar',
            'can_data',
            'can_motivo',
            'can_user_id'
        ];

        $builder = $db->table($this->table);
        $builder->select($attributes);
        $builder->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_receber.pessoa_id');
        $builder->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_receber.subgrupo_id');
        $builder->whereIn('fin_receber.situacao', ['1', '2']);
        $builder->where('fin_receber.rec_quitado', 'N');
        $result = $builder->get();

        return $result->getResult();
    }


    public function resumoReceberCaixa()
    {
        $db = \Config\Database::connect();

        $attributes = [
            'fin_receber.id_receber AS id_receber',
            'cad_pessoa.pes_nome AS cliente',
            'fin_movimentacao.caixa_id AS cod_caixa',
            'if(fin_movimentacao.mov_formapagamento = 1,sum(fin_movimentacao.mov_valor),0) AS dinheiro',
            'if(fin_movimentacao.mov_formapagamento = 2,sum(fin_movimentacao.mov_valor),0) AS transferencia',
            'if(fin_movimentacao.mov_formapagamento = 3,sum(fin_movimentacao.mov_valor),0) AS debito',
            'if(fin_movimentacao.mov_formapagamento = 4,sum(fin_movimentacao.mov_valor),0) AS credito',
            'if(fin_movimentacao.mov_formapagamento = 6,sum(fin_movimentacao.mov_valor),0) AS creditofinanceiro'
        ];

        $finReceber = $db->table('fin_receber')->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_receber.pessoa_id', 'LEFT')
            ->join('fin_movimentacao', 'fin_movimentacao.receber_id = fin_receber.id_receber', 'LEFT')
            ->where('fin_movimentacao.situacao', 2)
            ->groupBy('fin_receber.id_receber, fin_movimentacao.caixa_id, fin_movimentacao.mov_formapagamento');

        $attributes_alias = [
            'asReceber.id_receber AS id_receber',
            'asReceber.cliente AS cliente',
            'asReceber.cod_caixa AS cod_caixa',
            'sum(asReceber.dinheiro) AS dinheiro',
            'sum(asReceber.transferencia) AS transferencia',
            'sum(asReceber.debito) AS debito',
            'sum(asReceber.credito) AS credito',
            'sum(asReceber.creditofinanceiro) AS creditofinanceiro'
        ];

        return $db->newQuery()
            ->select($attributes_alias)
            ->fromSubquery($finReceber, 'asReceber')
            ->groupBy('asReceber.id_receber, asReceber.cliente, asReceber.cod_caixa');
    }

    public function agruparPorVencimento()
    {
        $db = \Config\Database::connect();

        $attributes = [
            'pessoa_id',
            'cad_pessoa.pes_nome',
            'rec_vencimento',
            'rec_valor',
            'rec_recebido',
            'rec_cancelado',
            'rec_saldo',
            'rec_quitado',
            'situacao',
            'serial'
        ];

        $builder = $db->table($this->table)
            ->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_receber.pessoa_id')
            ->whereIn('fin_receber.situacao', ['1', '2'])
            ->where('fin_receber.rec_quitado', 'N');

        // With closure
        $this->where('advance_amount <', static fn(BaseBuilder $builder) => $builder->select('MAX(advance_amount)', false)->from('orders')->where('id >', 2));
        // Produces: WHERE "advance_amount" < (SELECT MAX(advance_amount) FROM "orders" WHERE "id" > 2)

        // With builder directly
        $subQuery = $this->table('orders')->select('MAX(advance_amount)', false)->where('id >', 2);
        $this->where('advance_amount <', $subQuery);
    }

    public function getContaReceberCaixa($cod_orcamento = null)
    {
        $attributes = [
            'fin_receber.id_receber',
            'fin_receber.pessoa_id',
            'fin_receber.orcamento_id',
            'fin_receber.forma_id',
            'cad_pessoa.pes_nome',
            'subgrupo_id',
            'cad_subgrupo.sub_descricao',
            'fin_receber.rec_referencia',
            'fin_receber.rec_parcela',
            'fin_receber.rec_parcela_total',
            'fin_receber.rec_vencimento',
            'fin_receber.rec_observacao',
            'fin_receber.rec_valor',
            'fin_receber.rec_recebido',
            'fin_receber.rec_cancelado',
            'fin_receber.rec_saldo',
            'fin_receber.rec_quitado',
            'fin_receber.situacao',
            'fin_receber.serial',
            'fin_receber.agrupar_id',
            'fin_receber.can_data',
            'fin_receber.can_motivo',
            'fin_receber.can_user_id'
        ];

        return $this->select($attributes)
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = fin_receber.pessoa_id')
            ->join('cad_subgrupo', 'cad_subgrupo.id_subgrupo = fin_receber.subgrupo_id')
            ->orGroupStart()
            ->whereIn('fin_receber.situacao', ['1', '2'])
            ->orWhere('fin_receber.situacao', 5)
            ->groupEnd()
            ->where('orcamento_id', $cod_orcamento)
            ->get()
            ->getResult();
    }
}
