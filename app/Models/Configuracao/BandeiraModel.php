<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class BandeiraModel extends Model
{
    protected $table      = 'cad_bandeira';
    protected $primaryKey = 'id_bandeira';
    protected $returnType     = \App\Entities\Configuracao\Bandeira::class;
    protected $allowedFields = [
        'ban_descricao',
        'status',
		'created_user_id',
		'updated_user_id',
		'deleted_user_id'
    ];
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
        return $this->select('id_bandeira, ban_descricao')->find($codigo);
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
