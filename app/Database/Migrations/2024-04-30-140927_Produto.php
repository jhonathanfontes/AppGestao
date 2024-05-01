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
                'constraint' => '1',
                'comment' => '1 - Produto, 2 - Serviço',
            ],
            'pro_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'pro_codigobarra' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tamanho_id' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'valor_custo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'valor_venda1' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'valor_venda2' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'estoque' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 -Habilitado, 2 - Desativado, 9 - Arquivado',
            ],
            'profissao_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_user_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_user_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'deleted_user_id' => [
                'type' => 'INT',
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
        $this->forge->createTable('cad_produto');
    }

    public function down()
    {
        $this->forge->dropTable('cad_produto');
    }
}
