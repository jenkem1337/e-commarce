<?php

interface MessageQueueProducer {
    function produce($message);
}