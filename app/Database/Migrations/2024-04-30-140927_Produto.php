<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Produto extends Migration
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
            'pro_tipo' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Produto, 2 - Serviço',
            ],
            'pro_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'categoria_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'pro_codigobarra' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tamanho_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'valor_custo' => [
                'type' => 'double',
                'null' => true,
            ],
            'valor_venda1' => [
                'type' => 'double',
                'null' => true,
            ],
            'valor_venda2' => [
                'type' => 'double',
                'null' => true,
            ],
            'estoque' => [
                'type' => 'INT',
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 -Habilitado, 2 - Desativado, 9 - Arquivado',
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

        $this->forge->addForeignKey('categoria_id', 'cad_categoria', 'id', 'CASCADE', 'NO ACTION', 'fk_categoria_produto');
        $this->forge->addForeignKey('tamanho_id', 'cad_tamanho', 'id', 'CASCADE', 'NO ACTION', 'fk_tamanho_produto');
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_produto');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_produto');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_produto');

        $this->forge->createTable('cad_produto', false, ['ENGINE' => 'InnoDB']);
 
    }

    public function down()
    {
        $this->forge->dropTable('cad_produto');
    }
}
