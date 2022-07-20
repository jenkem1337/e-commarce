<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ImageInMemoryDaoTest extends TestCase {
    protected ImageInMemoryDaoImpl $dao;
    
    function setUp():void {
        $this->dao = new ImageInMemoryDaoImpl(SqliteInMemoryConnection::getInstance());
    }
    function test_persist()
    {
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'example.jpg', date('h'), date('h')));
        $this->assertEquals(1, count($this->dao->findAll()));
    }
    function test_delete_by_uuid(){
        $imageUuid = uuid::uuid4();
        $this->dao->persist(new Image($imageUuid, uuid::uuid4(),'example.jpg', date('h'), date('h')));
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'sadasd.jpg', date('h'), date('h')));
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'exaadasdadmple.jpg', date('h'), date('h')));
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'exaaaaacvxcvxcvxcvmple.jpg', date('h'), date('h')));
        $this->dao->deleteByUuid($imageUuid);
        $this->assertEquals(3, count($this->dao->findAll()));
    }
    function test_find_one_by_uuid()
    {
        $imageUuid = uuid::uuid4();
        $this->dao->persist(new Image($imageUuid, uuid::uuid4(),'example.jpg', date('h'), date('h')));
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'sadasd.jpg', date('h'), date('h')));
        $imgFromDao = $this->dao->findOneByUuid($imageUuid);
        $this->assertEquals('example.jpg', $imgFromDao->image_name);
    }
    function test_find_one_by_product_uuid()
    {
        $productUuid = uuid::uuid4();
        $this->dao->persist(new Image(uuid::uuid4(), $productUuid,'sadasd.jpg', date('h'), date('h')));
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'gdfgdfgsdfg.jpg', date('h'), date('h')));
        $this->dao->persist(new Image(uuid::uuid4(), uuid::uuid4(),'sareterweedasd.jpg', date('h'), date('h')));
        $imgFromDao = $this->dao->findImageByProductUuid($productUuid);
        $this->assertEquals('sadasd.jpg', $imgFromDao->image_name);
    }
}