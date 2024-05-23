<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table      = 'pdv_formapag';
    protected $primaryKey = 'id';
    protected $returnType     = \App\Entities\Configuracao\FormaPagamento::class;
    protected $allowedFields = [
        'for_descricao',
        'for_forma',
        'for_prazo',
        'for_taxa',
        'for_parcela',
        'for_antecipa',
        'conta_id',
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

    public function returnSave(int $codigo = null)
    {
        return $this->select('id , for_descricao')->find($codigo);
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
