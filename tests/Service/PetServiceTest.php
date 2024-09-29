<?php

declare(strict_types=1);

use Alura\BoasPraticas\Service\HttpClient;
use Alura\BoasPraticas\Service\PetService;
use PHPUnit\Framework\TestCase;

class PetServiceTest extends TestCase
{
    public function testListarPetsDeAbrigoInexistenteDeveExibirMensagemAmigavel(): void
    {
        $output = <<<OUTPUT
        Digite o id do abrigo:
        Id não cadastrado!
        
        OUTPUT;

        $this->expectOutputString($output);

        $httpClient = $this->createStub(HttpClient::class);
        $httpClient->method('get')
            ->willReturn('');

        $petService = new PetService($httpClient);
        $petService->listarPetsDeAbrigo();
    }
}
