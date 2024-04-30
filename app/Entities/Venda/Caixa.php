<?php

namespace App\Entities\Venda;

use CodeIgniter\Entity\Entity;

class Caixa extends Entity
{
    protected $datamap = [];
    protected $dates   = ['cai_abertura_data', 'cai_fechamento_data', 'reabertura_data'];
    protected $casts   = [];
}
