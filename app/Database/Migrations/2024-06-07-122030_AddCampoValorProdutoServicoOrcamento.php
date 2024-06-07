<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCampoValorProdutoServicoOrcamento extends Migration
{
    public function up()
    {
        $fields = [
            'valor1_servicos' => [
                'type' => 'double precision',
                'default' => 0,
                'after' => 'qtn_saldo'
            ],
            'valor1_produtos' => [
                'type' => 'double precision',
                'default' => 0,
                'after' => 'qtn_saldo'
            ],
            'valor2_servicos' => [
                'type' => 'double precision',
                'default' => 0,
                'after' => 'valor1_total'
            ],
            'valor2_produtos' => [
                'type' => 'double precision',
                'default' => 0,
                'after' => 'valor1_total'
            ]
        ];
        $this->forge->addColumn('pdv_orcamento', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pdv_orcamento', 'valor1_servicos');
        $this->forge->dropColumn('pdv_orcamento', 'valor1_produtos');
        $this->forge->dropColumn('pdv_orcamento', 'valor2_servicos');
        $this->forge->dropColumn('pdv_orcamento', 'valor2_produtos');
    }
}
