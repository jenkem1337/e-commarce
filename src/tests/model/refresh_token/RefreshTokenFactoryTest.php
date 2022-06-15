<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RefreshTokenFactoryTest extends TestCase {
    protected RefreshTokenFactory $refreshTokenFactory;
    protected RefreshToken $refreshToken;
    function setUp():void{
        $this->refreshTokenFactory = new ConcreteRefreshTokenFactory();
    }

    function test_Create_Instance_Method(){
        $uuid = Uuid::uuid4();
        $userUuid = Uuid::uuid4();
        $this->refreshToken = $this->refreshTokenFactory->createInstance(
            $uuid,
            $userUuid,
            date ('Y-m-d H:i:s'),
            date ('Y-m-d H:i:s')
        );
        $this->assertNotNull($this->refreshToken, "refresh token is null");
        $this->assertEquals($userUuid, $this->refreshToken->getUserUuid());
    }
}