<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class ContaBancariaModel extends Model
{
    protected $table = 'cad_contabancaria';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\Configuracao\ContaBancaria::class;
    protected $allowedFields = [
        'id',
        'con_natureza',
        'banco_id',
        'con_descricao',
        'con_agencia',
        'con_conta',
        'con_tipoconta',
        'con_titular',
        'con_documento',
        'con_pagamento',
        'con_recebimento',
        'empresa_id',
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
        $data['data']['created_at'] = getDatetimeAtual();
        return $data;
    }

    protected function updateAuditoria(array $data)
    {
        $data['data']['updated_user_id'] = getUsuarioID();
        $data['data']['updated_at'] = getDatetimeAtual();
        return $data;
    }

    public function getContasBancaria()
    {
        $atributos = [
            'cad_contabancaria.*',
            'cad_banco.ban_codigo',
            'cad_banco.ban_descricao',
            'con_empresa.emp_razao'
        ];

        $result = $this->select($atributos)
            ->join('cad_banco', 'cad_banco.id = cad_contabancaria.banco_id', 'LEFT')
            ->join('con_empresa', 'con_empresa.id = cad_contabancaria.empresa_id', 'LEFT');

        return $result;
    }

    public function returnSave(int $codigo = null)
    {
        return $this->select('id, con_descricao')->find($codigo);
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
            $data['deleted_at'] = getDatetimeAtual();
            return $this->update($codigo, $data);
        }
        return false;
    }
}
