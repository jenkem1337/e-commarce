<?php
use Predis\Client;
require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
$productFactory = new ProductServiceFactory();
$service = $productFactory->createInstance();

$redisConn = new Client('tcp://127.0.0.1:6379'."?read_write_timeout=0");
$queue = $redisConn->pubSubLoop();
print("merhaba bu pubsub log \n");
$queue->subscribe("find-one-product-by-uuid");
foreach($queue as $message) {
    if ($message->kind === 'message') {  
        switch ($message->channel) {
            case "find-one-product-by-uuid":
                MySqlPDOConnection::getInsatace()->createDatabaseConnection();
                (new FindOneProductByUuidListener($service, new Client('tcp://127.0.0.1:6379'."?read_write_timeout=0")))->handle($message->payload);
                break;
            default:
                # code...
                break;
        }  
    }

}