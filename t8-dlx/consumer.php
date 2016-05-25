<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    echo $message->body . "\n";
    // Remove RPC stuff
    $channel->basic_ack($message->delivery_info['delivery_tag']);
};

// Convert to temporary queue
$q = $channel->queue_declare(
    '',
    false,
    false,
    false,
    true // auto-delete to true
);
$queue_name = $q[0];

$channel->exchange_declare(
    'test_dlx_exchange', // exchange name changes to the DLX exchange
    'fanout' // simply set to fanout
);

// Simplfy (no BK) and also change exchange name
$channel->queue_bind($queue_name, 'test_dlx_exchange');

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
