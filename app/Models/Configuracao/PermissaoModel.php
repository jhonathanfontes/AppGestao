<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class PermissaoModel extends Model
{
    protected $table      = 'cad_permissao';
    protected $primaryKey = 'id_permissao';
    protected $returnType     = \App\Entities\Configuracao\Permissao::class;
    protected $allowedFields = ['per_descricao', 'created_user_id', 'updated_user_id', 'deleted_user_id'];
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

	public function returnSave(int $codigo = null)
	{
		return $this->select('id_permissao, per_descricao')->find($codigo);
	}

    public function getPermissoes()
    {
        # code...
    }

    public function getModulosPermissao($cod_permisao = null)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('con_modulo');
        $query = $builder->get();
        $i = 0;
        foreach ($query->getResult() as $row) {
            $return[$i] = array(
                'cod_modulo'      => $row->id_modulo,
                'cad_descricao'   => $row->mod_descricao
            );
            $return[$i] += $this->getAcessoPermitido($row->id_modulo, $cod_permisao);
            $i++;
        }
        return $return;
    }

    public function getModulos($cod_permisao = null)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('con_modulo');
        $query = $builder->getWhere('submodulo_id', null);
        $i = 0;
        foreach ($query->getResult() as $row) {
            $return[$i] = array(
                'cod_modulo'      => $row->id_modulo,
                'cad_descricao'   => $row->mod_descricao,
                'cad_permissao'   => $this->getAcessoPermitido($row->id_modulo, $cod_permisao)
            );
            $i++;
        }
        return $return;
    }

    public function getSubModulos($cod_permisao = null)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('con_modulo');
        $query = $builder->getWhere('submodulo_id', null);
        $i = 0;
        foreach ($query->getResult() as $row) {
            $return[$i] = array(
                'cod_modulo'      => $row->id_modulo,
                'cad_descricao'   => $row->mod_descricao,
                'cad_permissao'   => $this->getAcessoPermitido($row->id_modulo, $cod_permisao),
                'sub_modulo'      => $this->getSubModulo($row->id_modulo, $cod_permisao),
            );
            $i++;
        }
        return $return;
    }

    public function getAcessoPermitido($cod_modulo, $cod_permissao)
    {
        $db      = \Config\Database::connect();
        $array = ['permissao_id' => $cod_permissao, 'modulo_id' => $cod_modulo];
        $builder = $db->table('sys_acesso');
        $query = $builder->getWhere($array);
        if ($query->getResult()) {
            foreach ($query->getResult() as $row) {
                $return = array(
                    'per_acesso'    => $row->ace_permissao,
                    'per_editar'    => $row->ace_edit,
                    'per_deletar'   => $row->ace_delete
                );
            }
        } else {
            $return = array(
                'per_acesso'    => 'N',
                'per_editar'    => 'N',
                'per_deletar'   => 'N'
            );
        }
        return $return;
    }

    public function getPermissaoAdmin($cod_usuario)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('cad_permissao.id_permissao, cad_permissao.per_descricao');
        $builder->join('cad_usuario', 'cad_usuario.permissao_id = cad_permissao.id_permissao');
        $builder->where('cad_usuario.id_usuario', $cod_usuario);
        $builder->where('cad_permissao.per_admin', 'S');
        $return = $builder->get();
        return $return->getResult();
    }

    private function setMenuSysAcesso()
    {

        $data = [];
        $i = 0;
        $permissoes = $this->get();
        foreach ($permissoes->getResult() as $per) {
            $db      = \Config\Database::connect();
            $builder = $db->table('con_modulo');
            $modulo = $builder->get();
            foreach ($modulo->getResult() as $mod) {

                $array = ['permissao_id' => $per->id_permissao, 'modulo_id' => $mod->id_modulo];
                $builder_acesso = $db->table('sys_acesso');
                $query = $builder_acesso->getWhere($array);

                if ($query->getResult()) {

                    foreach ($query->getResult() as $row) {
                        $data = array(
                            'permissao_id'  => $per->id_permissao,
                            'modulo_id'     => $mod->id_modulo,
                            'ace_permissao' => $row->ace_permissao,
                            'ace_edit'      => $row->ace_edit,
                            'ace_delete'    => $row->ace_delete
                        );
                    }
                } else {
                    $data = array(
                        'permissao_id'  => $per->id_permissao,
                        'modulo_id'     => $mod->id_modulo,
                        'ace_permissao' => 'N',
                        'ace_edit'      => 'N',
                        'ace_delete'    => 'N'
                    );
                }
                // $builder_acesso->insert($data);
            }
        }
        return $data;
    }
    // Modulos Pai e Filho
    public function getSubModulo($cod_modulo = null, $cod_permissao = null)
    {
        $array = ['submodulo_id' => $cod_modulo];
        $db      = \Config\Database::connect();
        $builder = $db->table('con_modulo');
        $query = $builder->getWhere($array);
        $i = 0;
        if ($query->getResult()) {
            foreach ($query->getResult() as $row) {
                $return[$i] = array(
                    'cod_modulo'      => $row->id_modulo,
                    'cad_descricao'   => $row->mod_descricao,
                    'cad_permissao'   => $this->getAcessoPermitido($row->id_modulo, $cod_permissao)
                );
                $i++;
            }
            return $return;
        } else {
            return null;
        }
    }
}
