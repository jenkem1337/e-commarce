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
        $this->phpMailer->Host       = $_ENV['EMAIL_HOST'];                     //Set the SMTP server to send through
        $this->phpMailer->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->phpMailer->Username   = $_ENV['EMAIL'];                    //SMTP username
        $this->phpMailer->Password   = $_ENV['EMAIL_PASSWORD'];                              //SMTP password
        $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption PHPMailer::ENCRYPTION_SMTPS 
        $this->phpMailer->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    }
    function sendVerificationCode(User $user){
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($user->getEmail(), $user->getFullname());
    
            $code = $user->getActivationCode();
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
            $url.=$_SERVER['HTTP_HOST'];
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

    function sendChangeForgettenPasswordEmail(User $user){
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($user->getEmail(), $user->getFullname());
    
            $code = $user->getForegettenPasswordCode();
    
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
            $url.=$_SERVER['HTTP_HOST'] ?? "localhost";
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

    function notifyUserForOrderCreated(PlaceOrderDto $dto){
        try {
            $this->serverOptions();
            
            $this->phpMailer->setFrom($_ENV['EMAIL'], "ADMIN");
            $this->phpMailer->addAddress($dto->getEmail(), $dto->getAddressOwnerSurname());

            $this->phpMailer->isHTML();
            $this->phpMailer->Subject = "We have received your order, and it is being prepared";
            $this->phpMailer->Body = "";
            $this->phpMailer->send();
        } catch (Exception $e) {
            echo json_encode(["mailler_err"=>$this->phpMailer->ErrorInfo]);
            throw $e;
        }
    }

}