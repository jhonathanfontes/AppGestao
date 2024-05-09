<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PagamentosFinanceiro extends Migration
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
            'caixa_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'orcamento_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'conta_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'forma_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'mov_caixatipo' => [
                'type' => 'INT',
                'null' => true,
                'comment' => '1 - Suplemento, 2 - Sangria, 3 - Venda, 4 - Pagamento, 5 - Deposito, 6 - Transferencia',
            ],
            'mov_caixaconcilia' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'N',
            ],
            'mov_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ],
            'mov_formapagamento' => [
                'type' => 'INT',
                'null' => true,
                'comment' => '1 - Dinheiro, 2 - Transferencia, 3 - Cartao Debito, 4 - Cartao Credito, 5 - Boleto, 6 - Credito Financeiro',
            ],
            'mov_es' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'null' => true,
                'comment' => 'E - Entrada no caixa, S - Saida do Caixa',
            ],
            'mov_parcela' => [
                'type' => 'INT',
                'null' => true,
            ],
            'mov_parcela_total' => [
                'type' => 'INT',
                'null' => true,
            ],
            'mov_valor' => [
                'type' => 'double',
                'default' => 0
            ],
            'mov_data' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'mov_documento' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'comment' => 'Documento que sera mostrado nos relatorios.',
            ],
            'situacao' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '0 - Excluida, 1 - Em Aberto, 2 - Finalizada, 3 - Cancelada, 4 - Pendente',
            ],
            'serial' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'comment' => 'CODIGO GERADO AUTOMATICAMENTO POR TRANSAÇÃO',
            ],
            'concilia_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'mov_conciliabanco' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'N',
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
            'can_data' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'can_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'can_motivo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('caixa_id', 'pdv_caixa', 'id', 'CASCADE', 'NO ACTION', 'fk_pessoa_finMovimentacao');
        $this->forge->addForeignKey('orcamento_id', 'pdv_orcamento', 'id', 'CASCADE', 'NO ACTION', 'fk_vendedor_finMovimentacao');
        $this->forge->addForeignKey('conta_id', 'fin_conta', 'id', 'CASCADE', 'NO ACTION', 'fk_conta_finMovimentacao');
        $this->forge->addForeignKey('forma_id', 'pdv_formapag', 'id', 'CASCADE', 'NO ACTION', 'fk_formapag_finMovimentacao');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_finMovimentacao');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_finMovimentacao');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_finMovimentacao');
        $this->forge->addForeignKey('can_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_can_user_finMovimentacao');

        $this->forge->createTable('fin_movimentacao', false, ['ENGINE' => 'InnoDB']);
    }
    public function down()
    {
        $this->forge->dropTable('fin_movimentacao');
    }
}
