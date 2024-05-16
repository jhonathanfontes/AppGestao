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
        'media_distancia',
        'status'
    ];

    function getEmpresa()
    {
        $atributos = [
            'con_empresa.*',
            'cad_endereco.id as cod_endereco',
            'end_endereco as cad_endereco',
            'end_numero as cad_numero',
            'end_setor as cad_setor',
            'end_complemento as cad_complemento',
            'end_cidade as cad_cidade',
            'end_estado as cad_estado',
            'end_cep as cad_cep',
        ];

        return $this->select($atributos)
            ->join('cad_endereco', 'cad_endereco.id = con_empresa.endereco_id', 'left');

    }
    
    public function returnSave(int $codigo = null)
    {
        return $this->select('id, emp_razao')->find($codigo);
    }
}
