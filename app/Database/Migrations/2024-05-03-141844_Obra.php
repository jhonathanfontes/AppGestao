<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Obra extends Migration
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
            'obr_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'obr_datainicio' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'endereco_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 -Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
            ],
            'empresa_id' => [
                'type' => 'INT',
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ger_obra', true,  ['ENGINE' => 'InnoDB']);
        
        $this->forge->addKey('empresa_id', true);
        $this->forge->addKey('created_user_id', true);
        $this->forge->addKey('updated_user_id', true);
        $this->forge->addKey('deleted_user_id', true);
        
        $this->forge->addForeignKey('empresa_id', 'con_empresa', 'id', 'CASCADE', 'CASCADE', 'fk_empresa_obra');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_cre_user_obra');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_upd_user_obra');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_del_user_obra');

    }

    public function down()
    {
        $this->forge->dropTable('ger_obra');
    }
}
