<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaVale extends Migration
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
            'tipo' => [
                'type' => 'ENUM',
                'constraint' => ['alimentacao', 'transporte', 'outros']
            ],
            'valor' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'data_solicitacao' => [
                'type' => 'DATE'
            ],
            'data_pagamento' => [
                'type' => 'DATE',
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected', 'paid'],
                'default' => 'pending'
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

        $this->forge->createTable('cad_vale', true, ['engine' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cad_vale');
    }
} 