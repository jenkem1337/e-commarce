<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RateInMemoryDaoTest extends TestCase {
    protected RateInMemoryDaoImpl $dao;
    function setUp():void {
        $this->dao = new RateInMemoryDaoImpl(SqliteInMemoryConnection::getInstance());
    }
    function test_persist_rate(){
        $r = new Rate(uuid::uuid4(), uuid::uuid4(), uuid::uuid4(), date('h'), date('h'));
        $r->rateIt(5);
        $this->dao->persist($r);
        $this->assertEquals(1, count($this->dao->findAll()));
    }
    function test_find_one_by_id(){
        $r = new Rate(uuid::uuid4(), uuid::uuid4(), uuid::uuid4(), date('h'), date('h'));
        $r->rateIt(5);
        $this->dao->persist($r);
        $this->assertEquals(5, $this->dao->findOneByUuid($r->getUuid())->rate_num);
    }
    function test_delete(){
        $r = new Rate(uuid::uuid4(), uuid::uuid4(), uuid::uuid4(), date('h'), date('h'));
        $r->rateIt(5);
        $r2 = new Rate(uuid::uuid4(), uuid::uuid4(), uuid::uuid4(), date('h'), date('h'));
        $r2->rateIt(5);
        $r3 = new Rate(uuid::uuid4(), uuid::uuid4(), uuid::uuid4(), date('h'), date('h'));
        $r3->rateIt(5);
        $this->dao->persist($r);
        $this->dao->persist($r3);
        $this->dao->persist($r2);

        $this->dao->deleteRateByUuid($r->getUuid());
        $this->assertEquals(2, count($this->dao->findAll()));
    }
    function test_update_rate_number(){
        $r = new Rate(uuid::uuid4(), uuid::uuid4(), uuid::uuid4(), date('h'), date('h'));
        $r->rateIt(5);
        $this->dao->persist($r);
        $r->rateIt(3);
        $this->dao->updateRateNumberByUuid($r);
        $this->assertNotEquals(5, $this->dao->findOneByUuid($r->getUuid())->rate_num);
        $this->assertEquals(3,$this->dao->findOneByUuid($r->getUuid())->rate_num);

    }
}