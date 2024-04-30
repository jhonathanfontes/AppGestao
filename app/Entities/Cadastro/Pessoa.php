<?php

namespace App\Entities\Cadastro;

use CodeIgniter\Entity\Entity;

class Pessoa extends Entity
{
    protected $datamap = [
        'cod_pessoa'        => 'id_pessoa',
        'cad_tipopessoa'    => 'tipo_cliente',
        'cad_natureza'      => 'pes_tiponatureza',
        'cad_cpf'           => 'pes_cpf',
        'cad_cnpj'          => 'pes_cnpj',
        'cad_nascimeto'     => 'pes_datanascimento',
        'cad_rg'            => 'pes_rg',
        'cad_nome'          => 'pes_nome',
        'cad_apelido'       => 'pes_apelido',
        'cad_cep'           => 'pes_cep',
        'cad_endereco'      => 'pes_endereco',
        'cad_numero'        => 'pes_numero',
        'cad_setor'         => 'pes_setor',
        'cad_cidade'        => 'pes_cidade',
        'cad_estado'        => 'pes_estado',
        'cad_complemento'   => 'pes_complemento',
        'cad_telefone'      => 'pes_telefone',
        'cad_celular'       => 'pes_celular',
        'cad_email'         => 'pes_email',
        'cod_dadosbancarios' => 'dadosbancarios_id',
        'cod_profissao'     => 'profissao_id',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
