<?php

namespace RamonRibeiro\SuperWaffle\Repository;

use RamonRibeiro\SuperWaffle\DTO\Product as ProductDTO;
use RamonRibeiro\SuperWaffle\Entity\Product as ProductEntity;

interface Product
{
    /**
     * @return ProductEntity []
     */
    public function list(): array;

    public function save(ProductDTO $productDTO): ProductEntity;

    public function update(ProductDTO $productDTO): ProductEntity;

    public function delete(ProductDTO $productDTO): bool;

    public function getById(int $id): ProductEntity;
}