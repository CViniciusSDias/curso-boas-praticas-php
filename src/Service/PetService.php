<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Service;

use Alura\BoasPraticas\Domain\Pet;

class PetService
{
    public function __construct(private readonly HttpClient $httpClient)
    {
    }

    public function listarPetsDeAbrigo(): void
    {
        echo "Digite o id do abrigo:" . PHP_EOL;
        $idOuNome = trim(fgets(STDIN));
        $response = $this->httpClient->get(ShelterService::URL . "/$idOuNome/pets");
        if (!$response) {
            echo "Id não cadastrado!" . PHP_EOL;
            return;
        }
        $jsonArray = array_map(
            function (array $pet): Pet
            {
                $petObject = new Pet(
                    $pet['tipo'],
                    $pet['nome'],
                    $pet['raca'],
                    intval($pet['idade']),
                    $pet['cor'],
                    floatval($pet['peso']),
                );
                $petObject->id = intval($pet['id']);

                return $petObject;
            },
            json_decode($response, true),
        );
        echo "Pets cadastrados:" . PHP_EOL;
        foreach ($jsonArray as $pet) {
            echo "{$pet->id} - {$pet->type} - {$pet->name} - {$pet->race} - {$pet->age} ano(s)" . PHP_EOL;
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
            $pet = new Pet(
                type: $campos[0],
                name: $campos[1],
                race: $campos[2],
                age: intval($campos[3]),
                color: $campos[4],
                weight: floatval($campos[5]),
            );

            [$statusCode, $responseBody] = $this->httpClient->post(
                ShelterService::URL . "/$idOuNome/pets",
                $pet
            );

            if ($statusCode == 201) {
                echo "Pet cadastrado com sucesso: {$pet->name}" . PHP_EOL;
            } else if ($statusCode == 404) {
                echo "Id do abrigo não encontrado!" . PHP_EOL;
                break;
            } else {
                echo "$statusCode - Erro ao cadastrar o pet: {$pet->name}" . PHP_EOL;
                echo $responseBody . PHP_EOL;
                break;
            }
        }
    }
}
