<?php
class KafkaConnection implements MessageBroker {
    private static ?KafkaConnection $instance=null;
    private RdKafka\Producer $producer;
    private RdKafka\Conf $conf;
    private function __construct(){
        $this->conf = new RdKafka\Conf();
        $this->conf->set("metadata.broker.list", $_ENV["KAFKA_HOST"]);
        $this->producer = new RdKafka\Producer($this->conf);
    }

    static function getInstance():KafkaConnection{
        if(self::$instance == null){
            self::$instance = new KafkaConnection();
        }
        return self::$instance;
    }
    function emit($key, $message){
        $topic = $this->producer->newTopic($key);


        $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($message));
        $this->producer->poll(0);


        $result = $this->producer->flush(10000);


        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new \RuntimeException('Was unable to flush, messages might be lost!');
        }

    }
}