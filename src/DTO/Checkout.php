<?php

namespace RamonRibeiro\SuperWaffle\DTO;

readonly class Checkout
{
    private function __construct(
        private ?int $id,
        private int  $product,
        private int  $amount,
        private int  $productType,
        private int  $productTax
    )
    {
    }

    public static function create(?int $id, int $product, int $amount, int $productType, int $productTax): self
    {
        return new self($id, $product, $amount, $productType, $productTax);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }

    public function getProductTax(): int
    {
        return $this->productTax;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}