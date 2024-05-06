<?php

namespace App\Models;

use CodeIgniter\Model;

class EnderecoModel extends Model
{
    protected $table = 'cad_endereco';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\Endereco::class;
    protected $allowedFields = [
        'enderecotipo_id',
        'end_endereco',
        'end_numero',
        'end_setor',
        'end_complemento',
        'end_cidade',
        'end_estado',
        'end_cep',
        'status',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

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

}
