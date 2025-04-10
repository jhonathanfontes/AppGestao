<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ProdutoTamanho extends Migration
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
            'tam_tipo' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Produto, 2 - Serviço',
            ],
            'tam_abreviacao' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
            'tam_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'tam_quantidade' => [
                'type' => 'INT',
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
        
        $this->forge->addForeignKey('empresa_id', 'con_empresa', 'id', 'CASCADE', 'CASCADE', 'fk_empresa_tamanho');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_cre_user_tamanho');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_upd_user_tamanho');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_del_user_tamanho');
        
        $this->forge->createTable('cad_tamanho', true,  ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cad_tamanho');
    }
}
