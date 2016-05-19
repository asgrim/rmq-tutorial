<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require '../channel.php';

$channel->exchange_declare(
    'test_priority_exchange', // change exchange name here
    'direct' // delete booleans (make equivalent)
);

// Create 3 messages with differing priority
// They should be processed 3, 2, 1 order
for ($i = 1; $i <= 3; $i++) {
    // Metadata with priority here
    $metadata = [
        'priority' => "$i",
    ];

    // apply metadata, as well as including priority in the message (so we can see it)
    $message = new AMQPMessage('Hello, phptek16 tutorial!! [' . $i . ']', $metadata);

    // Modify to "batch" publish - purely to demonstrate another feature while here
    $channel->batch_basic_publish(
        $message,
        'test_priority_exchange', // Update exchange name
        'foo'
    );
}

// Call batch publish here
$channel->publish_batch();
