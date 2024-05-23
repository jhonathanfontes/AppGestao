<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class FinanceiroFormarPagamento extends Migration
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
            'for_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'for_forma' => [
                'type' => 'INT',
                'comment' => '1 - Dinheiro, 2 - Transferencia, 3 - Cartão Debito, 4 - Cartão Credito, 5 - Boleto, 6 - Credito Financeiro, 99 - Outros',
            ],
            'for_prazo' => [
                'type' => 'INT',
                'null' => true,
            ],
            'for_taxa' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'for_parcela' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
            'for_antecipa' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
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

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_cre_user_formapag');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_upd_user_formapag');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'CASCADE', 'fk_del_user_formapag');

        $this->forge->createTable('pdv_formapag', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('pdv_formapag');
    }
}
