<?php

use App\Services\TaskService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SaveStudentRatingApiTest extends TestCase
{
    use DatabaseMigrations;

    const URI = '/api2/v1/student/1/rate-task';

    const VALID_TASK_ID = 1; // TODO

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

        // Do your extra thing here
    }

    public function testSuccessMaxRating()
    {
        $this->post(self::URI, [
            'task' => self::VALID_TASK_ID,
            'rating' => TaskService::MAX_RATING,
        ]);

        $this->assertResponseStatus(200);
    }

    public function testSuccessMinRating()
    {
        $this->post(self::URI, [
            'task' => self::VALID_TASK_ID,
            'rating' => TaskService::MIN_RAITNG,
        ]);

        $this->assertResponseStatus(200);
    }

    public function testLessMinRating()
    {
        $this->post(self::URI, [
            'task' => self::VALID_TASK_ID,
            'rating' => TaskService::MIN_RAITNG - 1,
        ]);

        $this->assertResponseStatus(422);
    }

    public function testMoreMaxRating()
    {
        $this->post(self::URI, [
            'task' => self::VALID_TASK_ID,
            'rating' => TaskService::MAX_RATING + 1,
        ]);

        $this->assertResponseStatus(422);
    }

    public function testEmptyBody()
    {
        $this->post(self::URI);

        $this->assertResponseStatus(500);
    }

    public function tearDown(): void
    {
        // do not remove this function
    }
}
