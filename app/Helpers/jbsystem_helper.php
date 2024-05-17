<?php
// GERAR VALORES
function getDatetimeAtual()
{
    date_default_timezone_set('America/Sao_Paulo');
    return date('Y-m-d H:i');
}

function getUsuarioID()
{
    return session()->get('jb_usuarioID');
}

function getUsuarioName()
{
    return session()->get('jb_apelido');
}

function getDiaUtil($proximo, $dia, $mes, $ano, $mesal = true)
{
    $vencimento = mktime(0, 0, 0, $mes, $dia, $ano);

    if ($mesal) {
        $vencimento = strtotime("+$proximo months", $vencimento);
    } else {
        $vencimento = strtotime("+$proximo days", $vencimento);
    }

    $weekend = date('w', $vencimento);

    if ($weekend == 0) {
        $vencimento = strtotime('+1 days', $vencimento);
    } elseif ($weekend == 6) {
        $vencimento = strtotime('+2 days', $vencimento);
    }

    return date('Y/m/d', $vencimento);
}

function getSerial()
{
    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $max = strlen($caracteres) - 1;
    $code = "";
    for ($i = 0; $i < 25; $i++) {
        $code .= $caracteres[mt_rand(0, $max)];
    }
    return $code;
}

function getCodigoBarra($subcategoria, $id)
{
    $row_sub = str_pad($subcategoria, 3, '0', STR_PAD_LEFT);
    $row_id = str_pad($id, 4, '0', STR_PAD_LEFT);

    $caracteres = "0123456789";
    $max = strlen($caracteres) - 1;
    $row_code = "";
    for ($i = 0; $i < 6; $i++) {
        $row_code .= $caracteres[mt_rand(0, $max)];
    }

    $codigobarra = $row_sub . $row_id . $row_code;
    return $codigobarra;
}

function ___getCodigoBarra($subcategoria, $id)
{
    $qnt_sub = strlen($subcategoria);
    switch ($qnt_sub) {
        case '1':
            $row_sub = $subcategoria . '00';
            break;
        case '2':
            $row_sub = $subcategoria . '0';
            break;
        case '3':
            $row_sub = $subcategoria;
            break;
        default:
            $row_sub = $subcategoria;
            break;
    }
    $qnt_id = strlen($id);
    switch ($qnt_id) {
        case '1':
            $row_id = '000' . $id;
            break;
        case '2':
            $row_id = '00' . $id;
            break;
        case '3':
            $row_id = '0' . $id;
            break;
        case '4':
            $row_id = $id;
            break;
        default:
            $row_id = $id;
            break;
    }
    $caracteres = "0123456789";
    $max = strlen($caracteres) - 1;
    $row_code = "";
    for ($i = 0; $i < 6; $i++) {
        $row_code .= $caracteres[mt_rand(0, $max)];
    }
    $codigobarra = $row_sub . $row_id . $row_code;
    return $codigobarra;
}

// FUNCÕES FORMATAÇÃO

