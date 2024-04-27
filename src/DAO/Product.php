<?php

namespace RamonRibeiro\SuperWaffle\DAO;

use RamonRibeiro\SuperWaffle\Infrastructure\Connection;
use RamonRibeiro\SuperWaffle\Repository\Product as ProductRepository;
use RamonRibeiro\SuperWaffle\Entity\Product as ProductEntity;
use RamonRibeiro\SuperWaffle\DTO\Product as ProductDTO;

class Product implements ProductRepository
{
    /**
     * @return ProductEntity []
     */
    public function list(): array
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->query('SELECT * FROM db_waffle.public.products');

        $products = [];

        foreach ($statement->getIterator() as $key => $product) {
            $products[$key] = new ProductEntity(
                id: $product['id'],
                price: $product['price'],
                description: $product['description'],
                productTax: $product['product_taxes'],
                productType: $product['product_type']
            );
        }

        return $products;
    }

    public function save(ProductDTO $productDTO): ProductEntity
    {
        $connection = new Connection();

        $productEntity = new ProductEntity(
            id: $productDTO->getId() ?? $connection->getConnection()->lastInsertId(),
            price: $productDTO->getPrice(),
            description: $productDTO->getDescription(),
            productTax: $productDTO->getProductTax(),
            productType: $productDTO->getProductType(),
        );

        $statement = $connection->getConnection()
            ->prepare('INSERT INTO db_waffle.public.products (id, description, price, product_taxes, product_type) VALUES (:id, :description, :price, :product_taxes, :product_type)');

        $statement->bindValue(':id', $productEntity->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':description', $productEntity->getDescription());
        $statement->bindValue(':price', $productEntity->getPrice());
        $statement->bindValue(':product_taxes', $productEntity->getProductTax(), \PDO::PARAM_INT);
        $statement->bindValue(':product_type', $productEntity->getProductType(), \PDO::PARAM_INT);
        $statement->execute();

        return $productEntity;
    }

    public function update(ProductDTO $productDTO): ProductEntity
    {
        $connection = new Connection();

        $productEntity = new ProductEntity(
            id: $productDTO->getId(),
            price: $productDTO->getPrice(),
            description: $productDTO->getDescription(),
            productTax: $productDTO->getProductTax(),
            productType: $productDTO->getProductType(),
        );

        $statement = $connection->getConnection()
            ->prepare('UPDATE db_waffle.public.products 
                SET description = :description, price = :price, product_taxes = :product_taxes, product_type = :product_type 
                WHERE id = :id'
            );

        $statement->bindValue(':id', $productEntity->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':description', $productEntity->getDescription());
        $statement->bindValue(':price', $productEntity->getPrice());
        $statement->bindValue(':product_taxes', $productEntity->getProductTax(), \PDO::PARAM_INT);
        $statement->bindValue(':product_type', $productEntity->getProductType(), \PDO::PARAM_INT);
        $statement->execute();

        return $productEntity;
    }

    public function delete(ProductDTO $productDTO): bool
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare(
            'DELETE FROM db_waffle.public.products WHERE id = :id'
        );

        $statement->bindValue(':id', $productDTO->getId(), \PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() === 0)
            return false;

        unset($productDTO);

        return true;
    }

    public function getById(int $id): ProductEntity
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->query('SELECT id, price, description, product_taxes, product_type FROM db_waffle.public.products where id = :id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $productEntity = null;

        foreach ($statement->fetch(\PDO::FETCH_ASSOC) as $product) {
            $productEntity = new ProductEntity(
                id: $product['id'],
                price: $product['price'],
                description: $product['description'],
                productTax: $product['product_taxes'],
                productType: $product['product_type']
            );
        }

        return $productEntity;
    }
}