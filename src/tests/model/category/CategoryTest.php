<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

use function PHPUnit\Framework\assertEquals;

class CategoryTest extends TestCase {
    function test_Category_constructor_should_not_return_exception(){
        $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $this->assertNotNull($category);
    }
    function test_Category_constructor_categoryName_property_is_null_and_should_throw_NullException(){
        try{
            $category = new Category(Uuid::uuid4(), '',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $this->expectException(NullException::class);
    
        }catch(BaseException $e){
            $this->assertEquals('category name must not be null', $e->getMessage());
        }

    }
    function test_getCategoryName_method(){
        $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $this->assertEquals('Motorsiklet', $category->getCategoryName());
    }
    function test_setProductUuid_method(){
        $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $productUuid = Uuid::uuid4();
        $category->setProductUuid($productUuid);
        $this->assertEquals($productUuid, $category->getProductUuid());
    }
    function test_setProductUuid_parameter_is_null_and_should_throw_NullExceptin(){
        try{
            $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $category->setProductUuid(Null);
            $this->expectException(NullException::class);
    
        }catch(BaseException $e){
            $this->assertEquals('product uuid must not be null', $e->getMessage());
        }
    }
    function test_changeCategoryName_method(){
        $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $category->changeCategoryName('Elektronik');
        $this->assertEquals('Elektronik', $category->getCategoryName());
    }
    function test_changeCategoryName_method_parameter_is_null_and_should_throw_NullException(){
        try{
            $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $category->changeCategoryName(Null);
            $this->expectException(NullException::class);
    
        }catch(BaseException $e){
            $this->assertEquals('new category name must not be null', $e->getMessage());
        }

    }
    function test_changeCategoryName_method_parameter_equal_actual_category_name_and_should_throw_SamePropertyException(){
        try{
            $category = new Category(Uuid::uuid4(), 'Motorsiklet',date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $category->changeCategoryName('Motorsiklet');
            $this->expectException(SamePropertyException::class);
    
        }catch(BaseException $e){
            $this->assertEquals("new category name and actual category name is same which must not be same", $e->getMessage());
        }

    }
}