<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Service;

class PetService
{
    public function listarPetsDeAbrigo(): void
    {
        echo "Digite o id do abrigo:" . PHP_EOL;
        $idOuNome = trim(fgets(STDIN));
        $response = @file_get_contents(ShelterService::URL . "/$idOuNome/pets");
        if (!$response) {
            echo "Id não cadastrado!" . PHP_EOL;
            // continue;
        }
        $jsonArray = json_decode($response, true);
        echo "Pets cadastrados:" . PHP_EOL;
        foreach ($jsonArray as $pet) {
            extract($pet);
            echo "$id - $tipo - $nome - $raca - $idade ano(s)" . PHP_EOL;
        }
    }

    public function importarPets(): void
    {
        echo "Digite o id do abrigo:" . PHP_EOL;
        $idOuNome = trim(fgets(STDIN));

        echo "Digite o nome do arquivo CSV:" . PHP_EOL;
        $nomeArquivo = trim(fgets(STDIN));

        $arquivo = fopen($nomeArquivo, 'r');
        while ($campos = fgetcsv($arquivo)) {
            $pet = [
                'tipo' => $campos[0],
                'nome' => $campos[1],
                'raca' => $campos[2],
                'idade' => $campos[3],
                'cor' => $campos[4],
                'peso' => $campos[5],
            ];

            [$statusCode, $responseBody] = postRequest(
                ShelterService::URL . "/$idOuNome/pets",
                $pet
            );

            if ($statusCode == 201) {
                echo "Pet cadastrado com sucesso: $pet[nome]" . PHP_EOL;
            } else if ($statusCode == 404) {
                echo "Id do abrigo não encontrado!" . PHP_EOL;
                break;
            } else {
                echo "$statusCode - Erro ao cadastrar o pet: $pet[nome]" . PHP_EOL;
                echo $responseBody . PHP_EOL;
                break;
            }
        }
    }
}
