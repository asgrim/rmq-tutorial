<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use Clue\React\Stdio\Stdio;
use React\EventLoop\Factory;
use React\Promise;

$loop = Factory::create();
$myClientId = $argv[1]; // use this brutally from CLI params, it's just a demo
$stdio = new Stdio($loop);

(new Client($loop, ['host' => '192.168.33.99']))->connect()->then(function (Client $client) {
    return $client->channel();
})->then(function (Channel $channel) use ($stdio, $loop, $myClientId) {

    // Set up I/O
    $stdio->getReadline()->setPrompt(sprintf('[%s] ', $myClientId));
    $stdio->on('line', function ($line) use ($loop, $channel, $myClientId) {
        if ($line === 'quit') {
            $loop->stop();
        }

        $channel->publish($line, [
            'chatClientId' => $myClientId,
        ], 'bunny_chat_exchange');
    });

    return Promise\all([
        $channel,
        // passive=false, durable=false, exclusive=TRUE!, autoDelete=TRUE!
        $channel->queueDeclare($myClientId, false, false, true, true),
        $channel->exchangeDeclare('bunny_chat_exchange', 'fanout'),
        $channel->queueBind($myClientId, 'bunny_chat_exchange'),
    ]);
})->then(function (array $r) use ($stdio, $myClientId) {
    /** @var Channel $channel */
    $channel = $r[0];
    return $channel->consume(
        function (Message $message, Channel $channel, Client $client) use ($stdio, $myClientId) {
            $clientId = $message->getHeader('chatClientId');
            // No local echo
            if ($clientId !== $myClientId) {
                $stdio->overwrite(sprintf("[%s] %s\n", $clientId, $message->content));
            }
            $channel->ack($message);
        },
        $myClientId
    );
});

$loop->run();
