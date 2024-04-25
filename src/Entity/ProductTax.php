<?php

namespace RamonRibeiro\SuperWaffle\Entity;

class ProductTax
{
    public function __construct(
        private int    $id,
        private ?float  $percent,
        private ?string $description
    )
    {
    }

    public function getId(): int
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
}