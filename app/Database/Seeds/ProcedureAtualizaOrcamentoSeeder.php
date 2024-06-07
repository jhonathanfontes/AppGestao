<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProcedureAtualizaOrcamentoSeeder extends Seeder
{
    public function run()
    {
        $sql = "CREATE OR REPLACE PROCEDURE AtualizaPdvOrcamento(IN p_orcamento_id INT)
        BEGIN
            -- Declaração de variáveis para os campos que serão atualizados
            DECLARE v_qtn_produto INT;
            DECLARE v_qtn_devolvido INT;
            DECLARE v_qtn_saldo INT;
            DECLARE v_val1_total_produto DECIMAL(12,2);
            DECLARE v_val2_total_produto DECIMAL(12,2);
            DECLARE v_qtn_servico INT;
            DECLARE v_qtn_devolvido_servico INT;
            DECLARE v_qtn_saldo_servico INT;
            DECLARE v_val1_total_servico DECIMAL(12,2);
            DECLARE v_val2_total_servico DECIMAL(12,2);

            -- Buscar os dados do orçamento da view sum_tipo_detahe
            SELECT 
                COALESCE(SUM(qtn_produto), 0),
                COALESCE(SUM(qtn_devolvido), 0),
                COALESCE(SUM(qtn_saldo), 0),
                CAST(COALESCE(SUM(val1_total_produto), 0) AS DECIMAL(12,2)),
                CAST(COALESCE(SUM(val2_total_produto), 0) AS DECIMAL(12,2)),
                COALESCE(SUM(qtn_servico), 0),
                COALESCE(SUM(qtn_devolvido_servico), 0),
                COALESCE(SUM(qtn_saldo_servico), 0),
                CAST(COALESCE(SUM(val1_total_servico), 0) AS DECIMAL(12,2)),
                CAST(COALESCE(SUM(val2_total_servico), 0) AS DECIMAL(12,2))
            INTO
                v_qtn_produto,
                v_qtn_devolvido,
                v_qtn_saldo,
                v_val1_total_produto,
                v_val2_total_produto,
                v_qtn_servico,
                v_qtn_devolvido_servico,
                v_qtn_saldo_servico,
                v_val1_total_servico,
                v_val2_total_servico
            FROM sum_tipo_detahe
            WHERE orcamento_id = p_orcamento_id;

            -- Atualiza os campos relacionados na tabela pdv_orcamento
            UPDATE pdv_orcamento
            SET 
                qtn_produto = v_qtn_produto,
                qtn_devolvido = v_qtn_devolvido,
                qtn_saldo = v_qtn_saldo,
                valor1_produtos = v_val1_total_produto,
                valor1_servicos = v_val1_total_servico,
                valor1_bruto = v_val1_total_produto + v_val1_total_servico,
                valor1_total = v_val1_total_produto + v_val1_total_servico,
                valor2_produtos = v_val2_total_produto,
                valor2_servicos = v_val2_total_servico,
                valor2_bruto = v_val2_total_produto + v_val2_total_servico,
                valor2_total = v_val2_total_produto + v_val2_total_servico
            WHERE id = p_orcamento_id;

        END";

        $this->db->query($sql);

    }
}
