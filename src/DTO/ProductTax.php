<?php

namespace RamonRibeiro\SuperWaffle\DTO;

readonly class ProductTax
{
    private function __construct(
        private ?int   $id,
        private float  $percent,
        private string $description
    )
    {
    }

    public static function create(?int $id, float $percent, string $description): self
    {
        return new self($id, $percent, $description);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}