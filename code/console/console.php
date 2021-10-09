<?php
require_once '../bootstrap/app.php';

use App\Queue\RabbitMQConsumer;

new App\Storage\Database();

$command = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : '';
try {
    $producer = new RabbitMQConsumer();
    $producer->consume($command);
} catch (\Exception $e) {
    print_r($e->getMessage());
    //\App\Logger\AppLogger::addEmergency($e->getMessage());
}
