<?php
declare(strict_types=1);

namespace Integration;

use PHPUnit\Framework\TestCase;
use RamonRibeiro\SuperWaffle\DAO\ProductType as ProductTypeDAO;
use RamonRibeiro\SuperWaffle\DAO\ProductTax as ProductTaxDAO;
use RamonRibeiro\SuperWaffle\DAO\Product as ProductDAO;
use RamonRibeiro\SuperWaffle\DTO\Product as ProductDTO;
use RamonRibeiro\SuperWaffle\DTO\ProductType as ProductTypeDTO;
use RamonRibeiro\SuperWaffle\DTO\ProductTax as ProductTaxDTO;

class ProductTest extends TestCase
{
    /**
     * @dataProvider idProvider
     */
    public function testInsertProduct($id): void
    {
        $productTypeDTO = ProductTypeDTO::create(id: $id, description: 'COPOS/CANECAS');
        $productTaxDTO = ProductTaxDTO::create(id: $id, percent: 5.20, description: 'TAXA EM COPOS');

        $productDTO = ProductDTO::create(
            id: $id,
            price: 2.30,
            description: 'COPO AMERICANO',
            productTax: $productTaxDTO,
            productType: $productTypeDTO
        );

        $productTypeDAO = new ProductTypeDAO();
        $productType = $productTypeDAO->save($productTypeDTO); //Persist

        $productTaxDAO = new ProductTaxDAO();
        $productTax = $productTaxDAO->save($productTaxDTO); //Persist

        $productDAO = new ProductDAO();
        $product = $productDAO->save($productDTO); //Persist

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\Product::class, $product);
        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\ProductType::class, $productType);
        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\ProductTax::class, $productTax);
    }

    /**
     * @dataProvider idProvider
     */
    public function testUpdateProduct($id)
    {
        $productTypeDTO = ProductTypeDTO::create(id: $id, description: 'COPOS/CANECAS/PORCELAS');
        $productTaxDTO = ProductTaxDTO::create(id: $id, percent: 3.20, description: 'TAXA EM PORCELANAS');

        $productDTO = ProductDTO::create(
            id: $id,
            price: 3.30,
            description: 'COPO AMERICANO',
            productTax: $productTaxDTO,
            productType: $productTypeDTO
        );

        $productTypeDAO = new ProductTypeDAO();
        $productType = $productTypeDAO->update($productTypeDTO); //Persist

        $productTaxDAO = new ProductTaxDAO();
        $productTax = $productTaxDAO->update($productTaxDTO); //Persist

        $productDAO = new ProductDAO();
        $product = $productDAO->update($productDTO); //Persist

        $this->assertEquals(3.30, $product->getPrice());
        $this->assertEquals('COPOS/CANECAS/PORCELAS', $productType->getDescription());
        $this->assertEquals(3.20, $productTax->getPercent());
        $this->assertEquals('TAXA EM PORCELANAS', $productTax->getDescription());
    }

    /**
     * @dataProvider idProvider
     */
    public function testDeleteProduct($id)
    {
        $productTypeDTO = ProductTypeDTO::create(id: $id, description: 'COPOS/CANECAS/PORCELAS');
        $productTaxDTO = ProductTaxDTO::create(id: $id, percent: 3.20, description: 'TAXA EM PORCELANAS');

        $productDTO = ProductDTO::create(
            id: $id,
            price: 3.30,
            description: 'COPO AMERICANO',
            productTax: $productTaxDTO,
            productType: $productTypeDTO
        );

        $productDAO = new ProductDAO();
        $productDeleted = $productDAO->delete($productDTO); //Persist

        $productTypeDAO = new ProductTypeDAO();
        $productTypeDeleted = $productTypeDAO->delete($productTypeDTO); //Persist

        $productTaxDAO = new ProductTaxDAO();
        $productTaxDeleted = $productTaxDAO->delete($productTaxDTO); //Persist

        $this->assertTrue($productTypeDeleted, 'Deve apagar tipo do produto');
        $this->assertTrue($productTaxDeleted, 'Deve apagar taxa do produto');
        $this->assertTrue($productDeleted, 'Deve apagar produto');
    }

    public function idProvider(): array
    {
        return [
            [1]
        ];
    }
}