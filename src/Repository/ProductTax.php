<?php

namespace RamonRibeiro\SuperWaffle\Repository;

use RamonRibeiro\SuperWaffle\Entity\ProductTax as ProductTaxEntity;
use RamonRibeiro\SuperWaffle\DTO\ProductTax as ProductTaxDTO;

interface ProductTax
{
    /**
     * @return ProductTaxEntity []
     */
    public function list(): array;

    public function save(ProductTaxDTO $productTaxDTO): ProductTaxEntity;

    public function update(ProductTaxDTO $productTaxDTO): ProductTaxEntity;

    public function delete(ProductTaxDTO $productTaxDTO): bool;

    public function getById(int $id): ProductTaxEntity;
}