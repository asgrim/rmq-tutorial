<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$channel->exchange_declare(
    'test_topic_exchange',
    'topic'
);

// Correlation ID is a unique request/response pair identifier
$correlation_id = microtime(true) . '_' . getmypid();

// Listen to a temporary response queue
$q = $channel->queue_declare('', false, false, true, true);
$callback_queue = $q[0];
$channel->basic_consume($callback_queue, '', false, false, false, false, function (AMQPMessage $message) use ($correlation_id) {
    if ($message->get('correlation_id') === $correlation_id) {
        echo "Response was: " . $message->body . "\n";
    }
});

// We now add some metadata in here
$metadata = [
    'correlation_id' => $correlation_id,
    'reply_to' => $callback_queue,
];
$message = new AMQPMessage('Hello, PHPNW15 tutorial!!', $metadata);

$routing_key = $argv[1];
$channel->basic_publish(
    $message,
    'test_topic_exchange',
    $routing_key
);

// We need to wait for a response (once)
$channel->wait();
