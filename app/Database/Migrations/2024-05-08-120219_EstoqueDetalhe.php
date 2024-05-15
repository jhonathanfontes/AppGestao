<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EstoqueDetalhe extends Migration
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
            'estoque_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'orcamento_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'local_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'produto_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'del_tipo' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'comment' => 'E - Entrada, S - Saida',
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
            'val1_un' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'val1_unad' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'val1_total' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'val2_un' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'val2_unad' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'val2_total' => [
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

        $this->forge->addForeignKey('estoque_id', 'ger_estoque', 'id', 'CASCADE', 'NO ACTION', 'fk_estoque_movimentacao');
        $this->forge->addForeignKey('orcamento_id', 'pdv_orcamento', 'id', 'CASCADE', 'NO ACTION', 'fk_orcamento_movimentacao');
        $this->forge->addForeignKey('local_id', 'ger_local', 'id', 'CASCADE', 'NO ACTION', 'fk_local_movimentacao');
        $this->forge->addForeignKey('produto_id', 'cad_produto', 'id', 'CASCADE', 'NO ACTION', 'fk_produto_movimentacao');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_movimentacao');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_movimentacao');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_movimentacao');
        $this->forge->addForeignKey('can_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_can_user_movimentacao');

        $this->forge->createTable('est_movimentacao', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('est_movimentacao');
    }
}
