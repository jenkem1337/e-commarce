<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserFactoryTest extends TestCase {
    protected UserFactory $userFactory;
    protected User $user;
    function setUp(): void
    {
        $this->userFactory = new ConcreteUserFactory();
    }
    function test_Create_Instance_Method()
    {
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');

        $this->user = $this->userFactory->createInstance( 
                $uuid,
                'Hasancan Şahan', 
                'example@gmail.com',
                'password123456',
                false,
                $date, 
                $date
        );
        $this->user->hashPassword($this->user->getPassword());
        $hashedPass = $this->user->getPassword();

        $this->assertEquals($uuid, $this->user->getUuid());
        $this->assertEquals('Hasancan Şahan', $this->user->getFullname());
        $this->assertEquals('example@gmail.com', $this->user->getEmail());
        $this->assertEquals($hashedPass, $this->user->getPassword());
        $this->assertFalse($this->user->getIsUserActiveted());
        $this->assertEquals($date, $this->user->getCreatedAt());
        $this->assertEquals($date, $this->user->getUpdatedAt());

    }
}