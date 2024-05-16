<?php

namespace App\Controllers\Api\v1;

use App\Controllers\Api\ApiController;

class Auditoria extends ApiController
{

    private $auditoriaModel;

    public function __construct()
    {
        $this->auditoriaModel = new \App\Models\AuditoriaModel();

    }

    public function exibir()
    {
        $resposta = [];

        $atributos = [
            'usuario_id',
            'aud_tabela',
            'aud_acao',
            'atributos',
            'created_at'
        ];

        $result = $this->auditoriaModel
            ->asArray()
            ->select($atributos)
            // ->where('','')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if ($result != null) {

            foreach ($result as $key => $aud) {

                $result[$key]['atributos'] = unserialize($aud['atributos']);
            }

            $resposta = $result;
        }

        return $resposta;
    }

}