<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase {
    function test_User_All_Property_Valid(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');
        $user = new User($uuid, 'Hasancan Şahan', 'example@gmail.com','password123456',false,$date, $date);
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

    function test_Uuid4_Doesnt_Equal(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');
        $user = new User($uuid, 'Hasancan Şahan', 'example@gmail.com','password123456',false,$date, $date);
        $anotherUuid4 = Uuid::uuid4();
        $anotherUuid4 = $anotherUuid4->toString();
        $this->assertNotEquals($anotherUuid4, $user->getUuid());
    }

    function test_Setting_UpdatedAt(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');
        
        $user = new User($uuid, 'Hasancan Şahan', 'example@gmail.com','password123456',false,$date, $date);
        $this->assertEquals($date, $user->getUpdatedAt());
        
        $newDate = date ('Y-m-d H:i:s', strtotime('+3 Months'));
        $this->assertNotEquals($newDate,$user->getUpdatedAt());

        $user = new User($uuid, 'Hasancan Şahan', 'example@gmail.com','password123456',false,$date, $newDate);
        $this->assertEquals($newDate, $user->getUpdatedAt());

    }
    function test_Full_Name_Is_Null_And_Must_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, '', 'example@gmail.com','password123456',false,$date, $date);
            $this->expectException(Exception::class);
    
        }catch(Exception $e){
            $this->assertEquals('full name must not be null', $e->getMessage());
        }
    }

    function test_Email_Is_Null_And_Must_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', '','password123456',false,$date, $date);
            $this->expectException(Exception::class);
    
        }catch(Exception $e){
            $this->assertEquals('email must not be null', $e->getMessage());
        }

    }

    function test_Email_Is_Not_Valid_And_Must_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'asdjadkmssad','password123456',false,$date, $date);
            $this->expectException(Exception::class);
    
        }catch(Exception $e){
            $this->assertEquals('email is not valid', $e->getMessage());
        }

    }

    function test_Password_Is_Not_Null_And_Must_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','',false,$date, $date);
            $this->expectException(Exception::class);
    
        }catch(Exception $e){
            $this->assertEquals('password must not be null', $e->getMessage());
        }

    }

    function test_Password_Length_Is_Not_Greater_Than_Six_And_Must_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','12345',false,$date, $date);
            $this->expectException(Exception::class);
    
        }catch(Exception $e){
            $this->assertEquals('password length must be greater than 6', $e->getMessage());
        }

    }

    function test_Password_Comparison_Return_True(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');
        $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
        $user->hashPassword($user->getPassword());
        $passwordFromBody = '123456';
        $this->assertTrue($user->comparePassword($passwordFromBody)); 

    } 

    function test_Password_Comparison_Not_Valid_And_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
            $user->hashPassword($user->getPassword());
            $passwordFromBody = '123456789';
            $user->comparePassword($passwordFromBody);
            $this->expectException(Exception::class);
        }catch(Exception $e){
            $this->assertEquals('password incorrect try again', $e->getMessage());
        }

    }

    function test_Change_Password(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');
        $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
        $user->hashPassword($user->getPassword());
        $newPassword = 'M0r3C00lP4ssw0rd';
        $oldPassword = "123456";
        $user->ChangePassword($oldPassword,$newPassword);
        $this->assertEquals(md5($newPassword), $user->getPassword());
    }
    
    function test_New_Password_Same_With_Old_Password_And_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
            $user->hashPassword($user->getPassword());
            $newPassword = '123456';
            $oldPassword = "123456";
            $user->ChangePassword($oldPassword,$newPassword);
    
            $this->expectException(Exception::class);
        }catch(Exception $e){
            $this->assertEquals('new password and actual password is same which must not be same', $e->getMessage());
        }
    }

    function test_New_Password_Is_Not_Greater_Than_Six_And_Throw_Exception(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
            $user->hashPassword($user->getPassword());
            $newPassword = '123';
            $oldPassword = "123456";
            $user->ChangePassword($oldPassword,$newPassword);
    
            $this->expectException(Exception::class);
        }catch(Exception $e){
            $this->assertEquals('password length must be greater than 6', $e->getMessage());

        }

    }
    function test_Old_Password_And_Actual_Password_Not_Same(){
        try{
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
            $user->hashPassword($user->getPassword());
            $newPassword = '123999999999999999';
            $oldPassword = "12345698123131231";
            $user->ChangePassword($oldPassword,$newPassword);
    
            $this->expectException(Exception::class);
        }catch(Exception $e){
            $this->assertEquals('old password and actual password is not same which is must be same', $e->getMessage());

        }

    }
    
    function test_Is_User_Activated_Setted_True(){
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',true,$date, $date);
            $this->assertTrue($user->getIsUserActiveted());
    }

    function test_User_Role(){
        $uuid = Uuid::uuid4();
        $date = date ('Y-m-d H:i:s');
        $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
        $this->assertEquals('STRAIGHT', $user->getUserRole());
        $user->setUserRole(Role::ADMIN);
        $this->assertEquals('ADMIN', $user->getUserRole());

    }

    function test_Set_User_Role_Empty_String(){
        try {
            $uuid = Uuid::uuid4();
            $date = date ('Y-m-d H:i:s');
            $user = new User($uuid, 'Example Example', 'example@gmail.com','123456',false,$date, $date);
            $user->setUserRole('');
            $this->expectException(Exception::class);
        } catch (Exception $e) {
            $this->assertEquals('user role must not be null',$e->getMessage());
        }
    }
}