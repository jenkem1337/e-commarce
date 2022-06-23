<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductTest extends TestCase {
    protected ProductInterface $product;
    function setUp():void {
        $this->product = new Product(Uuid::uuid4(), 'X', 'XYZ', 'X XYZ', "Dünyanın en iyi markası X'in yeni modeli XYZ", 199, 100, new DefaultRateModel(), date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));

    }
    function test_Product_constructor_should_not_throw_exception(){
        $this->assertNotNull($this->product);
    }

    function test_incrementStockQuantity_method(){
        $this->product->incrementStockQuantity(12);
        $this->assertEquals(112, $this->product->getStockQuantity());
    }
    function test_incrementStockQuantity_method_with_negative_value(){
        $this->product->incrementStockQuantity(-12);
        $this->assertEquals(112, $this->product->getStockQuantity());
    }
    function test_decrementStockQuantity_method(){
        $this->product->decrementStockQuantity(10);
        $this->assertEquals(90, $this->product->getStockQuantity());
    }
    function test_decrementStockQuantity_method_with_negative_value(){
        $this->product->decrementStockQuantity(-100);
        $this->assertEquals(0, $this->product->getStockQuantity());
    }
    function test_decrementStockQuantity_method_should_throw_NegativeValueException(){
        try {        
            $this->product->decrementStockQuantity(-101);
            $this->expectException(NegativeValueException::class);
        } catch (\Exception $e) {
            $this->assertEquals('value must not be negative value', $e->getMessage());
        }
    }
    function test_changePrice_method(){
        $this->product->changePrice(200);
        $this->assertEquals(200, $this->product->getPrice());
        $this->assertEquals(199, $this->product->getPreviousPrice());
    }
    function test_changePrice_method_parameter_same_with_actual_price_and_should_throw_SamePropertyException(){
        try {
            $this->product->changePrice(199.00);
            $this->expectException(SamePropertyException::class);
    
        } catch (\BaseException $e) {
            $this->assertEquals('new price and actual price is same which must not be same', $e->getMessage());
        }
    }
    function test_changePrice_method_parameter_negative_value_and_should_throw_NegativeValueException(){
        try {
            $this->product->changePrice(-199.00);
            $this->expectException(NegativeValueException::class);
    
        } catch (\BaseException $e) {
            $this->assertEquals('value must not be negative value', $e->getMessage());
        }
    }
    function test_isPriceLessThanPreviousPrice_method_should_return_true(){
        $this->product->changePrice(150);
        $bool = $this->product->isPriceLessThanPreviousPrice();
        $this->assertTrue($bool);
        $this->assertNotFalse($bool);
    }
    function test_isPriceLessThanPreviousPrice_method_should_return_false(){
        $this->product->changePrice(250);
        $bool = $this->product->isPriceLessThanPreviousPrice();
        $this->assertNotTrue($bool);
        $this->assertFalse($bool);
    }
    function test_changeHeader_method(){
        $this->product->changeHeader('XYZ X');
        $this->assertEquals('XYZ X', $this->product->getHeader());
    }
    function test_changeHeader_method_parameter_equal_to_actual_value_and_should_throw_SamePropertyException(){
        try {
            $this->product->changeHeader('X XYZ');
            $this->expectException(SamePropertyException::class);
    
        } catch (\BaseException $th) {
            //throw $th;
            $this->assertEquals('new header and actual header is same which must not be same', $th->getMessage());
        }
    }
    function test_changeDescription_method(){
        $this->product->changeDescription("Dünyanın en enkötü markası X'in yeni modeli XYZ");
        $this->assertEquals("Dünyanın en enkötü markası X'in yeni modeli XYZ", $this->product->getDescription());
    }
    function test_changeDescription_method_parameter_equal_to_actual_value_and_should_throw_SamePropertyException(){
        try {
            $this->product->changeDescription("Dünyanın en iyi markası X'in yeni modeli XYZ");
            $this->expectException(SamePropertyException::class);
    
        } catch (\BaseException $th) {
            //throw $th;
            $this->assertEquals('new description and actual description is same which must not be same', $th->getMessage());
        }
    }

    function test_setRate_method(){
        $rate = new Rate(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate->rateIt(4.5);
        
        $this->product->addRate($rate);
        $this->assertNotNull($this->product);
        $rateFromProduct = $this->product->getRates()->getItem($rate->getUuid());
        $this->assertEquals(4.5, $rateFromProduct->getRateNumber());
    }
    function test_calculateAvarageRate_method(){
        $rate = new Rate(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate->rateIt(4);
        $rate2 = new Rate(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate2->rateIt(3);
        $rate3 = new Rate(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate3->rateIt(1);
        $rate4 = new Rate(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate4->rateIt(2);
        $rate5 = new Rate(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate5->rateIt(5);
        $this->product->addRate($rate);
        $this->product->addRate($rate2);
        $this->product->addRate($rate3);
        $this->product->addRate($rate4);
        $this->product->addRate($rate5);

        $this->product->calculateAvarageRate();
        $rateFromProduct = $this->product->getRate();
        $this->assertEquals(3, $rateFromProduct->getAvaregeRate());

    }


}