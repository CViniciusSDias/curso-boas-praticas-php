<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Command;

class InvalidOptionCommand implements Command
{
    public function execute(): void
    {
        echo "NÚMERO INVÁLIDO!" . PHP_EOL;
    }
}
