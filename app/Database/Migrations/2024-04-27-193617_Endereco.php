<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Endereco extends Migration
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
            'enderecotipo_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'end_endereco' => [
                'type' => 'VARCHAR',
                'constraint' => '80'
            ],
            'end_numero' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'end_setor' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'end_complemento' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'end_cidade' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'end_estado' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'end_cep' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
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
       
        $this->forge->addForeignKey('enderecotipo_id', 'cad_enderecotipo', 'id', 'CASCADE', 'NO ACTION', 'fk_empresa_endereco');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_endereco');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_endereco');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_endereco');

        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('cad_endereco', false, $attributes);
    }
    public function down()
    {
        $this->forge->dropTable('cad_endereco');
    }
}
