<?php


namespace App\Queue;

//use App\Exceptions\RabbitMQConsumerException;
//use App\Logger\AppLogger;
//use App\Queue\Jobs\Worker;
use App\Http\Controllers\API\V1\Student\StudentController;
use App\Http\Controllers\API\V1\Aggregation\AggregationController;
use App\Services\AggregationService;
use App\Models\Aggregation;

class RabbitMQConsumer extends RabbitMQ implements QueueConsumerInterface
{
    public function consume(string $command): void
    {
        //$this->validate($command);

        $queueName = $this->generateQueueName($command);

        $this->channel->queue_declare(
            $queueName,
            false,
            true,
            false,
            false
        );

        $this->channel->queue_bind(
            $queueName,
            self::EXCHANGE,
            $command
        );

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume(
            $queueName,
            '',
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function processMessage($msg): void
    {
        $route = $msg->getRoutingKey();
        $data = json_decode($msg->body,1);

        switch ( $route )
        {
            case 'student_task_rate':
                $student_controller = new StudentController();
                $student_controller->insertTaskRating( $data );
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                break;
            case 'student_aggregation_tasks_skills':
                $aggregation_servide = new AggregationService();
                $aggregation_controller = new AggregationController($aggregation_servide);
                $aggregation_controller->aggregateForStudentByType( $data['student_id'], Aggregation::TYPE_TASKS_SKILLS );
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                break;
            case 'student_aggregation_time_today':
                $aggregation_servide = new AggregationService();
                $aggregation_controller = new AggregationController($aggregation_servide);
                $aggregation_controller->aggregateForStudentByType( $data['student_id'], Aggregation::TYPE_TIME_TODAY );
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                break;
            case 'student_aggregation_time_month':
                $aggregation_servide = new AggregationService();
                $aggregation_controller = new AggregationController($aggregation_servide);
                $aggregation_controller->aggregateForStudentByType( $data['student_id'], Aggregation::TYPE_TIME_MONTH );
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                break;
            case 'student_aggregation_courses':
                $aggregation_servide = new AggregationService();
                $aggregation_controller = new AggregationController($aggregation_servide);
                $aggregation_controller->aggregateForStudentByType( $data['student_id'], Aggregation::TYPE_COURSES );
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                break;
            case 'student_receive_awards':
                $student_controller = new StudentController();
                $student_controller->receiveAwards( $data );
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                break;
            default:
                break;
        }

        //AppLogger::addInfo('RabbitMQ:Consumer received message', [$msg->body]);
        /*try {
            echo 'this is from processmessage   ' . $msg;
            $worker = new Worker($msg->body, $msg->getRoutingKey());
            $job = $worker->createJob();
            $job->do();
            if ($job->isCompleted()) {
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                $worker->completed($job);
            } else {
                $msg->delivery_info['channel']->basic_nack($msg->delivery_info['delivery_tag']);
                $worker->fail($job);
            }
        } catch (\Exception $e) {
            AppLogger::addCriticale('RabbitMQ:Consumer ' . $e->getMessage());
            $msg->delivery_info['channel']->basic_nack($msg->delivery_info['delivery_tag']);
        }*/
    }

    /**
     * @param string $routingKey
     *
     * @throws RabbitMQConsumerException
     */
    private function validate(string $routingKey)
    {
        if (!in_array($routingKey, self::ALLOWED_COMMANDS)) {
            throw new RabbitMQConsumerException('Command: ' . $routingKey . ' not supported');
        }
    }

    private function generateQueueName(string $command): string
    {
        return self::NAME . $command;
    }
}
