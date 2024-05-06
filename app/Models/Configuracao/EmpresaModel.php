<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'con_empresa';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\Configuracao\Empresa::class;
    protected $allowedFields = [
        'endereco_id',
        'emp_razao',
        'emp_fantasia',
        'emp_slogan',
        'emp_cnpj',
        'emp_telefone',
        'emp_email',
        'emp_icone',
        'media_preco',
        'media_distancia'
    ];

    function getEmpresa($cod_empresa = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('con_empresa.*, cad_endereco.*');
        $builder->join('cad_endereco', 'cad_endereco.id = con_empresa.endereco_id');
        $builder->where('con_empresa.id', $cod_empresa);
        $result = $builder->get();
        return $result->getRow();
    }

    function getEmpresas()
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('con_empresa.*, cad_endereco.*');
        $builder->join('cad_endereco', 'cad_endereco.id = con_empresa.endereco_id');
        $builder->whereIn('con_empresa.status', ['1', '2']);
        $builder->orderBy('emp_razao', 'asc');
        $result = $builder->get();
        return $result->getResult();
    }

    public function returnSave(int $codigo = null)
    {
        return $this->select('id, emp_razao')->find($codigo);
    }
}
