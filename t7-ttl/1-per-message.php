<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

$channel->queue_declare(
    'test_queue'
);

// Simply create metadata with `expiration` key - note it must be a string
$metadata = [
    'expiration' => '30000',
];
$message = new AMQPMessage('Hello, phptek16 tutorial!!', $metadata);

$channel->basic_publish(
    $message,
    '',
    'test_queue'
);
