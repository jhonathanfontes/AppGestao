<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Start extends Seeder
{
    public function run()
    {
        $this->call('UsuarioSeeder');
        $this->call('GrupoSeeder');
        $this->call('SubGrupoSeeder');
    }
}
