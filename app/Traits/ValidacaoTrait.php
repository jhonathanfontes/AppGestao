<?php

namespace App\Traits;

trait ValidacaoTrait
{
    public function consultaViaCep(string $cep)
    {
        /* Endpoint */
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        // Inicia
        $curl = curl_init();

        // Configura
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);

        // Envio e armazenamento da resposta
        $response = curl_exec($curl);

        // Fecha e limpa recursos
        curl_close($curl);

        return $response;
    }

    public function consultaReceitAws(string $cnpj)
    {
        /* Endpoint */
        $url = "https://www.receitaws.com.br/v1/cnpj/{$cnpj}";

        /* eCurl */
        $curl = curl_init();

        /* Set JSON data to GET */
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /* make request */
        $result = curl_exec($curl);

        return $result;
    }
}
