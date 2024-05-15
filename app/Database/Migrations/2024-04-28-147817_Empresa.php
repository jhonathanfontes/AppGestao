<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Empresa extends Migration
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
            'emp_razao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'emp_fantasia' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'emp_slogan' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'emp_cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'emp_telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'emp_email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'emp_icone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'endereco_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'comment' => '0 - Desativado, 1 - Habilitado, 9 - Arquivado',
                'default' => 1,
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

        $this->forge->addForeignKey('endereco_id', 'cad_endereco', 'id', 'CASCADE', 'NO ACTION', 'fk_endereco_empresa');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_empresa');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_empresa');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_empresa');

        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('con_empresa', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('con_empresa');
    }
}
