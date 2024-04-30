<?php

namespace App\Models\Cadastro;

use CodeIgniter\Model;

class TamanhoModel extends Model
{
    protected $table      = 'cad_tamanho';
    protected $primaryKey = 'id_tamanho';
    protected $returnType = \App\Entities\Cadastro\Tamanho::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'tam_abreviacao',
        'tam_descricao',
        'tam_quantidade',
        'status'
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

    public function returnSave(int $codigo = null)
    {
        return $this->select('id_tamanho, tam_descricao')->find($codigo);
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
