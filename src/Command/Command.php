<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Command;

interface Command
{
    public function execute(): void;
}
