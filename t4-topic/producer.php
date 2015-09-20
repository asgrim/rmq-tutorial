<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

// declare the exchange (type topic)
$channel->exchange_declare(
    'test_topic_exchange',
    'topic'
);

$message = new AMQPMessage('Hello, PHPNW15 tutorial!!');

$routing_key = $argv[1];
$channel->basic_publish(
    $message,
    'test_topic_exchange',
    $routing_key
);
