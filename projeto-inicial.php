<?php

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

        if ($opcaoEscolhida == 1) {
            listarAbrigos();
        } else if ($opcaoEscolhida == 2) {
            cadastrarAbrigo();
        } else if ($opcaoEscolhida == 3) {
            listarPetsDeAbrigo();
        } else if ($opcaoEscolhida == 4) {
            importarPets();
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

function listarAbrigos(): void
{
    $responseBody = file_get_contents('https://66f610a1436827ced975d41f.mockapi.io/abrigos');
    $jsonArray = json_decode($responseBody, true);
    echo "Abrigos cadastrados:" . PHP_EOL;
    foreach ($jsonArray as $abrigo) {
        $id = $abrigo['id'];
        $nome = $abrigo['nome'];
        echo "$id - $nome" . PHP_EOL;
    }
}

function cadastrarAbrigo(): void
{
    echo "Digite o nome do abrigo:" . PHP_EOL;
    $nome = trim(fgets(STDIN));
    echo "Digite o telefone do abrigo:" . PHP_EOL;
    $telefone = trim(fgets(STDIN));
    echo "Digite o email do abrigo:" . PHP_EOL;
    $email = trim(fgets(STDIN));

    $abrigo = compact('nome', 'telefone', 'email');

    $curl = curl_init('https://66f610a1436827ced975d41f.mockapi.io/abrigos');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($abrigo));
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $responseBody = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($statusCode < 400) {
        echo "Abrigo cadastrado com sucesso!" . PHP_EOL;
    } else {
        echo "Erro ao cadastrar o abrigo:" . PHP_EOL;
        echo $responseBody . PHP_EOL;
    }
}

function listarPetsDeAbrigo(): void
{
    echo "Digite o id do abrigo:" . PHP_EOL;
    $idOuNome = trim(fgets(STDIN));
    $response = @file_get_contents("https://66f610a1436827ced975d41f.mockapi.io/abrigos/$idOuNome/pets");
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

function importarPets(): void
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
        $curl = curl_init("https://66f610a1436827ced975d41f.mockapi.io/abrigos/$idOuNome/pets");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($pet));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $responseBody = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

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