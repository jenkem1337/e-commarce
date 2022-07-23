<?php

declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ResponseViewModelTest extends TestCase {
    function test_onSuccess_method(){
        $response = new UserLogedInResponseDto(
            'success',
            Uuid::uuid4(),
            'deneme',
            'deneme',
            'admin',
            uuid::uuid4()
        );
        $response->onSucsess(function($dto){
            $this->assertEquals('deneme', $dto->getFullname());
        });
    }
    function test_onError_method(){
        $response = new ErrorResponseDto('error msg', 404);
        $response->onError(function($err){
            $this->assertEquals('error msg', $err->getErrorMessage());
        });
    }

}