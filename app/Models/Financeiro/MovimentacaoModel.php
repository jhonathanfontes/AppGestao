<?php

namespace App\Models\Financeiro;

use CodeIgniter\Model;

class MovimentacaoModel extends Model
{

	protected $table = 'fin_movimentacao';
	protected $primaryKey = 'codigo';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'caixa_id',
		'orcamento_id',
		'receber_id',
		'pagar_id',
		'folha_id',
		'credito_id',
		'forma_id',
		'pagamento_id',
		'mov_caixatipo',
		'mov_descricao',
		'conta_recebimento',
		'mov_formapagamento',
		'mov_es',
		'mov_parcela',
		'mov_parcela_total',
		'mov_valor',
		'mov_data',
		'mov_documento',
		'situacao',
		'concilia_banco',
		'concilia_data',
		'concilia_ad',
		'concilia_valor',
		'concilia_id',
		'concilia_documento',
		'serial',
		'created_user_id',
		'created_at',
		'deleted_status',
		'can_motivo',
		'can_usuario_id',
		'can_data'
	];

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
			$data['situacao'] = 3;
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
			$data['can_usuario_id'] = getUsuarioID();

			return $this->where('orcamento_id', $cod_orcamento)
				->where('serial', $serial)
				->where('situacao', 1)
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

	public function cancelarRegistro(int $codigo = null)
	{
		if ($codigo != null) {
			$data['situacao'] = 0;
			$data['can_motivo'] = 'PAGAMENTO DELETADO';
			$data['can_usuario_id'] = getUsuarioID();
			$data['can_data'] = getDatetimeAtual();
			return $this->update($codigo, $data);
		}
		return false;
	}
	public function getPagamentosContaPagar($serial, $codigo)
	{
		$atributos = [
			'fin_movimentacao.*',
			'cad_usuario.use_apelido as usuario'
		];
		$result = $this->select($atributos)
			->whereIn('situacao', [1, 2])
			->join('cad_usuario', 'cad_usuario.id_usuario = fin_movimentacao.created_user_id')
			->where('serial', $serial)
			->where('pagar_id', $codigo)
			->findAll();
		return $result;
	}

	public function getPagamentosContaReceber($serial, $codigo)
	{
		$atributos = [
			'fin_movimentacao.*',
			'cad_usuario.use_apelido as usuario'
		];
		$result = $this->select($atributos)
			->whereIn('situacao', [1, 2])
			->join('cad_usuario', 'cad_usuario.id_usuario = fin_movimentacao.created_user_id')
			->where('receber_id', $codigo)
			->where('serial', $serial)
			->findAll();
		return $result;
	}

	public function getMovimentacaoRetiradas()
	{
		$atributos = [
			'fin_movimentacao.caixa_id AS cod_caixa',
			'fin_movimentacao.orcamento_id AS cod_orcamento',
			'fin_movimentacao.mov_formapagamento AS formapagamento',
			'pdv_orcamento.venda_tipo AS venda_tipo',
			'pdv_retirada.id_retirada AS cod_retirada',
			'cad_pessoa.pes_nome AS pessoa',
			'if(fin_movimentacao.mov_formapagamento = 1,cast(coalesce(sum(fin_movimentacao.mov_valor),0) as decimal(9,2)),0) AS dinheiro',
			'if(fin_movimentacao.mov_formapagamento = 2,cast(coalesce(sum(fin_movimentacao.mov_valor),0) as decimal(9,2)),0) AS transferencia',
			'if(fin_movimentacao.mov_formapagamento = 3,cast(coalesce(sum(fin_movimentacao.mov_valor),0) as decimal(9,2)),0) AS debito',
			'if(fin_movimentacao.mov_formapagamento = 4,cast(coalesce(sum(fin_movimentacao.mov_valor),0) as decimal(9,2)),0) AS credito',
			'if(fin_movimentacao.mov_formapagamento = 6,cast(coalesce(sum(fin_movimentacao.mov_valor),0) as decimal(9,2)),0) AS creditofinanceiro',
			'0 AS boleto'
		];

		return $this->select($atributos)
			->join('pdv_caixa', 'pdv_caixa.id_caixa = fin_movimentacao.caixa_id', 'LEFT')
			->join('pdv_orcamento', 'pdv_orcamento.id_orcamento = fin_movimentacao.orcamento_id', 'LEFT')
			->join('pdv_retirada', 'pdv_retirada.orcamento_id = fin_movimentacao.orcamento_id', 'LEFT')
			->join('cad_pessoa', 'cad_pessoa.id_pessoa = pdv_orcamento.pessoa_id', 'LEFT')
			->where('pdv_orcamento.venda_tipo', 2)
			->where('fin_movimentacao.situacao', 2)
			->groupBy('fin_movimentacao.orcamento_id, fin_movimentacao.caixa_id');
	}

	public function getSuplementoSangriaCaixa()
	{
		$atributos = [
			'fin_movimentacao.id AS codigo',
			'fin_movimentacao.caixa_id AS cod_caixa',
			'fin_movimentacao.mov_data AS data',
			'fin_movimentacao.mov_caixatipo AS caixa_tipo',
			'fin_movimentacao.mov_descricao AS descricao',
			'if(fin_movimentacao.mov_caixatipo = 1,fin_movimentacao.mov_valor,NULL) AS supl_valor',
			'if(fin_movimentacao.mov_caixatipo = 2,fin_movimentacao.mov_valor,NULL) AS sang_valor',
			'fin_movimentacao.mov_documento AS documento',
			'fin_movimentacao.situacao AS situacao',
		];
		return $this->select($atributos)
			->where('fin_movimentacao.mov_caixatipo >=', 1)
			->where('fin_movimentacao.mov_caixatipo <=', 2)
			->where('fin_movimentacao.situacao', 2);
	}
}
