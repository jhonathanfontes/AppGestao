<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TriggerAtualizaOrcamentoSeeder extends Seeder
{
    public function run()
    {

        $sqlInsert = "CREATE OR REPLACE TRIGGER incluiMovimentacao
            AFTER INSERT ON est_movimentacao
            FOR EACH ROW
            BEGIN
                -- Chama a procedure para atualizar o registro
                CALL AtualizaPdvOrcamento(NEW.orcamento_id);
            END";

         $sqlUpdate = "CREATE OR REPLACE TRIGGER atualizaMovimentacao
         AFTER UPDATE ON est_movimentacao
         FOR EACH ROW
         BEGIN
             -- Chama a procedure para atualizar o registro
             CALL AtualizaPdvOrcamento(OLD.orcamento_id);
         END";

        $this->db->query($sqlInsert);
        $this->db->query($sqlUpdate);

    }
}
