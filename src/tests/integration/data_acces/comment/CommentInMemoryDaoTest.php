<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CommentInMemoryDaoTest extends TestCase {
    protected CommentInMemoryDaoImpl $dao;
    function setUp():void{
        $this->dao = new CommentInMemoryDaoImpl(SqliteInMemoryConnection::getInstance());
    } 
    function test_not_null_CommentInMemoryDao_instance(){
        $this->assertNotNull($this->dao);
    }
    function test_persist_comment(){
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),Uuid::uuid4(), 'example comment', date('h'), date('h')));
        $this->assertEquals(1 , count($this->dao->findAll()));
    }

    function test_delete_comment(){
        $uuid = Uuid::uuid4();
        $this->dao->persist(new Comment($uuid, Uuid::uuid4(),Uuid::uuid4(), 'example comment', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),Uuid::uuid4(), 'example comment2', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),Uuid::uuid4(), 'example comment3', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),Uuid::uuid4(), 'example comment4', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),Uuid::uuid4(), 'example comment5', date('h'), date('h')));

        $this->dao->deleteByUuid($uuid);
        $this->assertEquals(4 , count($this->dao->findAll()));


    }

    function test_update_comment(){
        
        $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(),Uuid::uuid4(), 'example comment', date('h'), date('h'));
        $this->dao->persist($comment);
        $comment->changeComment('new comment');
        $this->dao->updateByUuid($comment);
        $commentFromDao = $this->dao->findOneByUuid($comment->getUuid());
        $this->assertEquals('new comment', $commentFromDao->comment_text);
    }
    function test_find_all_by_product_uuid(){
        $productUuid = Uuid::uuid4();
        $this->dao->persist(new Comment(uuid::uuid4(), $productUuid,Uuid::uuid4(), 'example comment', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), $productUuid,Uuid::uuid4(), 'example comment2', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), $productUuid,Uuid::uuid4(), 'example comment3', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), $productUuid,Uuid::uuid4(), 'example comment4', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), $productUuid,Uuid::uuid4(), 'example comment5', date('h'), date('h')));
        $this->assertEquals(5, count($this->dao->findAllByProductUuid($productUuid)));
    }
    function test_find_all_by_user_uuid(){
        $userUuid = Uuid::uuid4();
        $this->dao->persist(new Comment(uuid::uuid4(), Uuid::uuid4(),$userUuid, 'example comment', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),$userUuid, 'example comment2', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),$userUuid, 'example comment3', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),$userUuid, 'example comment4', date('h'), date('h')));
        $this->dao->persist(new Comment(Uuid::uuid4(), Uuid::uuid4(),$userUuid, 'example comment5', date('h'), date('h')));
        $this->assertEquals(5, count($this->dao->findAllByUserUuid($userUuid)));

    }

}