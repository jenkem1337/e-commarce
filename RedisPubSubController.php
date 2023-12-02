<?php
use Predis\Client;
use PHPMailer\PHPMailer\PHPMailer;
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
$productFactory = new ProductServiceFactory();
$service = $productFactory->createInstance();
$emailService = new EmailServiceImpl(new PHPMailer(true));
$redisConn = new Client('tcp://127.0.0.1:6379'."?read_write_timeout=0");
$queue = $redisConn->pubSubLoop();
print("merhaba bu pubsub log \n");
$queue->subscribe("find-one-product-by-uuid");
$queue->subscribe("price_changed_send_mail");
foreach($queue as $message) {
    if ($message->kind === 'message') {  
        MySqlPDOConnection::getInstance();
        switch ($message->channel) {
            case "find-one-product-by-uuid":
                (new FindOneProductByUuidListener($service, new Client('tcp://127.0.0.1:6379'."?read_write_timeout=0")))->handle($message->payload);
                break;
            case "price_changed_send_mail":
                $data = json_decode($message->payload, true);
                $emailService->notifyProductSubscribersForPriceChanged(new SendPriceReducedEmailDto(
                        $data["subscriber_full_name"],
                        $data["subscriber_email"],
                        $data["product_uuid"],
                        $data["new_price"],
                        $data["old_price"]
                ));
                
                break;
            default:
                # code...
                break;
        }  
    }

}