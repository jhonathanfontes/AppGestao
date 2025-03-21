<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaColaborador extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'empresa_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => 11
            ],
            'rg' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'data_nascimento' => [
                'type' => 'DATE'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'endereco' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'cidade' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'estado' => [
                'type' => 'VARCHAR',
                'constraint' => 2
            ],
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => 8
            ],
            'cargo' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'data_admissao' => [
                'type' => 'DATE'
            ],
            'salario_base' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ],
            'created_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'updated_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'deleted_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('cpf');
        $this->forge->addForeignKey('empresa_id', 'cad_empresa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('cad_colaborador', true, ['engine' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cad_colaborador');
    }
} 