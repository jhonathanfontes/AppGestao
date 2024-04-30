<?php

namespace App\Models\Configuracao;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class ParcelaModel extends Model
{
    protected $table      = 'cad_parcela';
    protected $primaryKey = 'parcela';
    protected $returnType     = 'array';

    public function setParcelaSemBandeira(int $cod_forma = null, int $cod_bandeira = null)
    {
        $return = $this->select('parcela')
            ->whereNotIn('parcela', static fn (BaseBuilder $builder) => $builder->select('fpc_parcela')
                ->from('pdv_formapac')
                ->where('forma_id', $cod_forma)
                ->where('bandeira_id', $cod_bandeira))
            ->orderBy('parcela', 'ASC')
            ->findAll();
        return $return;
    }
}
