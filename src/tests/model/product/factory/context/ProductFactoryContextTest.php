<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductFactoryContextTest extends TestCase {
    protected ProductFactoryContext $context;
    function setUp():void{
        $this->context = new ProductFactoryContext([
            ProductFactory::class => new ConcreteProductFactory(),
            ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
        ]);
    }

    function test_executeFactory_method_should_return_product_instance(){
        $product = $this->context->executeFactory(
            ProductFactory::class,
            false,
            Uuid::uuid4(),
            'ssss',
            'ssss',
            'sssssssssss',
            'ssssssssssssssssssssss',
            23,
            100,
            new NullRate(),
            date ('Y-m-d H:i:s'),
            date ('Y-m-d H:i:s')
        );
        $this->assertInstanceOf(Product::class, $product);
    }

    function test_executeFactory_method_should_return_product_instance_and_not_instance_of_ProductCategoryCreationalModel_instance(){
        $product = $this->context->executeFactory(
            ProductFactory::class,
            false,
            Uuid::uuid4(),
            'ssss',
            'ssss',
            'sssssssssss',
            'ssssssssssssssssssssss',
            23,
            100,
            new NullRate(),
            date ('Y-m-d H:i:s'),
            date ('Y-m-d H:i:s')
        );
        $this->assertNotInstanceOf(ProductCategoryCreationalModel::class, $product);

    }
}
