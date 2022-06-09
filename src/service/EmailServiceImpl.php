<?php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class EmailServiceImpl implements EmailService {
    private PHPMailer $phpMailer;

    function __construct(PHPMailer $phpMailer)
    {
        $this->phpMailer =  $phpMailer;
    }
    function sendVerificationCode(User $user){
        try {

            $this->phpMailer->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->phpMailer->isSMTP();                                            //Send using SMTP
            $this->phpMailer->Host       = "smtp.yandex.com.tr";                     //Set the SMTP server to send through
            $this->phpMailer->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->phpMailer->Username   = "denemeexample@yandex.com";                    //SMTP username
            $this->phpMailer->Password   = "cqmtkxplmbrrsbei";                              //SMTP password
            $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption PHPMailer::ENCRYPTION_SMTPS 
            $this->phpMailer->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            $this->phpMailer->setFrom("denemeexample@yandex.com", "ADMIN");
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
            die();
        }
    }

}