<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class FinanceiroCaixa extends Migration
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
            'moeda_01' => [
                'type' => 'double',
                'default' => 0
            ],
            'moeda_05' => [
                'type' => 'double',
                'default' => 0
            ],
            'moeda_10' => [
                'type' => 'double',
                'default' => 0
            ],
            'moeda_25' => [
                'type' => 'double',
                'default' => 0
            ],
            'moeda_50' => [
                'type' => 'double',
                'default' => 0
            ],
            'moeda_1' => [
                'type' => 'double',
                'default' => 0
            ],
            'total_meda' => [
                'type' => 'double',
                'default' => 0
            ],
            'cedula_2' => [
                'type' => 'double',
                'default' => 0
            ],
            'cedula_5' => [
                'type' => 'double',
                'default' => 0
            ],
            'cedula_10' => [
                'type' => 'double',
                'default' => 0
            ],
            'cedula_20' => [
                'type' => 'double',
                'default' => 0
            ],
            'cedula_50' => [
                'type' => 'double',
                'default' => 0
            ],
            'cedula_100' => [
                'type' => 'double',
                'default' => 0
            ],
            'total_cedula' => [
                'type' => 'double',
                'default' => 0
            ],
            'total' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_moeda_01' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_moeda_05' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_moeda_10' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_moeda_25' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_moeda_50' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_moeda_1' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_total_meda' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_cedula_2' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_cedula_5' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_cedula_10' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_cedula_20' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_cedula_50' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_cedula_100' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_total_cedula' => [
                'type' => 'double',
                'default' => 0
            ],
            'f_total' => [
                'type' => 'double',
                'default' => 0
            ],
            'fec_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'Usuario fechamento do caixa',
            ],
            'fec_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'comment' => 'Data fechamento do caixa',
            ],
            'situacao' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 - Aberto, 2 - Fechado',
            ],
            'serial' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'comment' => 'CODIGO GERADO AUTOMATICAMENTO POR TRANSAÇÃO',
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
            'cai_logged' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'comment' => 'Nome da Maquina logada no caixa',
            ],
            'reabertura_data' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'reabertura_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'reabertura_motivo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('fec_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_fechamento_caixa');
        $this->forge->addForeignKey('reabertura_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_reabertura_caixa');

        $this->forge->addForeignKey('created_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_cre_user_caixa');
        $this->forge->addForeignKey('updated_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_upd_user_caixa');
        $this->forge->addForeignKey('deleted_user_id', 'cad_usuario', 'id', 'CASCADE', 'NO ACTION', 'fk_del_user_caixa');
       
        $this->forge->createTable('pdv_caixa', false, ['ENGINE' => 'InnoDB']);
    }
    public function down()
    {
        $this->forge->dropTable('pdv_caixa');
    }
}
