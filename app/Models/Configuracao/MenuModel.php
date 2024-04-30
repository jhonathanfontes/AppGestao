<?php

namespace App\Models\Configuracao;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'con_menu';
    protected $primaryKey = 'id_menu';
    protected $returnType     = 'array';
    protected $allowedFields = ['men_descricao', 'men_href', 'men_icon', 'men_posicao', 'men_superior', 'modulo_id'];

}
