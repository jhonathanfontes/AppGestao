<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'use_nome' => 'Administrador',
            'use_apelido' => 'Administrador',
            'use_cpf' => '00000000000',
            'use_password' => password_hash('admin', PASSWORD_DEFAULT),
            'use_email' => 'admin@example.com',
            'use_telefone' => '00000000000',
            'use_avatar' => '',
            'use_sexo' => 'M',
            'status' => 1
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO cad_usuario (use_nome, use_apelido, use_cpf, use_password, use_email, use_apelido, use_telefone, use_avatar, status) VALUES (:use_nome:, :use_apelido:, :use_cpf:, :use_password:, :use_email:, :use_apelido:, :use_telefone:, :use_avatar:, :status:)', $data);

        // Using Query Builder
        $this->db->table('cad_usuario')->insert($data);

    }
}
