<?php

namespace RamonRibeiro\SuperWaffle\Repository;

use RamonRibeiro\SuperWaffle\DTO\ProductType as ProductTypeDTO;
use RamonRibeiro\SuperWaffle\Entity\ProductType as ProductTypeEntity;

interface ProductType
{
    /**
     * @return ProductTypeEntity []
     */
    public function list(): array;

    public function save(ProductTypeDTO $productTypeDTO): ProductTypeEntity;

    public function update(ProductTypeDTO $productTypeDTO): ProductTypeEntity;

    public function delete(ProductTypeDTO $productTypeDTO): bool;

}