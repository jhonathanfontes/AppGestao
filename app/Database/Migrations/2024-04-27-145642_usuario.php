<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Usuario extends Migration
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
            'use_nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'use_apelido' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'use_cpf' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'use_password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'use_email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'use_telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'use_avatar' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],'use_sexo' => [
                'type' => 'VARCHAR',
                'constraint' => '1',
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'default' => 3,
                'comment' => '1 - Habilitado, 2 - Desativado, 3 - Pendente, 9 - Arquivado',
            ],
            'permissao_id' => [
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
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type'    => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('cad_usuario', true,  ['ENGINE' => 'InnoDB']);
      
    }

    public function down()
    {
        $this->forge->dropTable('cad_usuario');
    }
}
