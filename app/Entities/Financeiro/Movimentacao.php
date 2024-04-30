<?php

namespace App\Entities\Financeiro;

use CodeIgniter\Entity\Entity;

class Movimentacao extends Entity
{
    protected $datamap = [
        'caixa_id'          => 'cod_caixa',
        'orcamento_id'      => 'cod_orcamento',
        'receber_id'        => 'cod_receber',
        'pagar_id'          => 'cod_pagar',
        'folha_id'          => 'cod_folha',
        'credito_id'        => 'cod_credito',
        'forma_id'          => 'cod_forma',
        'mov_caixatipo'     => 'caixatipo',
        'mov_descricao'     => 'descricao',
        'conta_recebimento' => 'conta',
        'mov_formapagamento' => 'formapagamento',
        'mov_es'            => 'es',
        'mov_parcela'       => 'parcela',
        'mov_parcela_total' => 'parcela_total',
        'mov_valor'         => 'valor',
        'mov_data'          => 'data',
        'mov_documento'     => 'documento',
        'situacao'          => 'situacao',
        'concilia_banco'    => 'con_banco',
        'concilia_data'     => 'con_data',
        'concilia_ad'       => 'con_ad',
        'concilia_valor'    => 'con_valor',
        'concilia_id'       => 'cod_concilia',
        'serial'            => 'serial',
        'can_motivo'        => 'can_motivo',
        'can_usuario_id'    => 'can_cod_usuario',
        'can_data'          => 'can_data'
    ];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}
