<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$metadata = new AMQPTable([
    'x-expires' => 10000, // expire (delete) the queue after 10 seconds
]);
$channel->queue_declare('test_expiring_queue', false, false, false, false, false, $metadata);

$message = new AMQPMessage('Hello, PHPNW15 tutorial!!');

$channel->basic_publish(
    $message,
    '',
    'test_expiring_queue' // queue name change
);
