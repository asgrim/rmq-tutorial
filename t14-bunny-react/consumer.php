<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use React\EventLoop\Factory;
use React\Promise;

$loop = Factory::create();

(new Client($loop, ['host' => '192.168.33.99']))->connect()->then(function (Client $client) {
    return $client->channel();
})->then(function (Channel $channel) {
    return Promise\all([
        $channel,
        $channel->queueDeclare('bunny_react_queue'),
        $channel->exchangeDeclare('bunny_react_exchange'),
        $channel->queueBind('bunny_react_queue', 'bunny_react_exchange'),
    ]);
})->then(function (array $r) {
    /** @var Channel $channel */
    $channel = $r[0];
    return $channel->consume(
        function (Message $message, Channel $channel, Client $client) {
            echo $message->content . "\n";
            $channel->ack($message);
        },
        'bunny_react_queue'
    );
});

$loop->run();
