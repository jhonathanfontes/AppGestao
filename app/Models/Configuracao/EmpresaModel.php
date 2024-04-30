<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'con_empresa';
    protected $primaryKey = 'id';
    protected $returnType     = \App\Entities\Configuracao\Empresa::class;
    protected $allowedFields = [
        'emp_razao',
        'emp_fantasia',
        'emp_slogan',
        'emp_cnpj',
        'emp_cep',
        'emp_cidade',
        'emp_uf',
        'emp_endereco',
        'emp_bairo',
        'emp_complemento',
        'emp_telefone',
        'emp_email',
        'emp_icone',
        'media_preco',
        'media_distancia'
    ];

    public function returnSave(int $codigo = null)
    {
        return $this->select('id, emp_razao')->find($codigo);
    }
}
