<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Trigger extends Seeder
{
    public function run()
    {
        $this->call('TriggerAtualizaOrcamentoSeeder');
    }
}
