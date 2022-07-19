<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RateTest extends TestCase {
    function test_Rate_Constructor_should_not_throw_exception(){
        $rate = new Rate(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $this->assertNotNull($rate);   
    }
    function test_setHowManyPeopleRateIt_method(){
        $rate = new Rate(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $rate->setHowManyPeopleRateIt(10);
        $this->assertEquals(10, $rate->getHowManyPeopleRateIt());
    }
    
    function test_setRate_method(){
        $rate = new Rate(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
        $rate->rateIt(4.9);
        $this->assertEquals(4.9, $rate->getRateNumber());
    }
    function test_setRate_method_property_less_than_zero_and_should_throw_NegativeValueException(){
        try {
            $rate = new Rate(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $rate->rateIt(-0.01);
        } catch (\BaseException $e) {
            $this->assertEquals('value must not be negative value', $e->getMessage());
        }
    }
    function test_setRate_method_property_greater_than_five_and_should_throw_LengthMustBeGreaterThanException(){
        try {
            $rate = new Rate(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), date ('Y-m-d H:i:s'),date ('Y-m-d H:i:s'));
            $rate->rateIt(5.01);
        } catch (\BaseException $e) {
            $this->assertEquals('rate number value must be less than 5', $e->getMessage());
        }
    }


    
}