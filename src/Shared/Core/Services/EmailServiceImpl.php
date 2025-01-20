<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class EmailServiceImpl implements EmailService {
    private PHPMailer $phpMailer;

    function __construct(PHPMailer $phpMailer)
    {
        $this->phpMailer =  $phpMailer;
    }

    private function serverOptions(){
        $this->phpMailer->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->phpMailer->isSMTP();                                            //Send using SMTP
        $this->phpMailer->Host       = 'mailhog';
        $this->phpMailer->SMTPAuth   = false;
        $this->phpMailer->Username   = null;
        $this->phpMailer->Password   = null;
        $this->phpMailer->SMTPSecure = false;
        $this->phpMailer->Port       = 1025;
    
    }
    function sendVerificationCode(VerficationCodeEmailDto $user){
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($user->getEmail(), $user->getFullname());
    
            $code = $user->getActivationCode();
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
            $url.=$_SERVER['HTTP_HOST'] ?? "localhost:".$_ENV["APP_PORT"];
            $url.="/auth/verify-user-acc?code=$code";
    
            $this->phpMailer->isHTML();
            $this->phpMailer->Subject = "User Account Mail Verification";
            $this->phpMailer->Body = "Verify your account <br> <a href='$url'>Click For Verify => $url</a>";
            $this->phpMailer->send();
        } catch (Exception $e) {
            echo json_encode(["mailler_err"=>$this->phpMailer->ErrorInfo]);
            throw $e;
        }
    }

    function sendChangeForgettenPasswordEmail(ForgottenPasswordEmailDto $user){
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($user->getEmail(), $user->getFullname());
    
            $code = $user->getForgettenPasswordCode();
    
            $this->phpMailer->isHTML();
            $this->phpMailer->Subject = "User Account Mail Verification";
            $this->phpMailer->Body = "<h1>Forgetten Password Key</h1> <br> <h3>Key => $code</h3>";
            $this->phpMailer->send();

        } catch (Exception $e) {
            echo json_encode(["mailler_err"=>$this->phpMailer->ErrorInfo]);
            throw $e;

        }
    }
    function notifyProductSubscribersForPriceChanged(SendPriceReducedEmailDto $dto){
    
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($dto->getEmail(), $dto->getFullName());
    
            $productSubscriberName = $dto->getFullName();
            $productActualPrice = $dto->getActualPrice();
            $productPreviousPrice = $dto->getOldPrice();
            $productUuid = $dto->getProductUuid();

            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
            $url.=$_SERVER['HTTP_HOST'] ?? "localhost:".$_ENV["APP_PORT"];
            $url.="/products/$productUuid";


            $this->phpMailer->isHTML();
            $this->phpMailer->Subject = "Subscribed Product Price Less Than Before Lets Examine";
            $this->phpMailer->Body = "Hi $productSubscriberName. Your subscribed product price down to $productActualPrice from $productPreviousPrice. Let's examine product from $url.";
            $this->phpMailer->send();
        } catch (Exception $e) {
            echo json_encode(["mailler_err"=>$this->phpMailer->ErrorInfo]);
            throw $e;

        }
    }

    function notifyUserForOrderCreated(OrderCreatedEmailDto $dto){
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($dto->getEmail(), $dto->getFullname());

            $this->phpMailer->isHTML();
            $this->phpMailer->Subject = "We have received your order, and it is being prepared";
            $this->phpMailer->Body = "We have received your order, and it is being prepared";
            $this->phpMailer->send();
        } catch (Exception $e) {
            echo json_encode(["mailler_err"=>$this->phpMailer->ErrorInfo]);
            throw $e;
        }
    }

}