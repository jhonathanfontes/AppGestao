<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EnderecoTipo extends Migration
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
            'end_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 -Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
            ],
            'created_user_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_user_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'deleted_user_id' => [
                'type' => 'INT',
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('cad_enderecotipo', true,  ['ENGINE' => 'InnoDB']);
        
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_cre_user_enderecotipo');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_upd_user_enderecotipo');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_del_user_enderecotipo');
        
    }

    public function down()
    {
        $this->forge->dropTable('cad_enderecotipo');
    }
}
