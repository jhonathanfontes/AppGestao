<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ContaFinanceiro extends Migration
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
            'fin_tipoconta' => [
                'type' => 'INT',
                'comment' => '1 - Conta a Receber, 2 - Conta a Pagar',
            ],
            'pessoa_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'orcamento_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'subgrupo_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'forma_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'fin_referencia' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'fin_parcela' => [
                'type' => 'INT',
                'null' => true,
            ],
            'fin_parcela_total' => [
                'type' => 'INT',
                'null' => true,
            ],
            'fin_vencimento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'fin_observacao' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'fin_valor' => [
                'type' => 'double precision',
                'null' => true,
            ],
            'fin_recebido' => [
                'type' => 'double precision',
                'null' => true,
            ],
            'fin_cancelado' => [
                'type' => 'double precision',
                'null' => true,
            ],
            'fin_saldo' => [
                'type' => 'double precision',
                'null' => true,
            ],
            'fin_quitado' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'N',
            ],
            'fin_documento' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
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
            'agrupar_id' => [
                'type' => 'INT',
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

        $this->forge->addForeignKey('pessoa_id', 'cad_pessoa', 'id', 'CASCADE', 'NO ACTION', 'fk_pessoa_conta');
        $this->forge->addForeignKey('orcamento_id', 'pdv_orcamento', 'id', 'CASCADE', 'NO ACTION', 'fk_orcamento_conta');
        $this->forge->addForeignKey('subgrupo_id', 'cad_subgrupo', 'id', 'CASCADE', 'NO ACTION', 'fk_subgrupo_conta');
        $this->forge->addForeignKey('forma_id', 'pdv_formapag', 'id', 'CASCADE', 'NO ACTION', 'fk_formapag_conta');
      
       // $this->forge->addForeignKey('agrupar_id', 'fin_conta', 'id', 'CASCADE', 'NO ACTION', 'fk_fin_conta_conta');
        
        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_conta');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_conta');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_conta');
        $this->forge->addForeignKey('can_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_can_user_conta');
       
        $this->forge->createTable('fin_conta', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('fin_conta');
    }
}
