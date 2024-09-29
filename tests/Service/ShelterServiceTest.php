<?php

declare(strict_types=1);

use Alura\BoasPraticas\Service\HttpClient;
use Alura\BoasPraticas\Service\ShelterService;
use PHPUnit\Framework\TestCase;

class ShelterServiceTest extends TestCase
{
    public function testListarAbrigosExibeIdENome(): void
    {
        $output = <<<OUTPUT
        Abrigos cadastrados:
        1 - Dias de Pet
        2 - Novo Abrigo
        3 - Terceiro Abrigo
        
        OUTPUT;

        $this->expectOutputString($output);

        $httpClient = new HttpClient();
        $shelterService = new ShelterService($httpClient);
        $shelterService->listarAbrigos();
    }
}