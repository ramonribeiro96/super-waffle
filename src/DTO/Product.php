<?php

namespace RamonRibeiro\SuperWaffle\DTO;

readonly class Product
{
    private function __construct(
        private ?int         $id,
        private float        $price,
        private string       $description,
        private ?ProductTax  $productTax,
        private ?ProductType $productType
    )
    {
    }

    public static function create(?int $id, ?float $price, ?string $description, ?ProductTax $productTax, ?ProductType $productType): self
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
        return $this->productTax->getId();
    }

    public function getProductType(): int
    {
        return $this->productType->getId();
    }

    public function __toString(): string
    {
        return $this->id;
    }
}