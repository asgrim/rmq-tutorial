<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

// declare the exchange (type direct)
$channel->exchange_declare(
    'test_direct_exchange',
    'direct'
);

$message = new AMQPMessage('Hello, phptek16 tutorial!!');

// Fetch routing key from CLI param
$routing_key = $argv[1];
$channel->basic_publish(
    $message,
    'test_direct_exchange',
    $routing_key // queue name is back!? This is the ROUTING KEY
);
