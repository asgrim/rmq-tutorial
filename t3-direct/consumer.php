<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    echo $message->body . "\n";
};

$q = $channel->queue_declare(
    ''
);
$queue_name = $q[0];

// declare the exchange (direct this time)
$channel->exchange_declare(
    'test_direct_exchange',
    'direct'
);

// bind the queue to the exchange - note we now use BINDING KEY
$binding_key = $argv[1];
echo "Binding queue $queue_name to $binding_key\n";
$channel->queue_bind($queue_name, 'test_direct_exchange', $binding_key);

$channel->basic_consume(
    $queue_name,
    'foo' . getmypid(),
    false,
    true,
    false,
    false,
    $handler
);

while (count($channel->callbacks)) {
    $channel->wait();
}
