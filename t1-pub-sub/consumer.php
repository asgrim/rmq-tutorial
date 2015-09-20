<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

// handler will take all messages from the queue
$handler = function(AMQPMessage $message) use ($channel) {
    echo $message->body . "\n";

    // unregisters the callback called "foo"
    //$channel->basic_cancel('foo');
};

// declare the queue exists (if not already)
$channel->queue_declare(
    'test_queue' // name of the queue to create
);

// add a handler to consume the queue
$channel->basic_consume(
    'test_queue', // name of the queue to consume
    'foo', // consumer tag (just an identifier for us)
    false, // no local - "true" means we don't receive messages published by this consumer
    true, // no ack - "true" means the handler does not manually acknowledge message
    false, // exclusive - "true" means that only THIS consumer may access the queue
    false, // no wait - "true" means we don't wait for server to respond (non-blocking, NOT async)
    $handler // the handler..
);

// blocking loop - keep waiting for new messages / handling messages until
// all callbacks are unregistered
while (count($channel->callbacks)) {
    $channel->wait();
}
