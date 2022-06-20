<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CategoryCollectionTest extends TestCase {
    protected CategoryCollection $categoryCollection;
    function setUp():void{
        $this->categoryCollection = new CategoryCollection();
    }
    function test_add_method(){
        $uuid = Uuid::uuid4();
        $this->categoryCollection->add(new Category($uuid, 'Araba', date ('Y-m-d H:i:s'), date ('Y-m-d H:i:s')));
        $this->assertEquals($uuid, $this->categoryCollection->getItems()[0]->getUuid());
        $this->assertEquals('Araba', $this->categoryCollection->getItems()[0]->getCategoryName());
    }
    function test_getLastItem_method(){
        $uuid = Uuid::uuid4();
        $this->categoryCollection->add(new Category($uuid, 'Araba', date ('Y-m-d H:i:s'), date ('Y-m-d H:i:s')));
        $this->assertEquals($uuid, $this->categoryCollection->getLastItem()->getUuid());
        $this->assertEquals('Araba', $this->categoryCollection->getLastItem()->getCategoryName());

    }
}