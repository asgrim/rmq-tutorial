<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    echo $message->body . "\n";
    $channel->basic_ack($message->delivery_info['delivery_tag']);
};

$q = $channel->queue_declare(
    '',
    false,
    false,
    false,
    true
);
$queue_name = $q[0];

// Remove metadata, not needed any more
$channel->exchange_declare(
    'test_shovel_dest_exchange', // Set DEST exchange name
    'direct' // Change to direct
    // Remove last params
);

// Update exchange name
$channel->queue_bind($queue_name, 'test_shovel_dest_exchange', 'foo');

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
