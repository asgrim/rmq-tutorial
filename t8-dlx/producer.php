<?php

// BASED OFF: t7-ttl/3-per-queue-message.php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

$metadata = new AMQPTable([
    'x-message-ttl' => 10000,
    'x-dead-letter-exchange' => 'test_dlx_exchange', // Add name of DLX exchange
    // 'x-dead-letter-routing-key' => 'blah'
]);
$channel->queue_declare('test_dlx_queue', false, false, false, false, false, $metadata);

$message = new AMQPMessage('Hello, bgphp16 tutorial!!');

$channel->basic_publish(
    $message,
    '',
    'test_dlx_queue' // queue name change
);
