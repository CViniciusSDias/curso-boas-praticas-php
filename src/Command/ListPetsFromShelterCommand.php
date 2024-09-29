<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Command;

use Alura\BoasPraticas\Service\HttpClient;
use Alura\BoasPraticas\Service\PetService;

class ListPetsFromShelterCommand implements Command
{
    public function execute(): void
    {
        $httpClient = new HttpClient();
        $shelterService = new PetService($httpClient);

        $shelterService->listarPetsDeAbrigo();
    }
}
