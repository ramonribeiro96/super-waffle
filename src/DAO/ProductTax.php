<?php

namespace RamonRibeiro\SuperWaffle\DAO;

use RamonRibeiro\SuperWaffle\DTO\ProductTax as ProductTaxDTO;
use RamonRibeiro\SuperWaffle\Infrastructure\Connection;
use RamonRibeiro\SuperWaffle\Entity\ProductTax as ProductTaxEntity;
use RamonRibeiro\SuperWaffle\Repository\ProductTax as ProductTaxRepository;

class ProductTax implements ProductTaxRepository
{
    public function list(): array
    {
        // TODO: Implement list() method.
    }

    public function save(ProductTaxDTO $productTaxDTO): ProductTaxEntity
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare(
            'INSERT INTO db_waffle.public.product_taxes (id, description, percent) VALUES (:id, :description, :percent)'
        );

        $product = new ProductTaxEntity(
            id: $productTaxDTO->getId() ?? $connection->getConnection()->lastInsertId(),
            percent: $productTaxDTO->getPercent(),
            description: $productTaxDTO->getDescription()
        );

        $statement->bindValue(':id', $product->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':description', $product->getDescription());
        $statement->bindValue(':percent', $product->getPercent());
        $statement->execute();

        return $product;
    }

    public function update(ProductTaxDTO $productTaxDTO): ProductTaxEntity
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare(
            'UPDATE db_waffle.public.product_taxes SET description = :description, percent = :percent WHERE id = :id'
        );

        $product = new ProductTaxEntity(
            id: $productTaxDTO->getId(),
            percent: $productTaxDTO->getPercent(),
            description: $productTaxDTO->getDescription()
        );

        $statement->bindValue(':id', $product->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':description', $product->getDescription());
        $statement->bindValue(':percent', $product->getPercent());
        $statement->execute();

        return $product;
    }

    public function delete(ProductTaxDTO $productTaxDTO): bool
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare(
            'DELETE FROM db_waffle.public.product_taxes WHERE id = :id'
        );

        $statement->bindValue(':id', $productTaxDTO->getId(), \PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() === 0)
            return false;

        unset($productTaxDTO);

        return true;
    }
}