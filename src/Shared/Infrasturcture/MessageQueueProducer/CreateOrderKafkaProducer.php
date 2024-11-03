<?php

class CreateOrderKafkaProducer implements MessageQueueProducer {
    private RdKafka\Producer $producer;
    function __construct(RdKafka\Producer $producer) {
        $this->producer = $producer;
    }
    function produce($message){
        $topic = $this->producer->newTopic("create-order");
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_decode($message));
        $this->producer->poll(0);

        for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) {
            $result = $this->producer->flush(1000);
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
                break;
            }
        }

        

    }
}