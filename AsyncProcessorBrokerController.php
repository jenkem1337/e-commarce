<?php

require './vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__, getenv("APP_ENV") == "docker" ? [".env.docker"] : [".env"])->load();
$emailService = new EmailServiceImpl(
    new PHPMailer\PHPMailer\PHPMailer(true)
);
$conf = $conf = new RdKafka\Conf();
// Set a rebalance callback to log partition assignments (optional)
$conf->setRebalanceCb(function (RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
    switch ($err) {
        case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
            echo "Assign: ";
            var_dump($partitions);
            $kafka->assign($partitions);
            break;

         case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
             echo "Revoke: ";
             var_dump($partitions);
             $kafka->assign(NULL);
             break;

         default:
            throw new \Exception($err);
    }
});

// Configure the group.id. All consumer with the same group.id will consume
// different partitions.
$conf->set('group.id', 'async-processor-consumer');

// Initial list of Kafka brokers
$conf->set('metadata.broker.list', $_ENV["KAFKA_HOST"]);

// Set where to start consuming messages when there is no initial offset in
// offset store or the desired offset is out of range.
// 'earliest': start from the beginning
$conf->set('auto.offset.reset', 'earliest');

// Emit EOF event when reaching the end of a partition
$conf->set('enable.partition.eof', 'true');

$consumer = new RdKafka\KafkaConsumer($conf);
$producer = new RdKafka\Producer($conf);
$producer->newTopic('send-register-activation-email');
$producer->newTopic('send-forgetten-password-email');
$producer->newTopic('send-price-less-than-previous-email');
$producer->newTopic('send-order-created-email');
$producer->newTopic('product-search-projection');
// Subscribe to topic 'test'
$consumer->subscribe(
    [
        'send-register-activation-email',
        'send-forgetten-password-email',
        'send-price-less-than-previous-email',
        'send-order-created-email',
        'product-search-projection'
    ]); 

echo "Waiting for partition assignment... (make take some time when\n";
echo "quickly re-joining the group after leaving it.)\n";
$database = MySqlPDOConnection::getInstance();
$pdo = $database->getConnection();
while (true) {
    $message = $consumer->consume(120*1000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            echo var_dump($message);
            if($message->topic_name == "send-register-activation-email"){
                $payload = json_decode($message->payload);
                error_log($payload);
                $emailService->sendVerificationCode(new VerficationCodeEmailDto($payload->fullname, $payload->email, $payload->activationCode));
                return;
            }
            
            if($message->topic_name == 'send-forgetten-password-email') {
                $payload = json_decode($message->payload);
                $emailService->sendChangeForgettenPasswordEmail(new ForgottenPasswordEmailDto($payload->fullname, $payload->email, $payload->forgettenPasswordCode));
                return;
            }
            if($message->topic_name == "send-price-less-than-previous-email"){
                $payload = json_decode($message->payload);
                $emailService->notifyProductSubscribersForPriceChanged(new SendPriceReducedEmailDto($payload->fullname, $payload->email, $payload->productUuid, $payload->newPrice, $payload->oldPrice));
                return;
            }
            if($message->topic_name == "send-order-created-email"){
                $payload = json_decode($message->payload);
                $emailService->notifyUserForOrderCreated(new OrderCreatedEmailDto($payload->orderOwnerName, $payload->email));
                return;
            }
            if($message->topic_name == 'product-search-projection'){
                $payload = json_decode($message->payload);
                try {
                    $stmt = $pdo->prepare("INSERT INTO product_search (product_uuid, brand, model, header, description) VALUES (:uuid, :brand, :model, :header, :description)");
                    $stmt->execute([
                        "uuid" => $payload->productUuid,
                        "brand" => $payload->brand,
                        "model" => $payload->model,
                        "header" => $payload->header,
                        "description" => $payload->description
                    ]);                
                    echo "Product search projection completed\n";
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
            }
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
}
