<?php

declare(strict_types=1);

namespace Alura\BoasPraticas\Domain;

class Pet implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly string $race,
        public readonly int $age,
        public readonly string $color,
        public readonly float $weight,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'tipo' => $this->type,
            'nome' => $this->name,
            'raca' => $this->race,
            'idade' => $this->age,
            'cor' => $this->color,
            'peso' => $this->weight,
        ];
    }
}
