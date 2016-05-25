<?php

use PhpAmqpLib\Message\AMQPMessage;

/** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
$channel = require __DIR__ . '/../channel.php';

$handler = function(AMQPMessage $message) use ($channel) {
    // Remove the exception :)

    echo $message->body . "\n";

    // Simulate some "hard work"
    sleep(3);

    // Copy "request" correlation ID into the response message metadata
    $metadata = [
        'correlation_id' => $message->get('correlation_id'),
    ];
    // Create a response message with the metadata
    $responseMessage = new AMQPMessage('Why hello back...', $metadata);
    // Publish the response message to the queue specified in "reply_to"
    $channel->basic_publish($responseMessage, '', $message->get('reply_to'));

    $channel->basic_ack($message->delivery_info['delivery_tag']);
};

$queue_name = 'my_acked_queue';
$channel->queue_declare(
    $queue_name,
    false,
    false,
    false,
    false
);

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
    false,
    false,
    false,
    $handler
);

while (count($channel->callbacks)) {
    $channel->wait();
}
