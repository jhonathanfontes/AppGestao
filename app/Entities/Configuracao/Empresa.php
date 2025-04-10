<?php

namespace App\Entities\Configuracao;

use CodeIgniter\Entity\Entity;

class Empresa extends Entity
{
    protected $attributes = [
        'id' => null,
        'endereco_id' => null,
        'emp_razao' => null,
        'emp_fantasia' => null,
        'emp_slogan' => null,
        'emp_cnpj' => null,
        'emp_telefone' => null,
        'emp_email' => null,
        'media_preco' => null,
        'media_distancia' => null,
        'emp_icone' => null,
    ];

    protected $datamap = [
        'cod_empresa' => 'id',
        'cod_endereco' => 'endereco_id',
        'cad_razao' => 'emp_razao',
        'cad_fantasia' => 'emp_fantasia',
        'cad_slogan' => 'emp_slogan',
        'cad_cnpj' => 'emp_cnpj',
        'cad_telefone' => 'emp_telefone',
        'cad_email' => 'emp_email',
        'cad_mdpreco' => 'media_preco',
        'cad_mddistancia' => 'media_distancia',
        'cad_icone' => 'emp_icone'
    ];

    public function auditoriaUpdateAtributos()
    {
        $attribute = [];

        $attribute['cod_empresa'] = $this->id;

        if ($this->hasChanged('emp_razao')) {
            $attribute['cad_razao'] = [
                'old' => $this->original['emp_razao'],
                'new' => $this->emp_razao
            ];
        }

        if ($this->hasChanged('emp_fantasia')) {
            $attribute['cad_fantasia'] = [
                'old' => $this->original['emp_fantasia'],
                'new' => $this->emp_fantasia
            ];
        }

        if ($this->hasChanged('emp_slogan')) {
            $attribute['cad_slogan'] = [
                'old' => $this->original['emp_slogan'],
                'new' => $this->emp_slogan
            ];
        }

        if ($this->hasChanged('emp_cnpj')) {
            $attribute['cad_cnpj'] = [
                'old' => $this->original['emp_cnpj'],
                'new' => $this->emp_cnpj
            ];
        }

        if ($this->hasChanged('emp_telefone')) {
            $attribute['cad_telefone'] = [
                'old' => $this->original['emp_telefone'],
                'new' => $this->emp_slogan
            ];
        }

        if ($this->hasChanged('emp_email')) {
            $attribute['cad_email'] = [
                'old' => $this->original['emp_email'],
                'new' => $this->emp_email
            ];
        }

        if ($this->hasChanged('media_preco')) {
            $attribute['cad_mdpreco'] = [
                'old' => $this->original['media_preco'],
                'new' => $this->media_preco
            ];
        }

        if ($this->hasChanged('media_distancia')) {
            $attribute['cad_mddistancia'] = [
                'old' => $this->original['media_distancia'],
                'new' => $this->media_distancia
            ];
        }

        if ($this->hasChanged('emp_icone')) {
            $attribute['cad_icone'] = [
                'old' => $this->original['emp_icone'],
                'new' => $this->emp_icone
            ];
        }

        return serialize($attribute);
    }
}
