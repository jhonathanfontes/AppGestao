<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCampoObra extends Migration
{
    public function up()
    {
        $fields = [
            'serial' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'comment' => 'CODIGO GERADO AUTOMATICAMENTO POR TRANSAÇÃO',
                'after' => 'situacao'
            ]
        ];
        $this->forge->addColumn('ger_obra', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('ger_obra', 'serial');
    }
}
