<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class LocalServicoProjeto extends Migration
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
            'local_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'produto_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'lsv_quantidade' => [
                'type' => 'INT',
                'null' => true,
            ],
            'lsv_valor' => [
                'type' => 'double precision',
                'null' => true,
            ], 
            'lsv_total' => [
                'type' => 'double precision',
                'null' => true,
            ],           
            'lsv_observacao' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'status' => [
                'type' => 'INT',
                'default' => 3,
                'comment' => '1 -Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
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
        ]);
        
        $this->forge->addPrimaryKey('id');
      
        $this->forge->addForeignKey('local_id', 'ger_local', 'id', 'CASCADE', 'NO ACTION', 'fk_local_localservico');
        $this->forge->addForeignKey('produto_id', 'cad_produto', 'id', 'CASCADE', 'NO ACTION', 'fk_produto_localservico');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_localservico');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_localservico');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_localservico');
        $this->forge->createTable('ger_localservico', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('ger_localservico');
    }
}
