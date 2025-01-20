<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductTest extends TestCase {
    protected ProductInterface $product;
    function setUp():void {
        $this->product = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(), 'X', 'XYZ', 'X XYZ', "Dünyanın en iyi markası X'in yeni modeli XYZ", 199, 100, date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
    }
    function test_header_property_null_and_should_throw_exception(){
        try {
            $this->product = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(), 'X', 'XYZ', '', "Dünyanın en iyi markası X'in yeni modeli XYZ", 199, 100, date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $this->assertNull($this->product);
            $this->expectException(NullException::class);
        } catch (\Exception $th) {
            $this->assertEquals('header must not be null', $th->getMessage());
        }
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
        $this->product->changeDescription("Dünyanın en en kötü markası X'in yeni modeli XYZ");
        $this->assertEquals("Dünyanın en en kötü markası X'in yeni modeli XYZ", $this->product->getDescription());
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
        $avgRate = $this->product->getAvarageRate();
        $this->assertEquals(3, $avgRate);

    }
    function test_addCategory_method(){
        $this->product = new ProductForCreatingCategoryDecorator();
        $category1 = new Category(Uuid::uuid4(), 'Deneme', date('h'),date('h'));
        $category2 = new Category(Uuid::uuid4(), 'Deneme2', date('h'),date('h'));
        $this->product->addCategory($category1);
        $this->product->addCategory($category2);
        $this->assertEquals(2, count($this->product->getCategories()->getItems()));
    }

    function test_add_category_and_get_category_from_product_model(){
        $this->product = new ProductForCreatingCategoryDecorator();
        $categoryUuid = Uuid::uuid4();
        $category1 = new Category($categoryUuid, 'Deneme', date('h'),date('h'));
        $this->product->addCategory($category1);
        $denemeCategory = $this->product->getCategories()->getItem($categoryUuid);
        $this->assertEquals('Deneme', $denemeCategory->getCategoryName());

    }

    function test_isPriceLessThanPreviousPrice_method_and_should_throw_exception_in_ProductForCreatingCategoryDecorator(){
        $this->expectException(Exception::class);
        $this->product = new ProductForCreatingCategoryDecorator();
        $this->product->isPriceLessThanPreviousPrice();
    }

    function test_addComment_method(){
        $this->product->addComment(new Comment(Uuid::uuid4(),$this->product->getUuid(), Uuid::uuid4(), 'Excelent Product',date('h'),date('h')));
        $this->assertEquals(1, count($this->product->getComments()->getItems()));
    }
    function test_add_comment_and_get_comment_from_product_model(){
        $uuid = Uuid::uuid4();
        $comment = new Comment($uuid,$this->product->getUuid(), Uuid::uuid4(), 'Excelent Product',date('h'),date('h'));
        $this->product->addComment($comment);
        $commentFromProduct = $this->product->getComments()->getItem($uuid);
        $this->assertEquals('Excelent Product', $commentFromProduct->getComment());
    }

    function test_addSubscriber_method(){
        $this->product->addSubscriber(new ProductSubscriber(Uuid::uuid4(), $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h')));
        $this->assertEquals(1, count($this->product->getSubscribers()->getItems()));
    }

    function test_add_subscriber_and_get_subbscriber_from_product(){
        $uuid = Uuid::uuid4();
        $sub = new ProductSubscriber($uuid, $this->product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $this->product->addSubscriber($sub);
        $subFormProduct = $this->product->getSubscribers()->getItem($uuid);
        $this->assertEquals($this->product->getUuid(), $subFormProduct->getProductUuid());
    }

    function test_addImage_method(){
        $this->product->addImage(new Image(Uuid::uuid4(), $this->product->getUuid(), 'deneme.jpg', date('h'),date('h')));
        $this->assertEquals(1, count($this->product->getImages()->getItems()));
    }

    function test_add_image_and_get_image_from_product_model(){
        $uuid = Uuid::uuid4();
        $img = new Image($uuid, $this->product->getUuid(), 'deneme.jpg', date('h'),date('h'));
        $this->product->addImage($img);
        $imgFromProduct = $this->product->getImages()->getItem($uuid);
        $this->assertEquals('deneme.jpg', $imgFromProduct->getImageName());
    }
    function test_changeBrand_method(){
        $this->product->changeBrand('Abibbas');
        $this->assertEquals('Abibbas', $this->product->getBrand());
    }

    function test_changeModel_method(){
        $this->product->changeModel('XNXX-2000');
        $this->assertEquals('XNXX-2000', $this->product->getModel());
    }
}