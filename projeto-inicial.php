<?php

use Alura\BoasPraticas\Command\ImportPetsCommand;
use Alura\BoasPraticas\Command\InvalidOptionCommand;
use Alura\BoasPraticas\Command\ListPetsFromShelterCommand;
use Alura\BoasPraticas\Command\ListSheltersCommand;
use Alura\BoasPraticas\Command\NewShelterCommand;
use Alura\BoasPraticas\Service\{HttpClient, PetService, ShelterService};

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

        if ($opcaoEscolhida == 1) {
            (new ListSheltersCommand())->execute();
        } else if ($opcaoEscolhida == 2) {
            (new NewShelterCommand())->execute();
        } else if ($opcaoEscolhida == 3) {
            (new ListPetsFromShelterCommand())->execute();
        } else if ($opcaoEscolhida == 4) {
            (new ImportPetsCommand())->execute();
        } else if ($opcaoEscolhida == 5) {
            break;
        } else {
            (new InvalidOptionCommand())->execute();
        }
    } while ($opcaoEscolhida != 5);
    echo "Finalizando o programa..." . PHP_EOL;
} catch (Throwable $erro) {
    echo $erro->getMessage() . PHP_EOL;
}
