<?php

namespace RamonRibeiro\SuperWaffle\Entity;

class Product
{
    public function __construct(
        private int    $id,
        private ?float $price,
        private ?string $description,
        private ?int    $productTax,
        private ?int    $productType,
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getProductTax(): int
    {
        return $this->productTax;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }
}