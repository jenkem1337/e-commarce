<?php

require './vendor/autoload.php';

$conf = new RdKafka\Conf();

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

$conf->set('group.id', 'order-saga-consumer');
$conf->set('metadata.broker.list', 'order-saga-broker:9092');
$conf->set('auto.offset.reset', 'latest');
$conf->set('enable.partition.eof', 'true');
$conf->set("enable.auto.commit", "false");

$consumer = new RdKafka\KafkaConsumer($conf);

$consumer->subscribe(['pay-with-CreditCart']);

echo "Waiting for partition assignment... (make take some time when\n";
echo "quickly re-joining the group after leaving it.)\n";

while (true) {
    $message = $consumer->consume(120*1000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            echo $message->payload . "\n";
            echo $message->topic_name;
            $consumer->commit($message);
            break;
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
