<?php

namespace RamonRibeiro\SuperWaffle\DAO;

use RamonRibeiro\SuperWaffle\DTO\Checkout as CheckoutDTO;
use RamonRibeiro\SuperWaffle\Entity\Checkout as CheckoutEntity;
use RamonRibeiro\SuperWaffle\Infrastructure\Connection;
use RamonRibeiro\SuperWaffle\Repository\Checkout as CheckoutRepository;

class Checkout implements CheckoutRepository
{
    /**
     * @return CheckoutEntity[]
     */
    public function list(): array
    {
        $connection = new Connection();
        $statement = $connection->getConnection()->query('SELECT * FROM db_waffle.public.checkouts');

        $checkouts = [];
        foreach ($statement->getIterator() as $key => $checkout) {
            $checkouts[$key] = new CheckoutEntity(
                id: $checkout['id'],
                product: $checkout['product'],
                amount: $checkout['amount'],
                productPrice: $checkout['product_price'],
                taxPercent: $checkout['product_tax_percent'],
                created_at: $checkout['created_at'],
            );
        }

        return $checkouts;
    }

    public function save(CheckoutDTO $checkoutDTO): CheckoutEntity
    {
        $connection = new Connection();

        $productDAO = new Product;
        $productEntity = $productDAO->getById($checkoutDTO->getProduct());

        $productTaxDAO = new ProductTax;
        $productTaxEntity = $productTaxDAO->getById($checkoutDTO->getProductTax());

        $checkoutEntity = new CheckoutEntity(
            id: $checkoutDTO->getId(),
            product: $checkoutDTO->getProduct(),
            amount: $checkoutDTO->getAmount(),
            productPrice: $productEntity->getPrice(),
            taxPercent: $productTaxEntity->getPercent(),
            created_at: new \DateTime('now', new \DateTimeZone("UTC"))
        );

        $statement = $connection->getConnection()->prepare(
            'INSERT INTO db_waffle.public.checkouts (id, product_price, product_tax_percent, product, amount, product_taxes, product_type, created_at) 
                        VALUES (:id, :price, :percent, :product, :amount, :product_taxes, :product_type, :created_at)'
        );
        $statement->bindValue(':id', $checkoutEntity->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':price', $productEntity->getPrice());
        $statement->bindValue(':percent', $productTaxEntity->getPercent());
        $statement->bindValue(':product', $productEntity->getId(), \PDO::PARAM_INT);
        $statement->bindValue(':amount', $checkoutEntity->getAmount(), \PDO::PARAM_INT);
        $statement->bindValue(':product_taxes', $productEntity->getProductTax(), \PDO::PARAM_INT);
        $statement->bindValue(':product_type', $productEntity->getProductType(), \PDO::PARAM_INT);
        $statement->bindValue(':created_at', $checkoutEntity->getCreatedAt());
        $statement->execute();

        return $checkoutEntity;
    }

    public function getById(int $id): CheckoutEntity
    {
        $connection = new Connection();

        $statement = $connection->getConnection()->prepare('SELECT id, product_price, product_tax_percent, product, product_taxes, product_type, created_at FROM db_waffle.public.checkouts where id = :id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $checkout = $statement->fetch(\PDO::FETCH_ASSOC);

        $checkoutEntity = new CheckoutEntity(
            id: $checkout['id'],
            product: $checkout['product'],
            amount: $checkout['amount'],
            productPrice: $checkout['product_price'],
            taxPercent: $checkout['product_tax_percent'],
            created_at: $checkout['created_at']
        );

        return $checkoutEntity;
    }
}