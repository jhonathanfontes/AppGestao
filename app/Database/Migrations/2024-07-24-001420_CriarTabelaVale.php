<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaVale extends Migration
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
            'colaborador_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'USUARIO SOLICITOU',
            ],
            'dt_solicitacao' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'valor' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'motivo_solicitacao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Solicitado, 2 - Aprovado, 3 - Cancelado, 4 - Reprovado',
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

        $this->forge->addForeignKey('colaborador_id', 'cad_colaborador', 'id', 'CASCADE', 'NO ACTION', 'fk_colaborador_vale');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_vale');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_vale');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_vale');
        $this->forge->addForeignKey('can_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_can_user_vale');

        $this->forge->createTable('fin_vale', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('fin_vale');
    }
}
