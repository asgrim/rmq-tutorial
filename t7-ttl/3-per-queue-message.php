<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$metadata = new AMQPTable([
    'x-message-ttl' => 10000, // expire all messages in the queue after 10s
]);
$channel->queue_declare('test_ttl_queue', false, false, false, false, false, $metadata);

$message = new AMQPMessage('Hello, phptek16 tutorial!!');

$channel->basic_publish(
    $message,
    '',
    'test_ttl_queue' // queue name change
);
