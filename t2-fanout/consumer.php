<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    echo $message->body . "\n";
};

// declare a queue without a name
$q = $channel->queue_declare(
    '' // no queue name!
);
$queue_name = $q[0];

// declare the exchange (type fanout)
$channel->exchange_declare(
    'test_fanout_exchange',
    'fanout'
);

// bind the queue to the exchange
$channel->queue_bind($queue_name, 'test_fanout_exchange');

$channel->basic_consume(
    $queue_name, // name of the queue to consume
    'foo' . getmypid(), // use the PID this time
    false,
    true,
    false,
    false,
    $handler
);

while (count($channel->callbacks)) {
    $channel->wait();
}
