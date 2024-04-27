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
     * @dataProvider productsTypeProvider
     */
    public function testInsertProductType($id, $description): void
    {
        $productTypeDTO = ProductTypeDTO::create(id: $id, description: $description);

        $productTypeDAO = new ProductTypeDAO();
        $productType = $productTypeDAO->save($productTypeDTO); //Persist

        $productTypeGetById = $productTypeDAO->getById($productTypeDTO->getId());

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\ProductType::class, $productType, 'Deve ser um Product Entity.');
        $this->assertEquals($productTypeDTO->getDescription(), $productTypeGetById->getDescription(), 'Deve conter a mesma "description" que o DTO.');
    }

    /**
     * @dataProvider productsTaxesProvider
     */
    public function testInsertProductTaxes($id, $percent, $description): void
    {
        $productTaxDTO = ProductTaxDTO::create(id: $id, percent: $percent, description: $description);

        $productTaxDAO = new ProductTaxDAO();
        $productTax = $productTaxDAO->save($productTaxDTO); //Persist

        $productTaxGetById = $productTaxDAO->getById($productTaxDTO->getId());

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\ProductTax::class, $productTax, 'Deve ser um ProductTax Entity.');
        $this->assertEquals($productTaxDTO->getPercent(), $productTaxGetById->getPercent(), 'Deve conter o mesmo "percent" que o DTO.');
        $this->assertEquals($productTaxDTO->getDescription(), $productTaxGetById->getDescription(), 'Deve conter a mesma "description" que o DTO.');
    }

    /**
     * @dataProvider productsProvider
     */
    public function testInsertProduct($idProvider, $priceProvider, $descriptionProvider, $idProductTaxProvider, $idProductTypeProvider): void
    {
        $productDTO = ProductDTO::create(
            id: $idProvider,
            price: $priceProvider,
            description: $descriptionProvider,
            productTax: $idProductTaxProvider,
            productType: $idProductTypeProvider
        );

        $productDAO = new ProductDAO();
        $product = $productDAO->save($productDTO); //Persist

        $productTaxGetById = $productDAO->getById($productDTO->getId());

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\Product::class, $product);
        $this->assertEquals($productDTO->getPrice(), $productTaxGetById->getPrice(), 'Deve conter o mesmo "price" que o DTO.');
        $this->assertEquals($productDTO->getDescription(), $productTaxGetById->getDescription(), 'Deve conter a mesma "description" que o DTO.');
    }

    /**
     * @dataProvider productsTypeUpdateProvider
     */
    public function testUpdateProductType($id, $description): void
    {
        $productTypeDTO = ProductTypeDTO::create(id: $id, description: $description);

        $productTypeDAO = new ProductTypeDAO();
        $productTypeDAO->update($productTypeDTO); //Persist

        $productTypeUpdated = $productTypeDAO->getById($productTypeDTO->getId());

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\ProductType::class, $productTypeUpdated, 'Deve ser uma ProductType Entity.');
        $this->assertStringContainsString('UPDATE', $productTypeUpdated->getDescription(), 'Deve conter "UPDATE" na descrição.');
    }

    /**
     * @dataProvider productsTaxesUpdateProvider
     */
    public function testUpdateProductTax($id, $percent, $description): void
    {
        $productTaxDTO = ProductTaxDTO::create(id: $id, percent: $percent, description: $description);

        $productTaxDAO = new ProductTaxDAO();
        $productTaxDAO->update($productTaxDTO); //Persist

        $productTaxUpdated = $productTaxDAO->getById($productTaxDTO->getId());

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\ProductTax::class, $productTaxUpdated, 'Deve ser uma ProductTax Entity.');
        $this->assertStringContainsString('UPDATE', $productTaxUpdated->getDescription(), 'Deve conter "UPDATE" na descrição.');
    }

    /**
     * @dataProvider productsUpdateProvider
     */
    public function testUpdateProduct($id, $price, $description, $productTax, $productType): void
    {
        $productDTO = ProductDTO::create(id: $id, price: $price, description: $description, productTax: $productTax, productType: $productType);

        $productDAO = new ProductDAO();
        $productDAO->update($productDTO); //Persist

        $productUpdated = $productDAO->getById($productDTO->getId());

        $this->assertInstanceOf(\RamonRibeiro\SuperWaffle\Entity\Product::class, $productUpdated, 'Deve ser uma Product Entity.');
        $this->assertStringContainsString('UPDATE', $productUpdated->getDescription(), 'Deve conter "UPDATE" na descrição.');
    }

    public function testListProductType()
    {
        $productTypeDAO = new ProductTypeDAO();
        $productsType = $productTypeDAO->list();

        $this->assertGreaterThan(0, count($productsType), 'Deve conter 1 ou mais Tipos de Produtos.');
    }

    public function testListProductTax()
    {
        $productTaxDAO = new ProductTaxDAO();
        $productsTax = $productTaxDAO->list();

        $this->assertGreaterThan(0, count($productsTax), 'Deve conter 1 ou mais Taxas de Produtos.');
    }

    public function testListProducts()
    {
        $productDAO = new ProductDAO();
        $products = $productDAO->list();

        $this->assertGreaterThan(0, count($products), 'Deve conter 1 ou mais Produtos.');
    }

    /**
     * @dataProvider productsProvider
     */
    public function testDeleteProduct($idProvider, $priceProvider, $descriptionProvider, $idProductTaxProvider, $idProductTypeProvider): void
    {
        $productDTO = ProductDTO::create(
            id: $idProvider,
            price: $priceProvider,
            description: $descriptionProvider,
            productTax: $idProductTaxProvider,
            productType: $idProductTypeProvider
        );

        $productDAO = new ProductDAO();
        $product = $productDAO->delete($productDTO); //Persist

        $this->assertTrue($product, 'Deve retornar verdadeiro (Produto Apagado).');
    }

    /**
     * @dataProvider productsTypeProvider
     */
    public function testDeleteProductType($id, $description): void
    {
        $productTypeDTO = ProductTypeDTO::create(id: $id, description: $description);

        $productTypeDAO = new ProductTypeDAO();
        $productType = $productTypeDAO->delete($productTypeDTO); //Persist

        $this->assertTrue($productType, 'Deve retornar verdadeiro (ProdutoType Apagado).');
    }

    /**
     * @dataProvider productsTaxesProvider
     */
    public function testDeleteProductTaxes($id, $percent, $description): void
    {
        $productTaxDTO = ProductTaxDTO::create(id: $id, percent: $percent, description: $description);

        $productTaxDAO = new ProductTaxDAO();
        $productTax = $productTaxDAO->delete($productTaxDTO); //Persist

        $this->assertTrue($productTax, 'Deve retornar verdadeiro (ProdutoTax Apagado).');
    }

    public function productsProvider(): array
    {
        return [
            'COPO AMERICANO' => [1, 2.30, 'COPO AMERICANO', 1, 1],
            'TIGELA PORCELANA' => [2, 5.20, 'TIGELA PORCELANA', 1, 1],
            'CANECA PERSONALIZADA' => [3, 10.00, 'CANECA PERSONALIZADA', 1, 1],
            'LARANJA LIMA' => [4, 2.30, 'LARANJA LIMA', 2, 2],
            'CAJU' => [5, 9.90, 'CAJU', 2, 2],
            'PÊRA' => [6, 16.90, 'PÊRA', 2, 2],
            'BOLACHA BAUDUCCO' => [7, 7.30, 'BOLACHA BAUDUCCO', 3, 3],
            'BISCOITO GLOBO' => [8, 9.90, 'BISCOITO GLOBO', 3, 3],
            'OREO' => [9, 7.90, 'OREO', 3, 3],
        ];
    }

    public function productsTaxesProvider(): array
    {
        return [
            'TAXA EM COPOS/PORCELANAS' => [1, 5.00, 'TAXA EM COPOS/PORCELANAS'],
            'TAXA EM FRUTAS' => [2, 7.00, 'TAXA EM FRUTAS'],
            'TAXA EM BISCOITOS' => [3, 10.00, 'TAXA EM BISCOITOS'],
        ];
    }

    public function productsTypeProvider(): array
    {
        return [
            'COPOS/CANECAS/PORCELANAS' => [1, 'COPOS/CANECAS/PORCELANAS'],
            'FRUTAS' => [2, 'FRUTAS'],
            'BISCOITOS' => [3, 'BISCOITOS'],
        ];
    }

    public function productsUpdateProvider(): array
    {
        return [
            'COPO AMERICANO' => [1, 2.30, 'COPO AMERICANO UPDATE', 1, 1],
            'TIGELA PORCELANA' => [2, 5.20, 'TIGELA PORCELANA UPDATE', 1, 1],
            'CANECA PERSONALIZADA' => [3, 10.00, 'CANECA PERSONALIZADA UPDATE', 1, 1],
            'LARANJA LIMA' => [4, 2.30, 'LARANJA LIMA UPDATE', 2, 2],
            'CAJU' => [5, 9.90, 'CAJU UPDATE', 2, 2],
            'PÊRA' => [6, 16.90, 'PÊRA UPDATE', 2, 2],
            'BOLACHA BAUDUCCO' => [7, 7.30, 'BOLACHA BAUDUCCO UPDATE', 3, 3],
            'BISCOITO GLOBO' => [8, 9.90, 'BISCOITO GLOBO UPDATE', 3, 3],
            'OREO' => [9, 7.90, 'OREO UPDATE', 3, 3],
        ];
    }

    public function productsTaxesUpdateProvider(): array
    {
        return [
            'TAXA EM COPOS/PORCELANAS' => [1, 5.00, 'TAXA EM COPOS/PORCELANAS UPDATE'],
            'TAXA EM FRUTAS' => [2, 7.00, 'TAXA EM FRUTAS UPDATE'],
            'TAXA EM BISCOITOS' => [3, 10.00, 'TAXA EM BISCOITOS UPDATE'],
        ];
    }

    public function productsTypeUpdateProvider(): array
    {
        return [
            'COPOS/CANECAS/PORCELANAS' => [1, 'COPOS/CANECAS/PORCELANAS UPDATE'],
            'FRUTAS' => [2, 'FRUTAS UPDATE'],
            'BISCOITOS' => [3, 'BISCOITOS UPDATE'],
        ];
    }
}