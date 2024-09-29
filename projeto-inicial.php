<?php

use Alura\BoasPraticas\Command\{
    Command,
    ImportPetsCommand,
    InvalidOptionCommand,
    ListPetsFromShelterCommand,
    ListSheltersCommand,
    NewShelterCommand
};

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

        $opcaoEscolhida = intval(trim(fgets(STDIN)));

        /** @var Command $command */
        $command = match ($opcaoEscolhida) {
            1 => new ListSheltersCommand(),
            2 => new NewShelterCommand(),
            3 => new ListPetsFromShelterCommand(),
            4 => new ImportPetsCommand(),
            5 => new class implements Command { public function execute(): void {} },
            default => new InvalidOptionCommand()
        };
        $command->execute();
    } while ($opcaoEscolhida != 5);
    echo "Finalizando o programa..." . PHP_EOL;
} catch (Throwable $erro) {
    echo $erro->getMessage() . PHP_EOL;
}
