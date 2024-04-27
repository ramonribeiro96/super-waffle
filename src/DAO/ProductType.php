<?php

namespace RamonRibeiro\SuperWaffle\DAO;

use RamonRibeiro\SuperWaffle\DTO\ProductType as ProductTypeDTO;
use RamonRibeiro\SuperWaffle\Entity\ProductType as ProductTypeEntity;
use RamonRibeiro\SuperWaffle\Infrastructure\Connection;
use RamonRibeiro\SuperWaffle\Repository\ProductType as ProductTypeRepository;

class ProductType implements ProductTypeRepository
{
    /**
     * @return ProductTypeEntity[]
     */
    public function list(): array
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->query('SELECT id, description FROM db_waffle.public.product_type', \PDO::FETCH_ASSOC);

        $productTypes = [];

        foreach ($statement->getIterator() as $key => $productType) {
            $productTypes[$key] = new ProductTypeEntity(...$productType);
        }

        return $productTypes;
    }

    public function save(ProductTypeDTO $productTypeDTO): ProductTypeEntity
    {
        $connection = new Connection();

        $product = new ProductTypeEntity(
            id: $productTypeDTO->getId() ?? $connection->getConnection()->lastInsertId(),
            description: $productTypeDTO->getDescription(),
        );

        $statement = $connection->getConnection()->prepare(
            'INSERT INTO db_waffle.public.product_type (id, description) VALUES (:id, :description)'
        );

        $statement->bindValue(':id', $productTypeDTO->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':description', $productTypeDTO->getDescription());
        $statement->execute();

        return $product;
    }

    public function update(ProductTypeDTO $productTypeDTO): ProductTypeEntity
    {
        $connection = new Connection();

        $product = new ProductTypeEntity(
            id: $productTypeDTO->getId(),
            description: $productTypeDTO->getDescription(),
        );

        $statement = $connection->getConnection()->prepare(
            'UPDATE db_waffle.public.product_type SET description = :description WHERE id = :id'
        );

        $statement->bindValue(':id', $productTypeDTO->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':description', $productTypeDTO->getDescription());
        $statement->execute();

        return $product;
    }

    public function delete(ProductTypeDTO $productTypeDTO): bool
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare(
            'DELETE FROM db_waffle.public.product_type WHERE id = :id'
        );

        $statement->bindValue(':id', $productTypeDTO->getId(), \PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() === 0)
            return false;

        unset($productTypeDTO);

        return true;
    }

    public function getById(int $id): ProductTypeEntity
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare('SELECT id, description FROM db_waffle.public.product_type WHERE id = :id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $product = new ProductTypeEntity(...$statement->fetch(\PDO::FETCH_ASSOC));

        return $product;
    }
}