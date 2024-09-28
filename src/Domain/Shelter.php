<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Domain;

class Shelter implements \JsonSerializable
{
    public int $id;

    public function __construct(
        public readonly string $name,
        public readonly string $phone,
        public readonly string $email,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'nome' => $this->name,
            'email' => $this->name,
            'telefone' => $this->phone,
        ];
    }
}
