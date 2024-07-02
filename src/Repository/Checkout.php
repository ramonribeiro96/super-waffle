<?php

namespace RamonRibeiro\SuperWaffle\Repository;

use RamonRibeiro\SuperWaffle\DTO\Checkout as CheckoutDTO;
use RamonRibeiro\SuperWaffle\Entity\Checkout as CheckoutEntity;

interface Checkout
{
    /**
     * @return CheckoutEntity []
     */
    public function list(): array;

    public function save(CheckoutDTO $checkoutDTO): CheckoutEntity;

    public function getById(int $id): CheckoutEntity;
}