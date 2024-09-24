<?php
$conf = new RdKafka\Conf();
$conf->set('metadata.broker.list', 'broker:9092');

$producer = new RdKafka\Producer($conf);
$topic = $producer->newTopic('test_topic');

for ($i = 0; $i < 10; $i++) {
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message $i");
    $producer->poll(0);
}

while ($producer->getOutQLen() > 0) {
    $producer->poll(50);
}

echo "Messages produced successfully!";

