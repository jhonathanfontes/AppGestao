<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class VendedorCadastro extends Migration
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
            'usuario_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 -Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
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
        $this->forge->addForeignKey('pessoa_id', 'cad_pessoa', 'id', 'CASCADE', 'CASCADE', 'fk_pessoa_vendedor');
        $this->forge->addForeignKey('usuario_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_usuario_vendedor');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_cre_user_vendedor');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_upd_user_vendedor');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_del_user_vendedor');

        $this->forge->createTable('cad_vendedor', false, ['ENGINE' => 'InnoDB']);
    }
    public function down()
    {
        $this->forge->dropTable('cad_vendedor');
    }
}
