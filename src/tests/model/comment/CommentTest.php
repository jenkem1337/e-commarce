<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

use function PHPUnit\Framework\assertNotNull;

class CommentTest extends TestCase {
    function test_Comment_constructor_should_not_throw_exception(){
        $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Deneme yorumu', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $this->assertNotNull($comment);
    }
    function test_changeComment_method_and_should_not_throw_exception(){
        $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Deneme yorumu', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $comment->changeComment('Ürün berbat sakın almayın');
        $this->assertEquals('Ürün berbat sakın almayın', $comment->getComment());
    }
    function test_Comment_constructor_productUuid_parameter_is_null_and_should_throw_NullException(){
        try {
            $comment = new Comment(Uuid::uuid4(), null, Uuid::uuid4(), 'Deneme yorumu', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $this->expectException(NullException::class);
        } catch (\BaseException $e) {
            $this->assertEquals('product uuid must not be null', $e->getMessage());
        }
    }
    function test_Comment_constructor_userUuid_parameter_is_null_and_should_throw_NullException(){
        try {
            $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), null, 'Deneme yorumu', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $this->expectException(NullException::class);
        } catch (\BaseException $e) {
            $this->assertEquals('user uuid must not be null', $e->getMessage());
        }

    }

    function test_Comment_constructor_comment_parameter_is_null_and_should_throw_NullException(){
        try {
            $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), '', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $this->expectException(NullException::class);
        } catch (\BaseException $e) {
            $this->assertEquals('comment must not be null', $e->getMessage());
        }
    }

    function test_changeComment_parameter_is_empty_and_throw_NullException(){
        try {
            $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Deneme yorumu', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $comment->changeComment('');
            $this->expectException(NullException::class);
        } catch (\BaseException $e) {
            $this->assertEquals('new comment must not be null', $e->getMessage());
        }
    }

    function test_changeComment_comment_parameter_is_equal_to_actual_property_and_throw_SamePropertyException(){
        try {
            $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Deneme yorumu', date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $comment->changeComment('Deneme yorumu');
            $this->expectException(SamePropertyException::class);
        } catch (\BaseException $e) {
            $this->assertEquals('new comment and actual comment is same which must not be same', $e->getMessage());
        }

    }
}