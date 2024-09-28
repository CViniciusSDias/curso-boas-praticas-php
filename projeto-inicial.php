<?php

use Alura\BoasPraticas\Service\{PetService, ShelterService};

require_once __DIR__ . '/vendor/autoload.php';

echo '##### BOAS VINDAS AO SISTEMA ADOPET CONSOLE #####' . PHP_EOL;

try {
    do {
        echo "\nDIGITE O NÚMERO DA OPERAÇÃO DESEJADA:" . PHP_EOL;
        echo "1 -> Listar abrigos cadastrados" . PHP_EOL;
        echo "2 -> Cadastrar novo abrigo" . PHP_EOL;
        echo "3 -> Listar pets do abrigo" . PHP_EOL;
        echo "4 -> Importar pets do abrigo" . PHP_EOL;
        echo "5 -> Sair" . PHP_EOL;

        $opcaoEscolhida = trim(fgets(STDIN));
        $shelterService = new ShelterService();
        $petService = new PetService();

        if ($opcaoEscolhida == 1) {
            $shelterService->listarAbrigos();
        } else if ($opcaoEscolhida == 2) {
            $shelterService->cadastrarAbrigo();
        } else if ($opcaoEscolhida == 3) {
            $petService->listarPetsDeAbrigo();
        } else if ($opcaoEscolhida == 4) {
            $petService->importarPets();
        } else if ($opcaoEscolhida == 5) {
            break;
        } else {
            echo "NÚMERO INVÁLIDO!" . PHP_EOL;
            $opcaoEscolhida = 0;
        }
    } while ($opcaoEscolhida != 5);
    echo "Finalizando o programa..." . PHP_EOL;
} catch (Throwable $erro) {
    echo $erro->getMessage() . PHP_EOL;
}

function postRequest(string $url, array $requestBody): array
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestBody));
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $responseBody = curl_exec($curl);
    $responseStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    return [$responseStatusCode, $responseBody];
}