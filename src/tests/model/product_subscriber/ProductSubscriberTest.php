<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductSubscriberTest extends TestCase {
    function test_ProductSubscriber_constructor_should_not_throw_exception(){
        $productSub = new ProductSubscriber(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date('h'), date('h'));
        $this->assertNotNull($productSub);
    }

    function test_setUserFullName_method_should_not_throw_exception(){
        $productSub = new ProductSubscriber(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date('h'), date('h'));
        $productSub->setUserFullName('John Doe');
        $this->assertEquals('John Doe', $productSub->getUserFullName());
    }
    function test_setUserEmail_method_should_not_throw_exception(){
        $productSub = new ProductSubscriber(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date('h'), date('h'));
        $productSub->setUserEmail('example@gmail.com');
        $this->assertEquals('example@gmail.com',$productSub->getUserEmail());
    }
}