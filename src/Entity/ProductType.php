<?php

namespace RamonRibeiro\SuperWaffle\Entity;

class ProductType
{
    public function __construct(
        private int    $id,
        private ?string $description,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}