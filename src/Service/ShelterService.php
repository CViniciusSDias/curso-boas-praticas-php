<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Service;

class ShelterService
{
    public const string URL = 'https://66f610a1436827ced975d41f.mockapi.io/abrigos';

    public function listarAbrigos(): void
    {
        $responseBody = file_get_contents(self::URL);
        $jsonArray = json_decode($responseBody, true);
        echo "Abrigos cadastrados:" . PHP_EOL;
        foreach ($jsonArray as $abrigo) {
            $id = $abrigo['id'];
            $nome = $abrigo['nome'];
            echo "$id - $nome" . PHP_EOL;
        }
    }

    public function cadastrarAbrigo(): void
    {
        echo "Digite o nome do abrigo:" . PHP_EOL;
        $nome = trim(fgets(STDIN));
        echo "Digite o telefone do abrigo:" . PHP_EOL;
        $telefone = trim(fgets(STDIN));
        echo "Digite o email do abrigo:" . PHP_EOL;
        $email = trim(fgets(STDIN));

        $abrigo = compact('nome', 'telefone', 'email');

        [$statusCode, $responseBody] = postRequest(self::URL, $abrigo);

        if ($statusCode < 400) {
            echo "Abrigo cadastrado com sucesso!" . PHP_EOL;
        } else {
            echo "Erro ao cadastrar o abrigo:" . PHP_EOL;
            echo $responseBody . PHP_EOL;
        }
    }
}
