<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserFactoryTest extends TestCase {
    protected UserFactory $userFactory;
    function setUp(): void
    {
        $this->userFactory = new ConcreteUserFactory();
    }
    function test_Create_Instance_Method()
    {
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');

        $user = $this->userFactory->createInstance( 
                $uuid,
                'Hasancan Şahan', 
                'example@gmail.com',
                'password123456',
                false,
                $date, 
                $date
        );
        $user->hashPassword($user->getPassword());
        $hashedPass = $user->getPassword();

        $this->assertEquals($uuid, $user->getUuid());
        $this->assertEquals('Hasancan Şahan', $user->getFullname());
        $this->assertEquals('example@gmail.com', $user->getEmail());
        $this->assertEquals($hashedPass, $user->getPassword());
        $this->assertFalse($user->getIsUserActiveted());
        $this->assertEquals($date, $user->getCreatedAt());
        $this->assertEquals($date, $user->getUpdatedAt());

    }

    function test_Create_Instance_Method_Without_Params(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');

        $user = $this->userFactory->createInstance(null,null,null,null,false,null,null);
        $this->assertNotFalse($user->isNull());
    }
}