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
        $connection = new Connection();

        $statement = $connection->getConnection()->query('SELECT id, percent, description FROM db_waffle.public.product_taxes', \PDO::FETCH_ASSOC);

        $productTaxes = [];

        foreach ($statement->getIterator() as $key => $productTax) {
            $productTaxes[$key] = new ProductTaxEntity(...$productTax);
        }

        return $productTaxes;
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

    public function getById(int $id): ProductTaxEntity
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare('SELECT id, percent, description FROM db_waffle.public.product_taxes where id = :id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $product = new ProductTaxEntity(...$statement->fetch(\PDO::FETCH_ASSOC));

        return $product;
    }
}