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
            'emp_cep' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'emp_cidade' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'emp_uf' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'emp_endereco' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'emp_bairo' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'emp_complemento' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
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
            'status' => [
                'type' => 'INT',
                'comment' => '0 - Desativado, 1 - Habilitado, 9 - Arquivado',
            ],
            'permissao_id' => [
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
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('con_empresa', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('con_empresa');
    }
}
