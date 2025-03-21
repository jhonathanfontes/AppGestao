<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaSalario extends Migration
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
            'colaborador_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'mes' => [
                'type' => 'INT',
                'constraint' => 2
            ],
            'ano' => [
                'type' => 'INT',
                'constraint' => 4
            ],
            'salario_base' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'adicional_noturno' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'horas_extras' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'bonus' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'descontos' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'vale_transporte' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'vale_refeicao' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'vale_alimentacao' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'plano_saude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'plano_odontologico' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'outros_descontos' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'outros_acrescimos' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'total_proventos' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'total_descontos' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'salario_liquido' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected', 'paid'],
                'default' => 'pending'
            ],
            'data_pagamento' => [
                'type' => 'DATE',
                'null' => true
            ],
            'observacao' => [
                'type' => 'TEXT',
                'null' => true
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
        $this->forge->addForeignKey('empresa_id', 'cad_empresa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('colaborador_id', 'cad_colaborador', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('cad_salario', true, ['engine' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cad_salario');
    }
} 