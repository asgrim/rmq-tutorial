<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

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

// Metadata using x-delayed-type
$metadata = new AMQPTable([
    'x-delayed-type' => 'direct',
]);
$channel->exchange_declare(
    'test_delayed_exchange', // update exchange name
    'x-delayed-message', // exchange type itself is `x-delayed-message`
    false, // passive
    false, // durable
    true, // auto delete
    false, // internal
    false, // nowait
    $metadata // Add metadata as parameter
);

// Update exchange name
// use 'foo' as the binding key
$channel->queue_bind($queue_name, 'test_delayed_exchange', 'foo');

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
