<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCampoObersavacaoLocal extends Migration
{
    public function up()
    {
        $fields = [
            'loc_observacao' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'OBSERVAÇÕES SOBRE O SERVIÇO',
                'after' => 'loc_datainicio'
            ]
        ];
        $this->forge->addColumn('ger_local', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('ger_local', 'loc_observacao');
    }
}
