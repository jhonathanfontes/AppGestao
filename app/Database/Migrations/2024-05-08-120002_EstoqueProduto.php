<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EstoqueProduto extends Migration
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
            'pessoa_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'est_tipo' => [
                'type' => 'INT',
                'comment' => '1 - Entrada, 2 - Saida',
            ],
            'est_notafiscal' => [
                'type' => 'VARCHAR',
                'constraint' => '200'
            ],
            'est_data' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'est_valor' => [
                'type' => 'double',
                'default' => 0
            ],
            'est_qtn' => [
                'type' => 'INT',
                'default' => 0
            ],
            'est_custo' => [
                'type' => 'double',
                'default' => 0
            ],
            'est_desconto' => [
                'type' => 'double',
                'default' => 0
            ],
            'est_total' => [
                'type' => 'double',
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

        $this->forge->addForeignKey('pessoa_id', 'cad_pessoa', 'id', 'CASCADE', 'NO ACTION', 'fk_pessoa_estoque');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_estoque');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_estoque');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_estoque');
        $this->forge->addForeignKey('can_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_can_user_estoque');

        $this->forge->createTable('ger_estoque', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('ger_estoque');
    }
}
