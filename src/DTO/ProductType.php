<?php

namespace RamonRibeiro\SuperWaffle\DTO;

readonly class ProductType
{
    private function __construct(
        private ?int   $id,
        private string $description,
    )
    {
    }

    public static function create(?int $id, ?string $description): self
    {
        return new self($id, $description);
    }

    public function getId(): ?int
    {
        return $this->id;
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