<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable; // Need this back in

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    echo $message->body . "\n";
    $channel->basic_ack($message->delivery_info['delivery_tag']);
};

// New metadata with max priority
$metadata = new AMQPTable([
    'x-max-priority' => 3,
]);
// Define explicit queue name
$queue_name = 'test_priority_queue';
$channel->queue_declare(
    $queue_name,
    false,
    false,
    false,
    false, // do not auto delete queue (we want to see messages)
    false,
    $metadata // Don't forget metadata
);

$channel->exchange_declare(
    'test_priority_exchange', // update name
    'direct'
);

// Update exchange name here too
$channel->queue_bind($queue_name, 'test_priority_exchange', 'foo');

$channel->basic_consume(
    $queue_name,
    'foo' . getmypid(),
    false,
    false,
    false,
    false,
    $handler
);

while (count($channel->callbacks)) {
    $channel->wait();
}
