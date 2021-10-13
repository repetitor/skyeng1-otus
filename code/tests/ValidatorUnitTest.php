<?php

use App\Services\TaskService;
use App\Validators\RateTaskValidator;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ValidatorUnitTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Validators\ValidatorInterface
     */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

        // Do your extra thing here
    }

    private function createValidObject(): void
    {
        $this->validator = new RateTaskValidator();

        $validStudentId = 1; // todo
        $this->validator->setStudentId($validStudentId);

        $validTaskId = 1; // todo
        $this->validator->setTaskId($validTaskId);

        $this->validator->setRating(TaskService::MAX_RATING);
    }

    public function testSuccess()
    {
        $this->createValidObject();

        $result = $this->validator->validate();

        $this->assertTrue($result);
    }

    public function testUnvalidStudent()
    {
        $this->createValidObject();
        $unvalidId = 99999999; //todo
        $this->validator->setStudentId($unvalidId);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function testUnvalidTask()
    {
        $this->createValidObject();
        $unvalidId = 99999999; //todo
        $this->validator->setTaskId($unvalidId);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function testUnvalidRatingLessThanMin()
    {
        $this->createValidObject();
        $this->validator->setRating(TaskService::MIN_RAITNG - 1);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function testUnvalidRatingMoreThanMax()
    {
        $this->createValidObject();
        $this->validator->setRating(TaskService::MAX_RATING + 1);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function tearDown(): void
    {
        // do not remove this function
    }
}
