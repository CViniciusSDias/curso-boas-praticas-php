<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Command;

use Alura\BoasPraticas\Service\HttpClient;
use Alura\BoasPraticas\Service\ShelterService;

class ListSheltersCommand implements Command
{
    public function execute(): void
    {
        $httpClient = new HttpClient();
        $shelterService = new ShelterService($httpClient);

        $shelterService->listarAbrigos();
    }
}
