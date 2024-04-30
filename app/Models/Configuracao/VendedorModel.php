<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class VendedorModel extends Model
{
    protected $table      = 'cad_vendedor';
    protected $primaryKey = 'id_vendedor';
    protected $returnType     = \App\Entities\Configuracao\Vendedor::class;
    protected $allowedFields = [
        'usuario_id',
        'pessoa_id',
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

    public function getVendedor()
    {
        $atributos = [
            'cad_vendedor.id_vendedor',
            'cad_vendedor.usuario_id',
            'cad_usuario.use_username as use_username',
            'cad_usuario.use_apelido as use_apelido',
            'cad_vendedor.pessoa_id',
            'cad_pessoa.pes_nome as pessoa',
            'cad_pessoa.pes_celular as celular',
            'cad_vendedor.status'
        ];

        return $this->select($atributos)
            ->join('cad_usuario', 'cad_usuario.id_usuario = cad_vendedor.usuario_id', 'LEFT')
            ->join('cad_pessoa', 'cad_pessoa.id_pessoa = cad_vendedor.pessoa_id', 'LEFT');
    }

    public function getVendedorLogado()
    {
        return $this->select('id_vendedor')->where('usuario_id', getUsuarioID())->first();
    }

    public function returnSave(int $codigo = null)
    {
        return $this->getVendedor()->find($codigo);
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
