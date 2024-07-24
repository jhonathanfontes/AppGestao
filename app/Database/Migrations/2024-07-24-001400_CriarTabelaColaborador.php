<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CriarTabelaColaborador extends Migration
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
                'comment' => 'USUARIO SOLICITOU',
            ]
            ,
            'usuario_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'USUARIO SOLICITOU',
            ],
            'dt_admissao' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'dt_desligamento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'salario' => [
                'type' => 'double precision',
                'default' => 0
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Ativo, 2 - Inativo',
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
            ]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('pessoa_id', 'cad_pessoa', 'id', 'CASCADE', 'NO ACTION', 'fk_pessoa_colaborador');
        $this->forge->addForeignKey('usuario_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_usuario_colaborador');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_colaborador');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_colaborador');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_colaborador');

        $this->forge->createTable('cad_colaborador', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cad_colaborador');
    }
}
