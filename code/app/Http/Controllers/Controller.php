<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Queue\RabbitMQProducer;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Documentation",
 * )
 */
class Controller extends BaseController
{
    //
    public function asyncRequest( string $command, array $data) : array
    {
        $producer = new RabbitMQProducer();
        $producer->publish($command, $data);

        return [
            'command' => $command,
            'message'=>'Task added to queue',
        ];
    }
}
