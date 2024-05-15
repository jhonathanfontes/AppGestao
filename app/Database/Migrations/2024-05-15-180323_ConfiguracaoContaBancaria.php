<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ConfiguracaoContaBancaria extends Migration
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
            'con_natureza' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'comment' => '1 - JURIDICA, 2 - FISICA',
            ],
            'banco_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'con_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'con_agencia' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'con_conta' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'con_tipoconta' => [
                'type' => 'INT',
                'constraint' => '1',
                'null' => true,
                'comment' => '1 - Corrente, 2 - Poupança',
            ],
            'con_titular' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'con_documento' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'con_pagamento' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'con_recebimento' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'empresa_id' => [
                'type' => 'INT',
                'unsigned' => true,
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
        $this->forge->addKey('con_descricao', false, true);

        $this->forge->addForeignKey('banco_id', 'cad_banco', 'id', 'CASCADE', 'CASCADE', 'fk_banco_contabancaria');
        $this->forge->addForeignKey('empresa_id', 'con_empresa', 'id', 'CASCADE', 'CASCADE', 'fk_empresa_contabancaria');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_cre_user_contabancaria');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_upd_user_contabancaria');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_del_user_contabancaria');

        $this->forge->createTable('cad_contabancaria', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cad_contabancaria');
    }
}
