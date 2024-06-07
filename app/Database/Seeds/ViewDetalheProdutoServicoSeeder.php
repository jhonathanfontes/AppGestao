<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ViewDetalheProdutoServicoSeeder extends Seeder
{
    public function run()
    {
        $sql = "CREATE OR REPLACE VIEW sum_tipo_detahe AS
                    SELECT 
                        est_movimentacao.orcamento_id,
                        SUM(CASE WHEN cad_produto.pro_tipo = 1 THEN est_movimentacao.qtn_produto ELSE 0 END) AS qtn_produto,
                        SUM(CASE WHEN cad_produto.pro_tipo = 1 THEN est_movimentacao.qtn_devolvido ELSE 0 END) AS qtn_devolvido,
                        SUM(CASE WHEN cad_produto.pro_tipo = 1 THEN est_movimentacao.qtn_saldo ELSE 0 END) AS qtn_saldo,
                        CAST(COALESCE(SUM(CASE WHEN cad_produto.pro_tipo = 1 THEN est_movimentacao.val1_total ELSE 0 END), 0) AS DECIMAL(12,2)) AS val1_total_produto,
                        CAST(COALESCE(SUM(CASE WHEN cad_produto.pro_tipo = 1 THEN est_movimentacao.val2_total ELSE 0 END), 0) AS DECIMAL(12,2)) AS val2_total_produto,
                        SUM(CASE WHEN cad_produto.pro_tipo = 2 THEN est_movimentacao.qtn_produto ELSE 0 END) AS qtn_servico,
                        SUM(CASE WHEN cad_produto.pro_tipo = 2 THEN est_movimentacao.qtn_devolvido ELSE 0 END) AS qtn_devolvido_servico,
                        SUM(CASE WHEN cad_produto.pro_tipo = 2 THEN est_movimentacao.qtn_saldo ELSE 0 END) AS qtn_saldo_servico,
                        CAST(COALESCE(SUM(CASE WHEN cad_produto.pro_tipo = 2 THEN est_movimentacao.val1_total ELSE 0 END), 0) AS DECIMAL(12,2)) AS val1_total_servico,
                        CAST(COALESCE(SUM(CASE WHEN cad_produto.pro_tipo = 2 THEN est_movimentacao.val2_total ELSE 0 END), 0) AS DECIMAL(12,2)) AS val2_total_servico
                    FROM est_movimentacao
                    LEFT JOIN cad_produto ON cad_produto.id = est_movimentacao.produto_id
                        WHERE est_movimentacao.situacao IN ('1','2','4') AND est_movimentacao.orcamento_id IS NOT NULL
                            GROUP BY est_movimentacao.orcamento_id";

        // Simple Queries
        $this->db->query($sql);

    }
}
