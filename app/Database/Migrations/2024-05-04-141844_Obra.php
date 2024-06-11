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
            'pessoa_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
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
                'unsigned' => true,
                'null' => true,
            ],
            'situacao' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '0 - Excluida, 1 - Em Aberto, 2 - Finalizada, 3 - Cancelada, 4 - Pendente, 5 - Obra Pendente',
            ],
            'empresa_id' => [
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
        ]);
        
        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('pessoa_id', 'cad_pessoa', 'id', 'CASCADE', 'NO ACTION', 'fk_pessoa_obra');
        $this->forge->addForeignKey('endereco_id', 'cad_endereco', 'id', 'CASCADE', 'NO ACTION', 'fk_endereco_obra');
        $this->forge->addForeignKey('empresa_id', 'con_empresa', 'id', 'CASCADE', 'NO ACTION', 'fk_empresa_obra');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_obra');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_obra');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_obra');
      
        $this->forge->createTable('ger_obra', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('ger_obra');
    }
}
