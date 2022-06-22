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
        $this->categoryCollection->add(new Category($uuid->toString(), 'Araba', date ('Y-m-d H:i:s'), date ('Y-m-d H:i:s')));
        $cat =  $this->categoryCollection->getItem($uuid->toString());
        $this->assertEquals($uuid, $cat->getUuid());
        $this->assertEquals('Araba', $cat->getCategoryName());
    }
}