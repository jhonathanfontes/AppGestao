<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table            = 'sys_auditoria';
    protected $primaryKey       = 'codigo';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'usuario_id',
        'aud_modulo',
        'aud_tabela',
        'aud_acao',
        'atributos',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    public function insertAuditoria(string $modulo, string $tabela, string $acoes, string $dados): void
    {
        $data = [
            'usuario_id'    => getUsuarioID(),
            'aud_modulo'    => $modulo,
            'aud_tabela'    => $tabela,
            'aud_acao'      => $acoes,
            'atributos'     => $dados
        ];
        $this->insert($data);
    }
}
