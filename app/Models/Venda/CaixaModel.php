<?php

namespace App\Models\Venda;

use CodeIgniter\Model;

class CaixaModel extends Model
{

	protected $table = 'pdv_caixa';
	protected $primaryKey = 'id';
	protected $returnType = \App\Entities\Venda\Caixa::class;
	protected $useSoftDeletes = false;
	protected $allowedFields = [
		'created_user_id',
		'created_at',
		'total',
		'moeda_01',
		'moeda_05',
		'moeda_10',
		'moeda_25',
		'moeda_50',
		'moeda_1',
		'total_moeda',
		'cedula_2',
		'cedula_5',
		'cedula_10',
		'cedula_20',
		'cedula_50',
		'cedula_100',
		'total_cedula',

		'fec_user_id',
		'fec_at',
		'f_total',
		'f_moeda_01',
		'f_moeda_05',
		'f_moeda_10',
		'f_moeda_25',
		'f_moeda_50',
		'f_moeda_1',
		'f_total_meda',
		'f_cedula_2',
		'f_cedula_5',
		'f_cedula_10',
		'f_cedula_20',
		'f_cedula_50',
		'f_cedula_100',
		'f_total_cedula',
		
		'situacao',
		'serial',
		'cai_logged',
		'reabertura_use_id',
		'reabertura_data',
		'reabertura_motivo'
	];

	
	protected $beforeInsert = ['insertAuditoria'];
	protected $beforeUpdate = ['updateAuditoria'];

	protected function insertAuditoria(array $data)
	{
		$data['data']['created_user_id'] = getUsuarioID();
		$data['data']['created_at'] 	 = getDatetimeAtual();
		return $data;
	}

	protected function updateAuditoria(array $data)
	{
		$data['data']['updated_user_id'] = getUsuarioID();
		$data['data']['updated_at'] 	 = getDatetimeAtual();
		return $data;
	}

	public function getCaixas()
	{
		$response = $this->select('pdv_caixa.*, use_abertura.use_nome as use_abertura, use_fechamento.use_nome as use_fechamento')
			->join('cad_usuario as use_abertura', 'use_abertura.id = pdv_caixa.created_user_id', 'LEFT')
			->join('cad_usuario as use_fechamento', 'use_fechamento.id = pdv_caixa.fec_user_id', 'LEFT')
			->findAll();
		return $response;
	}

	public function returnSave(int $codigo = null)
	{
		return $this->select('id, serial')->find($codigo);
	}
}
