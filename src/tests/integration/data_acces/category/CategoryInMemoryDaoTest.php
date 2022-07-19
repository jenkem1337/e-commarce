<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
class CategoryInMemoryDaoTest extends TestCase {
    protected CategoryInMemoryDaoImpl $dao;

    function setUp():void{
        $this->dao = new CategoryInMemoryDaoImpl(new SqliteInMemoryConnection());
    }
    function test_not_null_CategoryInMemoryDao_instance(){
        $this->assertNotNull($this->dao);
    }
    function test_persist_a_category(){
        $this->dao->persist(new Category(Uuid::uuid4(), 'Araba', date('h'), date('h')));
        $categoryCount = count($this->dao->findAll());
        $this->assertEquals(1, $categoryCount);
    }
    function test_delete_category(){
        $airsoftCategory = new Category(Uuid::uuid4(), 'Airsoft', date('h'), date('h'));
        $this->dao->persist(new Category(Uuid::uuid4(), 'Araba', date('h'), date('h')));
        $this->dao->persist(new Category(Uuid::uuid4(), 'Elektronik', date('h'), date('h')));
        $this->dao->persist($airsoftCategory);
       
        $this->dao->deleteByUuid($airsoftCategory->getUuid());
        $categoryCount = count($this->dao->findAll());

        $this->assertEquals(2, $categoryCount);

    }
    function test_find_one_category(){
        $cat = new Category(Uuid::uuid4(), 'Araba', date('h'), date('h'));
        $this->dao->persist($cat);
        $cat = $this->dao->findByUuid($cat->getUuid());
        $this->assertEquals('Araba', $cat->category_name);
    }
    function test_update_by_uuid()
    {
        $category = new Category(Uuid::uuid4(), 'Araba', date('h'), date('h'));
        $this->dao->persist($category);
        $category->changeCategoryName('Elektronik');
        $this->dao->updateNameByUuid($category);
        $categoryFromDao = $this->dao->findByUuid($category->getUuid());
        $this->assertNotEquals('Araba', $categoryFromDao->category_name);
        $this->assertEquals('Elektronik', $categoryFromDao->category_name);
    }
    function test_find_one_nonexistent_category(){
        $this->dao->persist(new Category(Uuid::uuid4(), 'Araba', date('h'), date('h')));
        $nonexistentCategory =  $this->dao->findByUuid(Uuid::uuid4());
        $this->assertNull($nonexistentCategory->category_name);
    }
    
}