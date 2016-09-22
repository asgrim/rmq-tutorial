<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \Bunny\Client([
    'host' => '192.168.33.99',
]);
$channel = $connection->connect()->channel();

// Change exchange name
$channel->exchangeDeclare('bunny_react_exchange');

// and here
$channel->publish('hello bgphp16!', [], 'bunny_react_exchange');
