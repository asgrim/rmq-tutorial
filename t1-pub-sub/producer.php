<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

// declare the queue exists (if not already)
$channel->queue_declare(
    'test_queue' // name of the queue to create
);

// Create a new AMQPMessage object
// value can be anything - text, json, even binary data
$message = new AMQPMessage('Hello, PHPNW15 tutorial!!');

$channel->basic_publish(
    $message, // the message object we just created
    '', // exchange name - ignore for now
    'test_queue' // name of the queue to publish to
);
