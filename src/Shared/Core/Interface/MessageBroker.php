<?php

interface MessageBroker {
    function emit($key, $message);
}