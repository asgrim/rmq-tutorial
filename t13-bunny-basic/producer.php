<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \Bunny\Client([
    'host' => '192.168.33.99',
]);
$channel = $connection->connect()->channel();

$channel->exchangeDeclare('bunny_exchange');

$channel->publish('hello bgphp16!', [], 'bunny_exchange');
