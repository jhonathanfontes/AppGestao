<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SubGrupoFinanceiro extends Migration
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
            'sub_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'grupo_id' => [
                'type' => 'INT',
            ],
            'gru_tipo' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
            ],
            'gru_classificacao' => [
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
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('cad_subgrupo', true, $attributes);
        $this->forge->addForeignKey('grupo_id', 'cad_grupo', 'id', 'CASCADE', 'CASCADE', 'fk_grupo_subgrupo');
    }

    public function down()
    {
        $this->forge->dropTable('cad_subgrupo');
    }
}
