<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    // Check some content and throw an exception
    if ($message->body === 'Hello, phptek16 tutorial!!') {
        throw new \Exception("Oh noes!!!!!!!");
    }
    echo $message->body . "\n";

    // New call to basic_ack to acknowledge
    $channel->basic_ack($message->delivery_info['delivery_tag']);
};

// declare a queue with specific name
$queue_name = 'my_acked_queue';
$channel->queue_declare(
    $queue_name, // fix the queue name
    false, // passive - don't check if a queue with the same name exists
    false, // durable - the queue will not survive server restarts
    false, // exclusive - the queue can not be accessed by other channels
    false // autodelete (DEFAULTS TO TRUE)
);

// declare the exchange (topic this time)
$channel->exchange_declare(
    'test_topic_exchange',
    'topic'
);

$binding_key = $argv[1];
echo "Binding queue $queue_name to $binding_key\n";
$channel->queue_bind($queue_name, 'test_topic_exchange', $binding_key);

$channel->basic_consume(
    $queue_name,
    'foo' . getmypid(),
    false,
    false, // no ack - "false" means the handler WILL manually acknowledge message
    false,
    false,
    $handler
);

while (count($channel->callbacks)) {
    $channel->wait();
}
