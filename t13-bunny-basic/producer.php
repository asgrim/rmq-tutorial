<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \Bunny\Client([
    'host' => '192.168.33.99',
]);
$channel = $connection->connect()->channel();

$channel->queueDeclare('bunny_queue');
$channel->exchangeDeclare('bunny_exchange');
$channel->queueBind('bunny_queue', 'bunny_exchange');

$channel->publish('hello bgphp16!', [], 'bunny_exchange');