function formatCnpjCpf($value)
{
    $cnpj_cpf = preg_replace("/\D/", '', $value);
    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    }
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function limparCnpjCpf($valor)
{
    if (empty($valor)):
        return null;
    endif;

    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

function formatValorBR($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function formatValorBD($valor)
{
    $verificaPonto = ".";
    if (strpos("[" . $valor . "]", $verificaPonto)):
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    else:
        $valor = str_replace(',', '.', $valor);
    endif;
    return $valor;
}

function completeComZero($codigo, $quantidade = 6)
{
    $currentLength = strlen($codigo);
    $zerosToAdd = $quantidade - $currentLength;

    if ($zerosToAdd <= 0) {
        return $codigo; // No need to add zeros
    }

    return str_repeat('0', $zerosToAdd) . $codigo;
}

function formatDataBR($data)
{
    return (new \DateTimeImmutable($data))->format('d/m/Y');
}

function formatDataTimeBR($data)
{
    return (new \DateTimeImmutable($data))->format('d/m/Y H:i');
}

function returnNull($texto, $strtoupper = null)
{
    if (empty($texto)) {
        return null;
    } else {
        if ($strtoupper != null) {
            if ($strtoupper === 'N') {
                return mb_strtolower(esc($texto), 'UTF-8');
            }
            return mb_strtoupper(esc($texto), 'UTF-8');
        } else {
            return $texto;
        }
    }
}

// CONVERSÕES
function convertPessoa($forma)
{
    switch ($forma) {
        case '1':
            $return = 'CLIENTE';
            break;
        case '2':
            $return = 'FORNECEDOR';
            break;
        case '3':
            $return = 'CLIENTE/FORNECEDOR';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertNatureza($forma)
{
    switch ($forma) {
        case 'F':
            $return = 'Física';
            break;
        case 'J':
            $return = 'Jurídica';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertTipoConta($forma)
{
    switch ($forma) {
        case 1:
            $return = 'CONTA CORRENTE';
            break;
        case 2:
            $return = 'CONTA POUPANÇA';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertFormarPagamento($forma)
{
    switch (intval($forma)) {
        case '1':
            $return = 'Dinheiro';
            break;
        case '2':
            $return = 'Transferencia';
            break;
        case '3':
            $return = 'Cartão Debito';
            break;
        case '4':
            $return = 'Cartão Credito';
            break;
        case '5':
            $return = 'Boleto';
            break;
        case '6':
            $return = 'Credito Financeiro';
            break;
        case '99':
            $return = 'Outros';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertTipoCaixa($forma)
{
    switch ($forma) {
        case '1':
            $return = 'Suplemento';
            break;
        case '2':
            $return = 'Sangria';
            break;
        case '3':
            $return = 'Vendas';
            break;
        case '4':
            $return = 'Pagamentos';
            break;
        case '5':
            $return = 'Recebimentos';
            break;
        case '6':
            $return = 'Transferencia';
            break;
        case '7':
            $return = 'Sangria Depositos';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertTipoConcilia($forma)
{
    switch ($forma) {
        case '1':
            $return = 'Cartão Debito';
            break;
        case '2':
            $return = 'Cartão Credito';
            break;
        case '3':
            $return = 'Transferencia';
            break;
        case '4':
            $return = 'Depositos';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertSituacao($forma)
{
    switch ($forma) {
        case '0':
            $return = 'Excluida';
            break;
        case '1':
            $return = 'Em Andamento';
            break;
        case '2':
            $return = 'Finalizada';
            break;
        case '3':
            $return = 'Cancelada';
            break;
        case '4':
            $return = 'Pendente';
            break;
        case '5':
            $return = 'Agrupada';
            break;
        default:
            $return = 'Indefinido';
            break;
    }
    return $return;
}

function convertSimNao($forma)
{
    switch ($forma) {
        case 0:
            $return = '<label class="badge badge-secondary">NÃO</label>';
            break;
        case 1:
            $return = '<label class="badge badge-success">SIM</label>';
            break;
        default:
            $return = '';
            break;
    }
    return $return;
}

function convertStatus($forma)
{
    switch ($forma) {
        case '0':
            $return = '<label class="badge badge-secondary">EXCLUIDO</label>';
            break;
        case '1':
            $return = '<label class="badge badge-success">HABILITADO</label>';
            break;
        case '2':
            $return = '<label class="badge badge-danger">DESABILITADO</label>';
            break;
        case '3':
            $return = '<label class="badge badge-dark">ARQUIVADO</label>';
            break;
        default:
            $return = '<label class="badge badge-light">INDEFINIDO</label>';
            break;
    }
    return $return;
}

function convertClassificacao($forma)
{
    switch ($forma) {
        case '1':
            $return = 'OPERACIONAL';
            break;
        case '2':
            $return = 'CUSTO VARIÁVEL';
            break;
        case '3':
            $return = 'NÃO OPERACIONAL';
            break;
        default:
            $return = 'NÃO CLASSIFICADO';
            break;
    }
    return $return;
}

function convertTipoGrupo($forma)
{
    switch ($forma) {
        case 'R':
            $return = '<label class="badge badge-success">RECEITAS</label>';
            break;
        case 'D':
            $return = '<label class="badge badge-danger">DESPESAS</label>';
            break;
        default:
            $return = '<label class="badge badge-dark">NÃO CLASSIFICADO</label>';
            break;
    }
    return $return;
}

function convertMes($mes)
{
    switch ($mes) {
        case '01':
            $return = 'JANEIRO';
            break;
        case '02':
            $return = 'FEVEREIRO';
            break;
        case '03':
            $return = 'MARÇO';
            break;
        case '04':
            $return = 'ABRIL';
            break;
        case '05':
            $return = 'MAIO';
            break;
        case '06':
            $return = 'JUNHO';
            break;
        case '07':
            $return = 'JULHO';
            break;
        case '08':
            $return = 'AGOSTO';
            break;
        case '09':
            $return = 'SETEMBRO';
            break;
        case '10':
            $return = 'OUTUBRO';
            break;
        case '11':
            $return = 'NOVEMBRO';
            break;
        case '12':
            $return = 'DEZEMBRO';
            break;
        case '13':
            $return = '13º SALARIO';
            break;
    }
    return $return;
}

// Abreviar
function primeiroNome($nome)
{
    $arr = explode(' ', trim($nome));
    return $arr[0];
}

function abreviaNome($name)
{
    //como os nomes são separados por espaço em branco então vamos criar o array
    //a partir dos espaços
    $split_name = explode(" ", $name);

    //so vamos abreviar o nome se 
    //ele tiver pelo menos 2 sobrenomes
    if (count($split_name) > 3) {

        //esse for inicia a partir da segunda
        // posição do array para o 
        //primeiro nome ser desconsiderado
        for ($i = 2; (count($split_name) - 2) > $i; $i++) {

            //claro que como existem dos|de|da|das 
            //(Cristina DOS Santos) podemos 
            //omitir ou exibir sem abrevirar 
            //essas preposições, aqui no 
            //caso eu as mantenho sem alteração
            if (strlen($split_name[$i]) > 3) {

                //aqui será feito a abreviação com apenas
                //a inicial da palavra a ser abreviada
                //seguida de ponto
                $split_name[$i] = substr($split_name[$i], 0, 1) . ".";
            }
        }
    }

    //aqui será impresso o nome resultante com a junção 
    //do array em favor de se obter uma string colando as posições
    //do array com espaços em branco!
    return implode(" ", $split_name);
}

function convertMesAbrevia($mes)
{
    switch ($mes) {
        case '01':
            $return = 'JAN';
            break;
        case '02':
            $return = 'FEV';
            break;
        case '03':
            $return = 'MAR';
            break;
        case '04':
            $return = 'ABR';
            break;
        case '05':
            $return = 'MAI';
            break;
        case '06':
            $return = 'JUN';
            break;
        case '07':
            $return = 'JUL';
            break;
        case '08':
            $return = 'AGO';
            break;
        case '09':
            $return = 'SET';
            break;
        case '10':
            $return = 'OUT';
            break;
        case '11':
            $return = 'NOV';
            break;
        case '12':
            $return = 'DEZ';
            break;
    }
    return $return;
}
