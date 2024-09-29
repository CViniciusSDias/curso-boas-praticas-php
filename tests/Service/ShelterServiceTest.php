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
        1 - Abrigo de teste
        
        OUTPUT;

        $this->expectOutputString($output);

        $httpClient = $this->createStub(HttpClient::class);
        $httpClient->method('get')
            ->willReturn(json_encode([
                [
                    'id' => 1,
                    'nome' => 'Abrigo de teste',
                    'telefone' => '',
                    'email' => '',
                ]
            ]));

        $shelterService = new ShelterService($httpClient);
        $shelterService->listarAbrigos();
    }
}