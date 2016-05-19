<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

// Simply copy exchange definition from producer
$metadata = new AMQPTable([
    'x-delayed-type' => 'direct',
]);
$channel->exchange_declare(
    'test_delayed_exchange',
    'x-delayed-message',
    false,
    false,
    true,
    false,
    false,
    $metadata
);

// Create metadata with `x-delay` header
$metadata = [
    'application_headers' => new AMQPTable([
        'x-delay' => 10000,
    ]),
];
$message = new AMQPMessage('Hello, phptek16 tutorial!!', $metadata);

$channel->basic_publish(
    $message,
    'test_delayed_exchange', // delayed exchange
    'foo' // use foo as the routing key
);
