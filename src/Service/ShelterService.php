<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Service;

use Alura\BoasPraticas\Domain\Shelter;

class ShelterService
{
    public const string URL = 'https://66f610a1436827ced975d41f.mockapi.io/abrigos';

    public function listarAbrigos(): void
    {
        $responseBody = file_get_contents(self::URL);

        $jsonArray = array_map(
            function (array $shelterArray): Shelter
            {
                $shelter = new Shelter($shelterArray['nome'], $shelterArray['telefone'], $shelterArray['email']);
                $shelter->id = intval($shelterArray['id']);

                return $shelter;
            },
            json_decode($responseBody, true)
        );

        echo "Abrigos cadastrados:" . PHP_EOL;
        foreach ($jsonArray as $shelter) {
            echo "{$shelter->id} - {$shelter->name}" . PHP_EOL;
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

        $shelter = new Shelter($nome, $telefone, $email);

        [$statusCode, $responseBody] = postRequest(self::URL, $shelter);

        if ($statusCode < 400) {
            echo "Abrigo cadastrado com sucesso!" . PHP_EOL;
        } else {
            echo "Erro ao cadastrar o abrigo:" . PHP_EOL;
            echo $responseBody . PHP_EOL;
        }
    }
}
