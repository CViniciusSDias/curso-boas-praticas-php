<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Command;

use Alura\BoasPraticas\Service\HttpClient;
use Alura\BoasPraticas\Service\PetService;

class ImportPetsCommand
{
    public function execute(): void
    {
        $httpClient = new HttpClient();
        $shelterService = new PetService($httpClient);
        $shelterService->importarPets();
    }
}
