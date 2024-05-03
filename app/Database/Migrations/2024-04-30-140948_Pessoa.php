<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Pessoa extends Migration
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
            'tipo_cliente' => [
                'type' => 'INT',
                'comment' => '1 - Cliente, 2 - Fonercedor, 3 - Cliente/Fonercedor',
            ],
            'pes_nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'pes_apelido' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'pes_cpf' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'pes_rg' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'pes_cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'pes_tiponatureza' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'comment' => 'F - PESSOA FISICA, J - PESSSAO JURIDICA',
            ],
            'pes_datanascimento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'pes_email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'pes_telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'pes_celular' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'pes_endereco' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => true,
            ],
            'pes_numero' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'pes_setor' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'pes_complemento' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'pes_cidade' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'pes_estado' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'pes_cep' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'pes_padrao' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => 'N',
            ],
            'status' => [
                'type' => 'INT',
                'default' => 1,
                'comment' => '1 -Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
            ],
            'profissao_id' => [
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cad_pessoa');
    }
    public function down()
    {
        $this->forge->dropTable('cad_pessoa');
    }
}
