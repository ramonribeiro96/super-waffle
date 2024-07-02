<?php

namespace RamonRibeiro\SuperWaffle\Entity;

class Checkout
{
    public function __construct(
        private ?int             $id,
        private int              $product,
        private int              $amount,
        private float            $productPrice,
        private float            $taxPercent,
        private string|\DateTime $created_at
    )
    {
    }

    public function getId(): int
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

    public function getTaxPercent(): float
    {
        return $this->taxPercent;
    }

    public function getProductPrice(): float
    {
        return $this->productPrice;
    }

    public function getCreatedAt(): string|\DateTime
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }
}