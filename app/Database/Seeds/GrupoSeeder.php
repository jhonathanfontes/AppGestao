<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GrupoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'gru_descricao' => 'DESPESAS ADMINISTRATIVAS',
                'gru_tipo' => 'D',
                'gru_classificacao' => 1,
                'status' => 1,
            ],
            [
                'id' => 2,
                'gru_descricao' => 'DESPESAS FINANCEIRAS',
                'gru_tipo' => 'D',
                'gru_classificacao' => 3,
                'status' => 1,
            ],
            [
                'id' => 3,
                'gru_descricao' => 'DESPESAS COM VENDAS',
                'gru_tipo' => 'D',
                'gru_classificacao' => 2,
                'status' => 1,
            ],
            [
                'id' => 5,
                'gru_descricao' => 'RECEITAS DE VENDAS',
                'gru_tipo' => 'R',
                'gru_classificacao' => 1,
                'status' => 1,
            ],
            [
                'id' => 6,
                'gru_descricao' => 'RECEITAS FINANCEIRAS',
                'gru_tipo' => 'R',
                'gru_classificacao' => 3,
                'status' => 1,
            ],
            [
                'id' => 9,
                'gru_descricao' => 'DESPESAS OPERACIONAIS',
                'gru_tipo' => 'D',
                'gru_classificacao' => 1,
                'status' => 1,
            ],
            [
                'id' => 10,
                'gru_descricao' => 'DESPESAS NÃO OPERACIONAL',
                'gru_tipo' => 'D',
                'gru_classificacao' => 3,
                'status' => 1,
            ],
            [
                'id' => 11,
                'gru_descricao' => 'RECEITA OPERACIONAL',
                'gru_tipo' => 'R',
                'gru_classificacao' => 1,
                'status' => 1,
            ]
        ];

        $this->db->table('cad_grupo')->insertBatch($data);
        
    }
}