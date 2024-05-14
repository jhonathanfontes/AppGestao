<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrcamentoVenda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'orc_tipoorcamento' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Venda, 2 - Retirada',
            ],
            'orc_tipopagamento' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - VALOR A VISTA, 2 - VALOR A PRAZO',
            ],
            'pessoa_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'vendedor_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'orc_dataorcamento' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'qtn_produto' => [
                'type' => 'INT',
                'default' => 0
            ],
            'qtn_devolvido' => [
                'type' => 'INT',
                'default' => 0
            ],
            'qtn_saldo' => [
                'type' => 'INT',
                'default' => 0
            ],
            'valor1_bruto' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'valor1_desconto' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'valor1_total' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'valor2_bruto' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'valor2_desconto' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'valor2_total' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'situacao' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '0 - Excluida, 1 - Em Aberto, 2 - Finalizada, 3 - Cancelada, 4 - Pendente',
            ],
            'serial' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'comment' => 'CODIGO GERADO AUTOMATICAMENTO POR TRANSAÇÃO',
            ],
            'agrupar_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'created_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'updated_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'deleted_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'can_data' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'can_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'can_motivo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('pessoa_id', 'cad_pessoa', 'id', 'CASCADE', 'NO ACTION', 'fk_pessoa_orcamento');
        $this->forge->addForeignKey('vendedor_id', 'cad_vendedor', 'id', 'CASCADE', 'NO ACTION', 'fk_vendedor_orcamento');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_orcamento');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_orcamento');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_orcamento');
        $this->forge->addForeignKey('can_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_can_user_orcamento');
       
        $this->forge->createTable('pdv_orcamento', false, ['ENGINE' => 'InnoDB']);
    }
    public function down()
    {
        $this->forge->dropTable('pdv_orcamento');
    }
}
