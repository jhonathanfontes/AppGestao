<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class AcessoModel extends Model
{
    protected $table      = 'sys_acesso';
    protected $primaryKey = ['permissao_id', 'modulo_id'];
    protected $returnType     = 'array';
    protected $allowedFields = ['permissao_id', 'modulo_id', 'ace_permissao', 'ace_edit', 'ace_delete'];

    public function verificaPermissao($grupo = null, $modulo = null)
    {
        return $this->where(['permissao_id' => $grupo, 'modulo_id' => $modulo])->first();
    }

    public function atualizaAcesso($grupo = null, $modulo = null, $metodo = null, $permissao = null)
    {
        $row = $this->verificaPermissao($grupo, $modulo);
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        if ($row) {
            $data = [$metodo => $permissao];
            return  $builder->update($data, ['permissao_id' => $grupo, 'modulo_id' => $modulo]);
        } else {
            $data = ['permissao_id' => $grupo, 'modulo_id' => $modulo, $metodo => $permissao];
            return $builder->insert($data);
        }
    }
}
