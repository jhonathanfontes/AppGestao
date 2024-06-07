<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Procedure extends Seeder
{
    public function run()
    {
        $this->call('ProcedureAtualizaOrcamentoSeeder');
    }
}
