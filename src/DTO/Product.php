<?php

namespace RamonRibeiro\SuperWaffle\DTO;

readonly class Product
{
    private function __construct(
        private ?int   $id,
        private float  $price,
        private string $description,
        private int    $productTax,
        private int    $productType
    )
    {
    }

    public static function create(?int $id, float $price, string $description, int $productTax, int $productType): self
    {
        return new self($id, $price, $description, $productTax, $productType);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProductTax(): int
    {
        return $this->productTax;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}