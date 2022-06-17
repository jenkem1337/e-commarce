<?php

require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
class BaseExceptionTest extends TestCase {

    function test_Not_Null_Exception(){
        try {
            $testProperty = null;
            if($testProperty == null){
                throw new NullException("testProperty");
            }
            $this->expectException(BaseException::class);
            $this->expectException(NullException::class);
        } catch (\BaseException $e) {
            $this->assertEquals("testProperty must not be null", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
        }
    }
}