<?php

namespace App\Traits;

trait ProjetoTrait
{
    public function setLocalObra(int $cod_obra = null)
    {
        try {
            if ($cod_obra != null) {
                $model = new \App\Models\Projeto\LocalModel();

                $atributos = [
                    'id',
                    'obra_id',
                    'loc_descricao',
                    'loc_datainicio',
                    'status'
                ];

                return $model->select($atributos)->where('obra_id', $cod_obra)->findAll();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function setObra(int $cod_obra = null, string $serial = null)
    {
        try {
            if ($cod_obra != null) {
                $model = new \App\Models\Projeto\ObraModel();
                return $model->getObra()
                    ->where('ger_obra.id', $cod_obra)
                    ->first();
                ;
            }
            if ($serial != null) {
                $model = new \App\Models\Projeto\ObraModel();
                return $model->getObra()
                    ->where('ger_obra.serial', $serial)
                    ->first();
                ;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
 
    public function setLocal(int $cod_obra = null, int $cod_local = null)
    {
        try {
            if ($cod_obra != null) {
                $model = new \App\Models\Projeto\LocalModel();

                $atributos = [
                    'id',
                    'obra_id',
                    'loc_descricao',
                    'loc_datainicio',
                    'status'
                ];

                return $model->select($atributos)
                    ->where('obra_id', $cod_obra)
                    ->where('id', $cod_local)
                    ->first();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}