<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EnderecoTipo extends Migration
{

    public function up()
    {

        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'end_descricao' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
            'CONSTRAINT `pk_cad_enderecotipo` PRIMARY KEY(`id`)',
            'CONSTRAINT `fk_empresa_enderecotipo` FOREIGN KEY (`empresa_id`) REFERENCES `con_empresa`(`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'CONSTRAINT `fk_cre_user_enderecotipo` FOREIGN KEY (`created_user_id`) REFERENCES `cad_usuario`(`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'CONSTRAINT `fk_upd_user_enderecotipo` FOREIGN KEY (`updated_user_id`) REFERENCES `cad_usuario`(`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'CONSTRAINT `fk_del_user_enderecotipo` FOREIGN KEY (`deleted_user_id`) REFERENCES `cad_usuario`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        ];
        $this->forge->createTable('cad_enderecotipo');

    }

      public function down()
    {
        $this->forge->dropForeignKey('con_empresa','fk_empresa_enderecotipo');
        $this->forge->dropForeignKey('cad_usuario','fk_cre_user_enderecotipo');
        $this->forge->dropForeignKey('cad_usuario','fk_upd_user_enderecotipo');
        $this->forge->dropForeignKey('cad_usuario','fk_del_user_enderecotipo');
        $this->forge->dropTable('cad_enderecotipo');
    }
}
