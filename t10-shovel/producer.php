<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

// Delete metadata, not required
$channel->exchange_declare(
    'test_shovel_src_exchange', // SRC exchange
    'direct', // exchange type update
    false,
    false,
    false, // don't auto delete
    false,
    false
    // Remove metadata parameter
);

// Remove metadata
$message = new AMQPMessage('Hello, bgphp16 tutorial!!');

$channel->basic_publish(
    $message,
    'test_shovel_src_exchange', // Update exchange name
    'foo'
);
