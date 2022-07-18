<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ImageTest extends TestCase {
    function test_Image_constructor_should_not_throw_exception(){
        $image = new Image(Uuid::uuid4(), Uuid::uuid4(), 'deneme.jpg', date('h'), date('h'));
        $this->assertNotNull($image);
    }
}